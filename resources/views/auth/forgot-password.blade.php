<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Parapharmacie</title>

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
                <div class="text-center mb-3">
                    <div class="logo">
                        <i class="bi bi-capsule-pill"></i> Parapharmacie
                    </div>
                    <p class="text-muted small">
                        Enter your email and we’ll send you a reset link
                    </p>
                </div>

                <!-- Success message -->
                @if (session('status'))
                    <div class="alert alert-success text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email') }}" required autofocus>
                        </div>

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-custom">
                            <i class="bi bi-send"></i> Send Reset Link
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

</body>
</html>