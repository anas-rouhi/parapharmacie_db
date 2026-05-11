<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Register - Parapharmacie</title>

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
        <div class="col-md-5">

            <div class="card shadow p-4">

                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="logo">
                        <i class="bi bi-capsule-pill"></i> ParaSante
                    </div>
                    <p class="text-muted">Créer votre compte</p>
                </div>

                <!-- Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">Nom complet</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-shield-lock"></i>
                            </span>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-custom">
                            <i class="bi bi-person-plus"></i> Créer mon compte
                        </button>
                    </div>

                </form>

                <!-- Login -->
                <p class="text-center mt-4 text-muted">
                    Déjà inscrit ?
                    <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">
                        Se connecter
                    </a>
                </p>

            </div>

        </div>
    </div>
</div>

</body>
</html>