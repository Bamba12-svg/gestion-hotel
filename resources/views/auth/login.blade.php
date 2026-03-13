<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion — Gestion Hôtel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1c4a, #2b2e7a, #1a1c4a);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            color: #e0e0e0;
        }
        .form-control {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            color: #e0e0e0;
            border-radius: 10px;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.1);
            color: #e0e0e0;
            border-color: #6c8aff;
            box-shadow: 0 0 0 0.2rem rgba(108,138,255,0.25);
        }
        .form-control::placeholder { color: rgba(255,255,255,0.3); }
        label { color: #c0c8e0; }
        .btn-login {
            background: linear-gradient(135deg, #6c8aff, #a78bfa);
            border: none;
            color: #fff;
            border-radius: 10px;
            font-weight: bold;
            letter-spacing: 1px;
            transition: opacity 0.3s;
        }
        .btn-login:hover { opacity: 0.85; color: #fff; }
        .alert-danger {
            background: rgba(248,113,113,0.1);
            border-color: #f87171;
            color: #f87171;
            border-radius: 10px;
        }
        .hotel-title {
            font-size: 1.8rem;
            font-weight: bold;
            background: linear-gradient(90deg, #6c8aff, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .subtitle { color: rgba(255,255,255,0.45); font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="col-md-4 col-sm-10 col-11">
        <div class="card shadow-lg p-4">

            {{-- Logo / Titre --}}
            <div class="text-center mb-4">
                <div style="font-size: 3rem;">🏨</div>
                <div class="hotel-title">Gestion Hôtel</div>
                <div class="subtitle">Connectez-vous pour continuer</div>
            </div>

            {{-- Erreurs --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Formulaire --}}
            <form method="POST" action="/login">
                @csrf
                <div class="mb-3">
                    <label class="mb-1">📧 Email</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@hotel.com" required>
                </div>
                <div class="mb-4">
                    <label class="mb-1">🔑 Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-login w-100 py-2">
                    Se connecter →
                </button>
            </form>

        </div>
    </div>
</body>
</html>