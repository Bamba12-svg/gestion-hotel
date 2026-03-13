@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h2 class="fw-bold mb-1">Paramètres</h2>
        <p class="text-muted mb-0">Gérez votre profil et la sécurité de votre compte.</p>
    </div>
</div>

<div class="row g-4">

    {{-- COLONNE GAUCHE : NAVIGATION PARAMÈTRES --}}
    <div class="col-md-3">
        <div class="card p-3">
            <div class="d-flex flex-column gap-1">
                <a href="#profil" class="sidebar-link active" onclick="showSection('profil')">
                    <span>👤</span> Profil
                </a>
                <a href="#securite" class="sidebar-link" onclick="showSection('securite')">
                    <span>🔒</span> Sécurité
                </a>
                <a href="#hotel" class="sidebar-link" onclick="showSection('hotel')">
                    <span>🏨</span> Informations Hôtel
                </a>
                <a href="#notifications" class="sidebar-link" onclick="showSection('notifications')">
                    <span>🔔</span> Notifications
                </a>
                <hr style="border-color:#f3f4f6;">
                <form method="POST" action="/logout">
                    @csrf
                    <button class="sidebar-link w-100 text-start border-0" style="background:none; color:#ef4444;">
                        <span>🚪</span> Déconnexion
                    </button>
                </form>
            </div>
        </div>

        {{-- Carte info utilisateur --}}
        <div class="card p-4 mt-3 text-center">
            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white mx-auto mb-3"
                 style="width:64px; height:64px; background:#1a56db; font-size:1.3rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="fw-bold">{{ auth()->user()->name }}</div>
            <div class="text-muted small">{{ auth()->user()->email }}</div>
            <span class="badge mt-2 px-3 py-1" style="background:#eff6ff; color:#1a56db;">Administrateur</span>
        </div>
    </div>

    {{-- COLONNE DROITE : CONTENU --}}
    <div class="col-md-9">

        {{-- SECTION PROFIL --}}
        <div id="section-profil">
            <div class="card p-4 mb-4">
                <h5 class="fw-bold mb-1">Informations du Profil</h5>
                <p class="text-muted small mb-4">Modifiez votre nom et votre adresse email.</p>

                @if(session('success_profil'))
                    <div class="alert mb-4" style="background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; border-radius:8px;">
                        ✅ {{ session('success_profil') }}
                    </div>
                @endif

                <form method="POST" action="/parametres/profil">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="mb-1">Nom complet</label>
                            <div class="position-relative">
                                <span class="position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#9ca3af;">👤</span>
                                <input type="text" name="name" class="form-control" style="padding-left:36px;"
                                       value="{{ auth()->user()->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="mb-1">Adresse Email</label>
                            <div class="position-relative">
                                <span class="position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#9ca3af;">✉️</span>
                                <input type="email" name="email" class="form-control" style="padding-left:36px;"
                                       value="{{ auth()->user()->email }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="mb-1">Rôle</label>
                            <input type="text" class="form-control" value="Administrateur" disabled
                                   style="background:#f9fafb; color:#9ca3af;">
                        </div>
                        <div class="col-md-6">
                            <label class="mb-1">Membre depuis</label>
                            <input type="text" class="form-control"
                                   value="{{ auth()->user()->created_at->format('d/m/Y') }}" disabled
                                   style="background:#f9fafb; color:#9ca3af;">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            💾 Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- SECTION SÉCURITÉ --}}
        <div id="section-securite">
            <div class="card p-4 mb-4">
                <h5 class="fw-bold mb-1">🔒 Changer le Mot de Passe</h5>
                <p class="text-muted small mb-4">Utilisez un mot de passe fort d'au moins 8 caractères.</p>

                @if(session('success_password'))
                    <div class="alert mb-4" style="background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; border-radius:8px;">
                        ✅ {{ session('success_password') }}
                    </div>
                @endif
                @if(session('error_password'))
                    <div class="alert mb-4" style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; border-radius:8px;">
                        ❌ {{ session('error_password') }}
                    </div>
                @endif

                <form method="POST" action="/parametres/password">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="mb-1">Mot de passe actuel</label>
                            <div class="position-relative">
                                <span class="position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#9ca3af;">🔑</span>
                                <input type="password" name="current_password" id="current_password"
                                       class="form-control" style="padding-left:36px; padding-right:40px;" required>
                                <span onclick="togglePassword('current_password')"
                                      style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#9ca3af;">👁️</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="mb-1">Nouveau mot de passe</label>
                            <div class="position-relative">
                                <span class="position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#9ca3af;">🔒</span>
                                <input type="password" name="password" id="new_password"
                                       class="form-control" style="padding-left:36px; padding-right:40px;" required minlength="8">
                                <span onclick="togglePassword('new_password')"
                                      style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#9ca3af;">👁️</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="mb-1">Confirmer le mot de passe</label>
                            <div class="position-relative">
                                <span class="position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#9ca3af;">🔒</span>
                                <input type="password" name="password_confirmation" id="confirm_password"
                                       class="form-control" style="padding-left:36px; padding-right:40px;" required minlength="8">
                                <span onclick="togglePassword('confirm_password')"
                                      style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#9ca3af;">👁️</span>
                            </div>
                        </div>
                    </div>

                    {{-- Indicateur force du mot de passe --}}
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Force du mot de passe</small>
                            <small id="password-strength-text" class="text-muted">--</small>
                        </div>
                        <div class="progress" style="height:6px; background:#f3f4f6;">
                            <div id="password-strength-bar" class="progress-bar" style="width:0%; transition:all 0.3s;"></div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            🔒 Mettre à jour le mot de passe
                        </button>
                    </div>
                </form>
            </div>

            {{-- Sessions actives --}}
            <div class="card p-4">
                <h6 class="fw-bold mb-3">💻 Session Active</h6>
                <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#f9fafb; border:1px solid #e8ecf0;">
                    <span style="font-size:1.5rem;">🖥️</span>
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">Navigateur Web</div>
                        <div class="text-muted" style="font-size:0.75rem;">Connecté maintenant • {{ request()->ip() }}</div>
                    </div>
                    <span class="badge" style="background:#ecfdf5; color:#065f46;">● Actif</span>
                </div>
            </div>
        </div>

        {{-- SECTION HÔTEL --}}
        <div id="section-hotel" style="display:none;">
            <div class="card p-4">
                <h5 class="fw-bold mb-1">🏨 Informations de l'Hôtel</h5>
                <p class="text-muted small mb-4">Configurez les informations générales de votre établissement.</p>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="mb-1">Nom de l'hôtel</label>
                        <input type="text" class="form-control" value="Grand Hôtel">
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1">Téléphone</label>
                        <input type="text" class="form-control" placeholder="+221 77 000 00 00">
                    </div>
                    <div class="col-12">
                        <label class="mb-1">Adresse</label>
                        <input type="text" class="form-control" placeholder="Adresse complète de l'hôtel">
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1">Email de contact</label>
                        <input type="email" class="form-control" placeholder="contact@hotel.com">
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1">Site web</label>
                        <input type="text" class="form-control" placeholder="www.hotel.com">
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary px-4 fw-bold">💾 Enregistrer</button>
                </div>
            </div>
        </div>

        {{-- SECTION NOTIFICATIONS --}}
        <div id="section-notifications" style="display:none;">
            <div class="card p-4">
                <h5 class="fw-bold mb-1">🔔 Préférences de Notifications</h5>
                <p class="text-muted small mb-4">Choisissez quand vous souhaitez être notifié.</p>
                <div class="d-flex flex-column gap-3">
                    @foreach([
                        ['Nouvelle réservation', 'Recevoir une alerte pour chaque nouvelle réservation'],
                        ['Check-in client', 'Notifier lors de l\'arrivée d\'un client'],
                        ['Check-out client', 'Notifier lors du départ d\'un client'],
                        ['Chambre en maintenance', 'Alerte quand une chambre passe en maintenance'],
                        ['Paiement reçu', 'Confirmation lors de chaque paiement'],
                    ] as $notif)
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3"
                         style="border:1px solid #e8ecf0;">
                        <div>
                            <div class="fw-semibold small">{{ $notif[0] }}</div>
                            <div class="text-muted" style="font-size:0.75rem;">{{ $notif[1] }}</div>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" checked
                                   style="width:2.5rem; height:1.25rem; cursor:pointer;">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary px-4 fw-bold">💾 Enregistrer les préférences</button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function showSection(section) {
    // Cacher toutes les sections
    ['profil', 'securite', 'hotel', 'notifications'].forEach(s => {
        const el = document.getElementById('section-' + s);
        if (el) el.style.display = 'none';
    });
    // Afficher la section choisie
    const target = document.getElementById('section-' + section);
    if (target) target.style.display = 'block';

    // Mettre à jour les liens actifs
    document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
    event.currentTarget.classList.add('active');
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    field.type = field.type === 'password' ? 'text' : 'password';
}

// Indicateur force mot de passe
document.getElementById('new_password').addEventListener('input', function() {
    const val = this.value;
    const bar = document.getElementById('password-strength-bar');
    const text = document.getElementById('password-strength-text');
    let strength = 0;
    if (val.length >= 8) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;

    const levels = [
        { width: '25%', color: '#ef4444', label: 'Faible' },
        { width: '50%', color: '#f59e0b', label: 'Moyen' },
        { width: '75%', color: '#3b82f6', label: 'Bon' },
        { width: '100%', color: '#0e9f6e', label: 'Très fort' },
    ];
    if (strength > 0) {
        bar.style.width = levels[strength-1].width;
        bar.style.background = levels[strength-1].color;
        text.textContent = levels[strength-1].label;
        text.style.color = levels[strength-1].color;
    } else {
        bar.style.width = '0%';
        text.textContent = '--';
    }
});
</script>

@endsection