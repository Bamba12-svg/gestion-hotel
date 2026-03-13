@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h2 class="fw-bold mb-1">Tableau de bord</h2>
        <p class="text-muted mb-0">Statistiques en temps réel — <strong>{{ now()->isoFormat('dddd D MMMM') }}</strong></p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-secondary">📊 Exporter CSV</button>
        <button class="btn btn-secondary">💡 Aperçu</button>
    </div>
</div>

{{-- STATS CARDS --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="rounded-3 p-2" style="background:#eff6ff; font-size:1.4rem;">📋</div>
                <span class="badge" style="background:#ecfdf5; color:#065f46;">+12.5%</span>
            </div>
            <div class="text-muted small mb-1">Total Réservations</div>
            <div class="fw-bold" style="font-size:2rem; color:#1a1d23;">{{ $stats['reservations'] }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="rounded-3 p-2" style="background:#fef3c7; font-size:1.4rem;">🛏️</div>
                <span class="badge" style="background:#fef2f2; color:#991b1b;">-2.4%</span>
            </div>
            <div class="text-muted small mb-1">Taux d'occupation</div>
            @php $taux = $stats['chambres_total'] > 0 ? round(($stats['chambres_occupees'] / $stats['chambres_total']) * 100) : 0; @endphp
            <div class="fw-bold" style="font-size:2rem; color:#1a1d23;">{{ $taux }}%</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="rounded-3 p-2" style="background:#ecfdf5; font-size:1.4rem;">💰</div>
                <span class="badge" style="background:#ecfdf5; color:#065f46;">+8.1%</span>
            </div>
            <div class="text-muted small mb-1">Revenus Totaux</div>
            <div class="fw-bold" style="font-size:2rem; color:#1a56db;">{{ number_format($stats['revenus'], 0, ',', ' ') }} FCFA</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- STATUT DES CHAMBRES EN DIRECT --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header px-4 py-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold">Statut des Chambres en Direct</span>
                <div class="d-flex gap-3 small">
                    <span><span style="color:#0e9f6e;">●</span> Libres ({{ $stats['chambres_libres'] }})</span>
                    <span><span style="color:#1a56db;">●</span> Occupées ({{ $stats['chambres_occupees'] }})</span>
                    <span><span style="color:#f59e0b;">●</span> Maintenance</span>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    @forelse(App\Models\Chambre::all() as $chambre)
                    <div class="col-4">
                        <div class="p-3 rounded-3" style="border:1px solid #e8ecf0; border-bottom: 3px solid {{ $chambre->statut == 'libre' ? '#0e9f6e' : ($chambre->statut == 'occupee' ? '#1a56db' : '#f59e0b') }};">
                            <div class="text-muted" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:1px;">Chambre</div>
                            <div class="fw-bold" style="font-size:1.1rem;">{{ $chambre->numero }}</div>
                            <div style="font-size:0.7rem; font-weight:700; color:{{ $chambre->statut == 'libre' ? '#0e9f6e' : ($chambre->statut == 'occupee' ? '#1a56db' : '#f59e0b') }}; text-transform:uppercase;">
                                {{ $chambre->statut == 'libre' ? 'Disponible' : ($chambre->statut == 'occupee' ? 'Occupée' : 'Maintenance') }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Aucune chambre enregistrée</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ARRIVÉES RÉCENTES --}}
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header px-4 py-3 d-flex justify-content-between">
                <span class="fw-bold">Arrivées Récentes</span>
                <a href="/reservations" class="text-decoration-none" style="color:#1a56db; font-size:0.875rem;">Voir tout</a>
            </div>
            <div class="card-body p-0">
                @forelse(App\Models\Reservation::with('client','chambre')->latest()->take(4)->get() as $res)
                <div class="d-flex align-items-center gap-3 px-4 py-3" style="border-bottom:1px solid #f3f4f6;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                         style="width:40px; height:40px; background:#1a56db; font-size:0.8rem; flex-shrink:0;">
                        {{ strtoupper(substr($res->client->prenom, 0, 1) . substr($res->client->nom, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="font-size:0.875rem;">{{ $res->client->prenom }} {{ $res->client->nom }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">Chambre {{ $res->chambre->numero }} • {{ ucfirst($res->chambre->type) }}</div>
                    </div>
                    <div class="text-end">
                        @if($res->statut == 'checkin')
                            <span class="badge" style="background:#ecfdf5; color:#065f46;">Arrivé</span>
                        @elseif($res->statut == 'en_attente')
                            <span class="badge" style="background:#fef3c7; color:#92400e;">En attente</span>
                        @elseif($res->statut == 'confirmee')
                            <span class="badge" style="background:#eff6ff; color:#1e40af;">Confirmé</span>
                        @else
                            <span class="badge" style="background:#f3f4f6; color:#6b7280;">{{ ucfirst($res->statut) }}</span>
                        @endif
                        <div class="text-muted" style="font-size:0.7rem;">{{ $res->date_arrivee }}</div>
                    </div>
                </div>
                @empty
                <div class="px-4 py-3 text-muted small">Aucune réservation récente</div>
                @endforelse
            </div>
        </div>

        {{-- CONSEIL DU JOUR --}}
        <div class="card" style="border:1px solid #bfdbfe; background:#eff6ff;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="color:#1a56db;">ℹ️</span>
                    <span class="fw-bold" style="color:#1a56db;">Conseil du Jour</span>
                </div>
                <p class="mb-0 small" style="color:#1e40af;">
                    {{ $stats['chambres_occupees'] }} chambre(s) occupée(s) aujourd'hui.
                    Taux d'occupation : {{ $taux }}%.
                    @if($stats['chambres_libres'] > 0)
                        {{ $stats['chambres_libres'] }} chambre(s) disponible(s) pour de nouvelles réservations.
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

@endsection