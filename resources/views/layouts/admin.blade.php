<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Parapharmacie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #121212; color: #fff; }
        .sidebar { min-height: 100vh; background-color: #1e1e1e; border-right: 1px solid #333; }
        .sidebar a { color: #ccc; text-decoration: none; display: block; padding: 15px; }
        .sidebar a:hover { background-color: #333; color: #fff; }
        .card { background-color: #1e1e1e !important; color: white !important; border: 1px solid #333; }
    </style>
</head>
<body class="bg-gray-900 text-white font-[Inter]">>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar p-0">
                <h4 class="p-3 text-primary">Dataflow</h4>
                <a href="#">Ecommerce</a>
                <a href="#">Product</a>
                <a href="#">Category</a>
                <a href="#">Order</a>
                <hr>
                <a href="#">Log Out</a>
            </div>

            <div class="col-md-10 p-4">
                {{ $slot }} </div>
        </div>
    </div>
</body>
</html>