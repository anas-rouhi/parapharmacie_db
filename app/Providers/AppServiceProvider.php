<?php

namespace App\Providers;

use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Mail\Transport\ResendTransport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Resend\Client as ResendClient;
use Resend\Transporters\HttpTransporter;
use Resend\ValueObjects\ApiKey;
use Resend\ValueObjects\Transporter\BaseUri;
use Resend\ValueObjects\Transporter\Headers;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 🔐 Chemin du bundle de certificats (CA).
        // Sur certaines installations (WAMP/XAMPP sous Windows), PHP n'a AUCUN bundle CA
        // configuré → toute requête HTTPS échoue avec :
        //   « cURL error 60: SSL certificate problem: unable to get local issuer certificate »
        // On utilise le CA du système s'il existe, sinon celui fourni par composer/ca-bundle
        // (vendor/composer/ca-bundle/res/cacert.pem). Aucune modification de php.ini requise.
        $this->app->singleton('ca.bundle', fn () => CaBundle::getSystemCaRootBundlePath());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        $this->registerResendMailer();
    }

    /**
     * Redéclare le transport mail "resend" pour lui injecter notre bundle CA.
     *
     * Le SDK Resend fait `new GuzzleClient()` sans options : impossible de lui passer
     * un certificat. On reconstruit donc le client à l'identique, mais avec l'option
     * `verify` pointée sur notre cacert.pem.
     *
     * ⚠️ On garde bien la vérification SSL ACTIVÉE (on ne fait pas `verify => false`,
     * qui exposerait l'application aux attaques de type "man-in-the-middle").
     */
    protected function registerResendMailer(): void
    {
        Mail::extend('resend', function (array $config) {
            $apiKey = $config['key'] ?? config('services.resend.key');

            $guzzle = new GuzzleClient([
                'verify' => $this->app->make('ca.bundle'),
            ]);

            $transporter = new HttpTransporter(
                $guzzle,
                BaseUri::from(getenv('RESEND_BASE_URL') ?: 'api.resend.com'),
                Headers::withAuthorization(ApiKey::from($apiKey)),
            );

            return new ResendTransport(new ResendClient($transporter));
        });
    }
}
