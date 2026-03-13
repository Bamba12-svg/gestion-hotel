@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h2 class="fw-bold mb-1">Gestion des Réservations</h2>
        <p class="text-muted mb-0">Gérez et suivez toutes les arrivées de l'hôtel.</p>
    </div>
    <a href="/reservations/create" class="btn btn-primary px-4">
        + Nouvelle Réservation
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="card mb-4">

    {{-- ONGLETS --}}
    <div class="px-4 pt-3" style="border-bottom:1px solid #e8ecf0;">
        <div class="d-flex gap-4">
            <span class="pb-3 fw-semibold" style="border-bottom:2px solid #1a56db; color:#1a56db; cursor:pointer;">Liste des réservations</span>
            <span class="pb-3 text-muted fw-semibold" style="cursor:pointer;">Vue Calendrier</span>
        </div>
    </div>

    {{-- FILTRES --}}
    <div class="px-4 py-3 d-flex align-items-center gap-3 flex-wrap" style="border-bottom:1px solid #f3f4f6;">
        <select class="form-select form-select-sm" style="width:120px;">
            <option>Toutes</option>
            <option>Confirmées</option>
            <option>En attente</option>
            <option>Annulées</option>
        </select>
        <span class="badge px-3 py-2" style="background:#ecfdf5; color:#065f46; cursor:pointer;">● Confirmées</span>
        <span class="badge px-3 py-2" style="background:#fffbeb; color:#92400e; cursor:pointer;">● En attente</span>
        <span class="badge px-3 py-2" style="background:#fef2f2; color:#991b1b; cursor:pointer;">● Annulées</span>
        <div class="ms-auto d-flex align-items-center gap-2">
            <span class="text-muted small fw-semibold" style="text-transform:uppercase; letter-spacing:1px; font-size:0.7rem;">Trier par :</span>
            <select class="form-select form-select-sm" style="width:160px;">
                <option>Date d'arrivée</option>
                <option>Client</option>
                <option>Statut</option>
            </select>
        </div>
    </div>

    {{-- TABLEAU --}}
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr style="border-bottom:1px solid #e8ecf0;">
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Client</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Dates de Séjour</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Chambre</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Statut</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                <tr style="border-bottom:1px solid #f3f4f6;">

                    {{-- CLIENT --}}
                    <td class="px-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                 style="width:40px; height:40px; background:#1a56db; font-size:0.8rem; flex-shrink:0;">
                                {{ strtoupper(substr($res->client->prenom, 0, 1) . substr($res->client->nom, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $res->client->prenom }} {{ $res->client->nom }}</div>
                                <div class="text-muted" style="font-size:0.75rem;">{{ $res->client->email ?? $res->client->telephone }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- DATES --}}
                    <td class="px-4 py-3">
                        <div class="fw-semibold" style="font-size:0.875rem;">
                            {{ \Carbon\Carbon::parse($res->date_arrivee)->format('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse($res->date_depart)->format('d M Y') }}
                        </div>
                        <div class="text-muted" style="font-size:0.75rem;">
                            {{ \Carbon\Carbon::parse($res->date_arrivee)->diffInDays($res->date_depart) }} nuit(s)
                        </div>
                    </td>

                    {{-- CHAMBRE --}}
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 rounded-2" style="background:#f3f4f6; font-size:0.8rem; font-weight:600; color:#374151;">
                            🛏️ {{ ucfirst($res->chambre->type) }} #{{ $res->chambre->numero }}
                        </span>
                    </td>

                    {{-- STATUT --}}
                    <td class="px-4 py-3">
                        @if($res->statut == 'confirmee')
                            <span class="badge px-3 py-2 rounded-pill" style="background:#ecfdf5; color:#065f46;">Confirmée</span>
                        @elseif($res->statut == 'en_attente')
                            <span class="badge px-3 py-2 rounded-pill" style="background:#fffbeb; color:#92400e;">En attente</span>
                        @elseif($res->statut == 'checkin')
                            <span class="badge px-3 py-2 rounded-pill" style="background:#eff6ff; color:#1e40af;">Check-in</span>
                        @elseif($res->statut == 'checkout')
                            <span class="badge px-3 py-2 rounded-pill" style="background:#f3f4f6; color:#6b7280;">Check-out</span>
                        @else
                            <span class="badge px-3 py-2 rounded-pill" style="background:#fef2f2; color:#991b1b;">Annulée</span>
                        @endif
                    </td>

                    {{-- ACTIONS --}}
                    <td class="px-4 py-3">
                        <div class="d-flex align-items-center gap-2">
                            <a href="/reservations/{{ $res->id }}/edit"
                               class="btn btn-sm" style="background:#f3f4f6; border:none; color:#374151; width:32px; height:32px; padding:0; display:flex; align-items:center; justify-content:center; border-radius:50%;">
                                ✏️
                            </a>
                            <form method="POST" action="/reservations/{{ $res->id }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm"
                                        style="background:#fef2f2; border:1px solid #fecaca; color:#ef4444; width:32px; height:32px; padding:0; display:flex; align-items:center; justify-content:center; border-radius:50%;"
                                        onclick="return confirm('Annuler cette réservation ?')">✕</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <div style="font-size:3rem;">📋</div>
                        <p class="mt-2">Aucune réservation enregistrée</p>
                        <a href="/reservations/create" class="btn btn-primary btn-sm">+ Nouvelle réservation</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top:1px solid #f3f4f6;">
        <span class="text-muted small">Affichage de 1 à {{ $reservations->count() }} sur {{ $reservations->count() }} réservations</span>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-secondary px-3">Précédent</button>
            <button class="btn btn-sm btn-primary px-3">Suivant</button>
        </div>
    </div>
</div>

{{-- STATS BAS DE PAGE --}}
@php
    $taux = App\Models\Chambre::count() > 0
        ? round((App\Models\Chambre::where('statut','occupee')->count() / App\Models\Chambre::count()) * 100) : 0;
@endphp
<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted small">Réservations aujourd'hui</span>
                <span style="color:#1a56db; font-size:1.2rem;">📅</span>
            </div>
            <div class="fw-bold" style="font-size:2rem;">{{ $reservations->count() }}</div>
            <div class="mt-1" style="color:#0e9f6e; font-size:0.85rem;">↗ +4 depuis hier</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted small">Taux d'occupation</span>
                <span style="color:#1a56db; font-size:1.2rem;">🛏️</span>
            </div>
            <div class="fw-bold" style="font-size:2rem;">{{ $taux }}%</div>
            <div class="progress mt-2" style="height:6px;">
                <div class="progress-bar" style="width:{{ $taux }}%; background:#1a56db;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-muted small">Revenus prévus</span>
                <span style="color:#1a56db; font-size:1.2rem;">💰</span>
            </div>
            <div class="fw-bold" style="font-size:2rem;">{{ number_format(App\Models\Facture::sum('montant_total'), 0, ',', ' ') }} FCFA</div>
            <div class="text-muted small mt-1">Pour le mois en cours</div>
        </div>
    </div>
</div>

@endsection