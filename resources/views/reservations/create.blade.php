@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h2 class="fw-bold mb-1">Nouvelle Réservation</h2>
        <p class="text-muted mb-0">Remplissez les informations du client et choisissez une chambre.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="badge px-3 py-2" style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0;">
            ● Système en ligne
        </span>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger mb-4">{{ $errors->first() }}</div>
@endif

<form method="POST" action="/reservations">
@csrf

<div class="row g-4">

    {{-- COLONNE GAUCHE : PROFIL CLIENT --}}
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <h5 class="fw-bold mb-1">Profil Client</h5>
            <p class="text-muted small mb-4">Remplissez les informations d'identification du client.</p>

            <div class="mb-3">
                <label class="mb-1">Client</label>
                <select name="client_id" class="form-select" required>
                    <option value="">-- Sélectionner un client --</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->prenom }} {{ $client->nom }}</option>
                    @endforeach
                </select>
                <div class="mt-2">
                    <a href="/clients/create" class="small text-decoration-none" style="color:#1a56db;">+ Créer un nouveau client</a>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="mb-1">Date d'arrivée</label>
                    <div class="position-relative">
                        <span class="position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#9ca3af;">📅</span>
                        <input type="date" name="date_arrivee" class="form-control" style="padding-left:36px;" required>
                    </div>
                </div>
                <div class="col-6">
                    <label class="mb-1">Date de départ</label>
                    <div class="position-relative">
                        <span class="position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#9ca3af;">📅</span>
                        <input type="date" name="date_depart" class="form-control" style="padding-left:36px;" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="mb-1">Statut</label>
                <select name="statut" class="form-select">
                    <option value="en_attente">En attente</option>
                    <option value="confirmee">Confirmée</option>
                    <option value="checkin">Check-in</option>
                    <option value="checkout">Check-out</option>
                    <option value="annulee">Annulée</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="mb-1">Observations</label>
                <textarea name="observations" class="form-control" rows="3" placeholder="Notes spéciales, demandes particulières..."></textarea>
            </div>

            {{-- Checkboxes --}}
            <div class="mb-2">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="terms">
                    <label class="form-check-label small" for="terms">J'accepte les conditions générales de l'hôtel.</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="loyalty">
                    <label class="form-check-label small" for="loyalty">Inscrire le client au programme de fidélité.</label>
                </div>
            </div>
        </div>
    </div>

    {{-- COLONNE DROITE : CHAMBRE + RÉCAP --}}
    <div class="col-md-6">

        {{-- RÉCAP RÉSERVATION --}}
        <div class="card p-4 mb-4" style="border:1px solid #e8ecf0;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-semibold small text-muted" style="letter-spacing:1px; text-transform:uppercase;">Résumé Réservation</span>
                <span class="badge" style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0;">Confirmée</span>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <div class="text-muted small mb-1" style="text-transform:uppercase; letter-spacing:1px; font-size:0.7rem;">Arrivée</div>
                    <div class="fw-bold" id="recap-arrivee">--/--/----</div>
                    <div class="text-muted small">À partir de 14:00</div>
                </div>
                <div class="col-6">
                    <div class="text-muted small mb-1" style="text-transform:uppercase; letter-spacing:1px; font-size:0.7rem;">Départ</div>
                    <div class="fw-bold" id="recap-depart">--/--/----</div>
                    <div class="text-muted small">Avant 11:00</div>
                </div>
            </div>
            <hr style="border-color:#f3f4f6;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span>👥</span>
                    <span class="small" id="recap-chambre">Sélectionnez une chambre</span>
                </div>
                <span class="fw-bold" style="color:#1a56db; font-size:1.1rem;" id="recap-prix">--</span>
            </div>
        </div>

        {{-- CHAMBRES DISPONIBLES --}}
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Chambres Disponibles</h6>
                <a href="/chambres" class="small text-decoration-none" style="color:#1a56db;">Voir tout</a>
            </div>

            <div class="d-flex flex-column gap-2" id="chambres-list">
                @foreach($chambres as $chambre)
                <div class="chambre-option p-3 rounded-3 d-flex align-items-center gap-3"
                     style="border:1px solid #e8ecf0; cursor:pointer; transition:all 0.2s;"
                     onclick="selectionnerChambre({{ $chambre->id }}, '{{ $chambre->numero }}', '{{ ucfirst($chambre->type) }}', {{ $chambre->prix_nuit }}, {{ $chambre->capacite }})">
                    <div class="rounded-2 fw-bold d-flex align-items-center justify-content-center"
                         style="width:48px; height:48px; background:#eff6ff; color:#1a56db; font-size:0.9rem; flex-shrink:0;">
                        {{ $chambre->numero }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ ucfirst($chambre->type) }}</div>
                        <div class="text-muted small">{{ $chambre->capacite }} pers. • {{ number_format($chambre->prix_nuit, 0, ',', ' ') }} FCFA/nuit</div>
                    </div>
                    <span class="small fw-semibold" style="color:#0e9f6e;">DISPONIBLE</span>
                    <span class="chambre-check" style="color:#1a56db; display:none;">✅</span>
                </div>
                @endforeach
            </div>

            <input type="hidden" name="chambre_id" id="chambre_id" required>

            {{-- STATUT PAIEMENT --}}
            <div class="mt-4 p-3 rounded-3 d-flex justify-content-between align-items-center"
                 style="background:#1a1d23; color:white;">
                <div class="d-flex align-items-center gap-2">
                    <span>💳</span>
                    <div>
                        <div class="fw-semibold small">Statut Paiement</div>
                        <div style="color:#9ca3af; font-size:0.75rem;">À régler à l'arrivée</div>
                    </div>
                </div>
                <div class="text-end">
                    <div style="color:#9ca3af; font-size:0.7rem;">Montant estimé</div>
                    <div class="fw-bold" style="color:white; font-size:1.1rem;" id="montant-total">-- FCFA</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ACTIONS BAS DE PAGE --}}
