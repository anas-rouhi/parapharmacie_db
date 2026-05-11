<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Email Verification - Parapharmacie</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #e8f5e9, #ffffff);
            height: 100vh;
        }
        .card {
            border-radius: 15px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2e7d32;
        }
        .btn-custom {
            background-color: #2e7d32;
            color: white;
        }
        .btn-custom:hover {
            background-color: #1b5e20;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow p-4 text-center">

                <!-- Header -->
                <div class="mb-3">
                    <div class="logo">
                        <i class="bi bi-capsule-pill"></i> ParaSante
                    </div>
                </div>

                <!-- Message -->
                <p class="text-muted">
                    Merci pour votre inscription 💊<br>
                    Veuillez vérifier votre adresse email en cliquant sur le lien envoyé.
                </p>

                <!-- Success -->
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success">
                        Un nouveau lien de vérification a été envoyé à votre email.
                    </div>
                @endif

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-4">

                    <!-- Resend -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-custom">
                            <i class="bi bi-envelope-arrow-up"></i> Renvoyer l'email
                        </button>
                    </form>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>