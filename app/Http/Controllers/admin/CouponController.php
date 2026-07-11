<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Coupon;

class CouponController extends Controller
{
    /**
     * عرض صفحة الـ Coupons مع جلب البيانات
     */
    public function index()
    {
        $coupons = Coupon::latest()->get();

        // Coupons actifs
        $couponsActifs = Coupon::where('is_active', true)
            ->whereDate('date_expiration', '>=', now())
            ->where(function ($query) {
                $query->whereNull('limite_utilisation')
                    ->orWhereColumn('total_utilisations', '<', 'limite_utilisation');
            })
            ->count();

        // Coupons expirés ou ayant atteint leur limite
        $couponsExpires = Coupon::where(function ($query) {
            $query->whereDate('date_expiration', '<', now())
                ->orWhereColumn('total_utilisations', '>=', 'limite_utilisation');
        })->count();

        return view('admin.coupons.index', compact(
            'coupons',
            'couponsActifs',
            'couponsExpires'
        ));
    }

    /**
     * تسجيل كود برومو جديد ف الـ Base de données
     */
    public function store(Request $request)
    {
        // 1. الـ Validation ديال المعطيات باش السيستيم يكون آمن ويلا نسى الـ Admin شي حاجة
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:pourcentage,fixe',
            'valeur' => 'required|numeric|min:1',
            'montant_minimum' => 'nullable|numeric|min:0',
            'limite_utilisation' => 'nullable|integer|min:1',
            'date_expiration' => 'required|date|after_or_equal:today',
        ]);

        // 2. إدخال البيانات ف الـ Table 'coupons'
        DB::table('coupons')->insert([
            'code' => strtoupper($request->code), // ردينا الكود ديما حروف كبار CAPITAL
            'type' => $request->type,
            'valeur' => $request->valeur,
            'montant_minimum' => $request->montant_minimum ?? 0,
            'limite_utilisation' => $request->limite_utilisation,
            'total_utilisations' => 0,
            'date_expiration' => $request->date_expiration,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. رجوع للوراء مع رسالة نجاح لي ديجا غاتبان ف الـ Layout ديالك
        return redirect()->back()->with('success', 'Le code promo a été créé avec succès !');
    }

    /**
     * مسح كود برومو
     */
    public function destroy($id)
    {
        DB::table('coupons')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Le coupon a été supprimé !');
    }
}