<div class="d-flex justify-content-between align-items-center mt-4 pt-3" style="border-top:1px solid #e8ecf0;">
    <div class="d-flex gap-2">
        <a href="/reservations" class="btn btn-secondary px-4">Annuler</a>
        <button type="button" class="btn btn-secondary px-4">🖨️ Imprimer</button>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="text-end">
            <div class="text-muted small">Chambre sélectionnée</div>
            <div class="fw-semibold small" id="chambre-selected-label">Aucune</div>
        </div>
        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
            🔑 Confirmer la Réservation
        </button>
    </div>
</div>

</form>

<script>
let prixNuit = 0;

// Mise à jour du récap dates
document.querySelector('input[name="date_arrivee"]').addEventListener('change', function() {
    document.getElementById('recap-arrivee').textContent = this.value;
    calculerMontant();
});
document.querySelector('input[name="date_depart"]').addEventListener('change', function() {
    document.getElementById('recap-depart').textContent = this.value;
    calculerMontant();
});

function selectionnerChambre(id, numero, type, prix, capacite) {
    // Reset tous
    document.querySelectorAll('.chambre-option').forEach(el => {
        el.style.border = '1px solid #e8ecf0';
        el.style.background = 'white';
        el.querySelector('.chambre-check').style.display = 'none';
    });

    // Sélectionner celui cliqué
    event.currentTarget.style.border = '2px solid #1a56db';
    event.currentTarget.style.background = '#eff6ff';
    event.currentTarget.querySelector('.chambre-check').style.display = 'inline';

    document.getElementById('chambre_id').value = id;
    document.getElementById('recap-chambre').textContent = capacite + ' pers. • ' + type;
    document.getElementById('recap-prix').textContent = prix.toLocaleString('fr-FR') + ' FCFA/nuit';
    document.getElementById('chambre-selected-label').textContent = 'Chambre ' + numero + ' (' + type + ')';
    prixNuit = prix;
    calculerMontant();
}

function calculerMontant() {
    const arrivee = document.querySelector('input[name="date_arrivee"]').value;
    const depart = document.querySelector('input[name="date_depart"]').value;
    if (arrivee && depart && prixNuit > 0) {
        const nuits = Math.max(1, Math.round((new Date(depart) - new Date(arrivee)) / (1000*60*60*24)));
        const total = nuits * prixNuit;
        document.getElementById('montant-total').textContent = total.toLocaleString('fr-FR') + ' FCFA';
    }
}
</script>

@endsection