<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport d'Activite ParaAdmin</title>
    <style>
        @page { margin: 40px; }
        body { font-family: 'Helvetica', Arial, sans-serif; color: #1e293b; line-height: 1.4; margin: 0; padding: 0; font-size: 13px; }
        .header { border-bottom: 3px solid #22c55e; padding-bottom: 15px; margin-bottom: 30px; }
        .logo { font-size: 26px; font-weight: bold; color: #16a34a; text-transform: uppercase; letter-spacing: 1px; float: left; }
        .date { float: right; font-size: 11px; color: #94a3b8; margin-top: 10px; }
        .title { font-size: 16px; color: #64748b; margin-top: 5px; clear: both; padding-top: 5px; }
        .clear { clear: both; }
        
        /* 📊 إصلاح كروت الإحصائيات بالجداول لمنع التداخل */
        .stats-table { width: 100%; margin-bottom: 25px; border-spacing: 10px; margin-left: -10px; }
        .card { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px; width: 50%; vertical-align: top; }
        .card-title { font-size: 10px; color: #64748b; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
        .card-value { font-size: 18px; font-weight: bold; color: #0f172a; margin-top: 5px; }
        
        /* 📝 الجدول الرئيسي */
        .section-title { color: #0f172a; border-left: 4px solid #16a34a; padding-left: 8px; font-size: 16px; margin-bottom: 15px; margin-top: 10px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th { background-color: #f8fafc; color: #64748b; font-size: 11px; font-weight: bold; text-transform: uppercase; padding: 10px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        table.data-table td { padding: 10px; font-size: 12px; border-bottom: 1px solid #f1f5f9; }
        .badge { background-color: #dff6e7; color: #15803d; font-weight: bold; padding: 3px 8px; border-radius: 4px; font-size: 11px; text-transform: uppercase; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">ParaAdmin</div>
        <div class="date">Genere le: {{ $date }}</div>
        <div class="title">Rapport Officiel de Performance & Ventes</div>
    </div>

    <div class="section-title">Indicateurs Cles de Performance</div>
    
    <table class="stats-table">
        <tr>
            <td class="card">
                <div class="card-title">Chiffre d'Affaires Cumule</div>
                <div class="card-value">{{ number_format($totalRevenu, 2) }} DH</div>
            </td>
            <td class="card">
                <div class="card-title">Estimation Marge (30%)</div>
                <div class="card-value" style="color: #16a34a;">{{ number_format($totalBenefice, 2) }} DH</div>
            </td>
        </tr>
        <tr>
            <td class="card">
                <div class="card-title">Volume Total Commandes</div>
                <div class="card-value">{{ $totalCommandes }} Actions</div>
            </td>
            <td class="card">
                <div class="card-title">Commandes Livrees & Cloturees</div>
                <div class="card-value">{{ $commandesLivrees }} Livraisons</div>
            </td>
        </tr>
    </table>

    <div class="section-title">Liste des Transactions Recentes</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 10%;">Ref</th>
                <th style="width: 25%;">Client</th>
                <th style="width: 35%;">Adresse</th>
                <th style="width: 18%;">Montant</th>
                <th style="width: 12%;">Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
                <tr>
                    <td style="font-weight: bold; color: #16a34a;">#{{ $order->id }}</td>
                    <td>{{ $order->nom_complet }}</td>
                    <td style="color: #64748b;">{{ $order->adresse }}</td>
                    <td style="font-weight: bold;">{{ number_format($order->total, 2) }} DH</td>
                    <td><span class="badge">{{ $order->status }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>