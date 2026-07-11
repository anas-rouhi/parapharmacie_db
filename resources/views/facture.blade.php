<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $commande->id }}</title>
    <style>
        @page {
            margin: 0px;
        }
        body { 
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; 
            color: #2b2d42; 
            line-height: 1.6; 
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .invoice-container {
            padding: 50px;
        }
        /* Top Green Bar for Professional Look */
        .top-bar {
            height: 8px;
            background-color: #10b981; /* الأخضر ديال البارافارماسي */
            width: 100%;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .logo-area {
            font-size: 28px;
            font-weight: 800;
            color: #064e3b;
            letter-spacing: 1px;
        }
        .logo-area span {
            color: #10b981;
        }
        .company-subtitle {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 2px;
        }
        .invoice-title-area {
            text-align: right;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            text-transform: uppercase;
            margin: 0;
        }
        .invoice-number {
            font-size: 14px;
            color: #4b5563;
            margin-top: 5px;
        }
        /* Details Section */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .details-box {
            width: 48%;
            vertical-align: top;
            background: #f9fafb;
            border: 1px solid #f3f4f6;
            border-radius: 8px;
            padding: 20px;
        }
        .details-box h3 {
            font-size: 12px;
            text-transform: uppercase;
            color: #10b981;
            margin-top: 0;
            margin-bottom: 10px;
            letter-spacing: 1px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .details-text {
            font-size: 13px;
            color: #374151;
            html-line-height: 1.8;
        }
        /* Table Styling */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #064e3b;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 15px;
            text-align: left;
        }
        .items-table th.text-right, .items-table td.text-right {
            text-align: right;
        }
        .items-table th.text-center, .items-table td.text-center {
            text-align: center;
        }
        .items-table td {
            padding: 15px;
            font-size: 13px;
            border-bottom: 1px solid #e5e7eb;
            color: #1f2937;
        }
        .items-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .product-name {
            font-weight: 600;
            color: #111827;
        }
        /* Summary Section */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .summary-space {
            width: 55%;
        }
        .summary-box {
            width: 45%;
            vertical-align: top;
        }
        .summary-row {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-row td {
            padding: 8px 15px;
            font-size: 13px;
        }
        .total-row {
            background-color: #ecfdf5;
            border-top: 2px solid #10b981;
        }
        .total-row td {
            font-size: 16px;
            font-weight: 700;
            color: #064e3b;
            padding: 12px 15px;
        }
        /* Notice & Footer */
        .payment-method {
            margin-top: 40px;
            font-size: 12px;
            color: #4b5563;
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 15px;
            border-radius: 0 8px 8px 0;
        }
        .footer {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
            margin-left: 50px;
            margin-right: 50px;
        }
    </style>
</head>
<body>

    <div class="top-bar"></div>

    <div class="invoice-container">
        
        <table class="header-table">
            <tr>
                <td>
                    <div class="logo-area">Para<span>Pharmacy</span></div>
                    <div class="company-subtitle">Santé & Bien-être en un clic</div>
                </td>
                <td class="invoice-title-area">
                    <h1 class="invoice-title">FACTURE</h1>
                    <div class="invoice-number">N° : <strong>#{{ $commande->id }}</strong></div>
                    <div class="invoice-number">Date : {{ $commande->created_at->format('d/m/Y') }}</div>
                </td>
            </tr>
        </table>

        <table class="details-table">
            <tr>
                <td class="details-box" style="margin-right: 4%;">
                    <h3>Émetteur</h3>
                    <div class="details-text">
                        <strong>ParaPharmacy Maroc S.A.R.L</strong><br>
                        Boulevard Mohammed V, Bureau 42<br>
                        40000 Marrakech, Maroc<br>
                        Tel: +212 5 22 00 00 00<br>
                        Email: contact@parapharmacie.com
                    </div>
                </td>
                <td class="details-box">
                    <h3>Destinataire</h3>
                    <div class="details-text">
                        <strong>{{ $commande->nom_complet }}</strong><br>
                        Adresse: {{ $commande->adresse }}<br>
                        Téléphone: {{ $commande->telephone }}<br>
                        @if($commande->user)
                            Email: {{ $commande->user->email }}
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Désignation du Produit</th>
                    <th class="text-center" style="width: 15%;">Prix Unitaire</th>
                    <th class="text-center" style="width: 15%;">Quantité</th>
                    <th class="text-right" style="width: 20%;">Montant HT</th>
                </tr>
            </thead>
         <tbody>
                @if(isset($commande->items) && $commande->items->count() > 0)
                    @foreach($commande->items as $item)
                        <tr>
                          <td>
                                <div class="product-name" style="font-size: 14px;">{{ $item->produit->nom ?? 'Produit' }}</div>
                                
                                {{-- 🔥 التعديل السحري: الشرط دبا كيتحقق واش المنتج فلاش سال + واش الكليان شراه بالثمن ديال الباك --}}
                                @if(($item->produit->is_flash_sale ?? 0) == 1 && $item->price == $item->produit->prix_flash && !empty($item->produit->pack_products))
                                    <div style="margin-top: 5px; padding: 6px 10px; background-color: #f0fdf4; border-left: 2px solid #10b981; border-radius: 4px; max-w-xs;">
                                        <span style="font-size: 10px; font-weight: bold; color: #064e3b; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 3px;">
                                            🎁 Composition du Pack :
                                        </span>
                                        @php
                                            $pdfSubProducts = is_array($item->produit->pack_products) ? $item->produit->pack_products : json_decode($item->produit->pack_products, true);
                                        @endphp
                                        @if(!empty($pdfSubProducts))
                                            <ul style="margin: 0; padding-left: 12px; list-style-type: square; color: #374151; font-size: 11px;">
                                                @foreach($pdfSubProducts as $pdfSub)
                                                    <li style="margin-bottom: 2px;">
                                                        {{ $pdfSub['nom'] ?? $pdfSub }} 
                                                        @if(isset($pdfSub['quantite'])) (x{{ $pdfSub['quantite'] }}) @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">{{ number_format($item->price, 2) }} DH</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">{{ number_format($item->price * $item->quantity, 2) }} DH</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" style="text-align: center; color: #9ca3af; font-style: italic;">
                            Aucun détail d'article trouvé pour cette commande dans la base de données.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        <table class="summary-table">
            <tr>
                <td class="summary-space">
                    <div class="payment-method">
                        <strong>Mode de Règlement :</strong> Paiement Cash à la Livraison (COD)<br>
                        <span style="font-size: 11px; color: #6b7280;">Le colis sera livré sous 24h/48h. Veuillez préparer le montant exact.</span>
                    </div>
                </td>
                <td class="summary-box">
                    @php
                        $remise = $commande->discount_amount ?? 0;
                        $sousTotal = $commande->total + $remise; // الطوطال قبل الريميز
                    @endphp
                    <table class="summary-row">
                        <tr>
                            <td>Sous-Total :</td>
                            <td class="text-right">{{ number_format($sousTotal, 2) }} DH</td>
                        </tr>

                        @if($commande->coupon_code)
                            <tr>
                                <td style="color: #059669;">
                                    Code Promo :
                                    <strong>{{ $commande->coupon_code }}</strong>
                                    @if($commande->coupon_type === 'pourcentage')
                                        ({{ (float) $commande->coupon_value }}%)
                                    @else
                                        ({{ number_format($commande->coupon_value, 2) }} DH)
                                    @endif
                                </td>
                                <td class="text-right" style="color: #059669; font-weight: 700;">
                                    - {{ number_format($remise, 2) }} DH
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td>Frais de port :</td>
                            <td class="text-right" style="color: #10b981; font-weight: 600;">Gratuit</td>
                        </tr>
                        <tr class="total-row">
                            <td>Total Net à Payer :</td>
                            <td class="text-right">{{ number_format($commande->total, 2) }} DH</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer">
            ParaPharmacy Maroc - S.A.R.L au capital de 100.000 DH - RC 12345 - IF 678910 - Patente 112233<br>
            Merci pour votre confiance. Pour toute réclamation, veuillez nous contacter sous un délai de 3 jours.
        </div>

    </div>

</body>
</html>