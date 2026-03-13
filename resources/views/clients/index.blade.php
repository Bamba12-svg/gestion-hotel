@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Gestion des Clients</h2>
    </div>
    <a href="/clients/create" class="btn btn-primary px-4">
        👤 Nouveau Client
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

{{-- ONGLETS --}}
<div class="mb-4" style="border-bottom:2px solid #e8ecf0;">
    <div class="d-flex gap-4">
        <span class="pb-2 fw-semibold" style="border-bottom:2px solid #1a56db; color:#1a56db; cursor:pointer;">Tous les clients</span>
        <span class="pb-2 text-muted fw-semibold" style="cursor:pointer;">Arrivées du jour</span>
        <span class="pb-2 text-muted fw-semibold" style="cursor:pointer;">VIP</span>
        <span class="pb-2 text-muted fw-semibold" style="cursor:pointer;">Historique</span>
    </div>
</div>

{{-- FILTRES --}}
<div class="d-flex gap-3 align-items-center mb-4 flex-wrap">
    <select class="form-select form-select-sm" style="width:140px;">
        <option>Statut: Tous</option>
        <option>Nouveau</option>
        <option>Régulier</option>
        <option>VIP</option>
    </select>
    <select class="form-select form-select-sm" style="width:160px;">
        <option>Séjours: Tous</option>
        <option>Séjours: > 1</option>
        <option>Séjours: > 5</option>
        <option>Séjours: > 10</option>
    </select>
    <select class="form-select form-select-sm" style="width:190px;">
        <option>Dernière visite: Tous</option>
        <option>Dernière visite: 2024</option>
        <option>Dernière visite: 2025</option>
        <option>Dernière visite: 2026</option>
    </select>
    <button class="btn btn-sm ms-auto" style="color:#1a56db; background:none; border:none; font-weight:600;">
        Réinitialiser les filtres
    </button>
</div>

{{-- TABLEAU --}}
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr style="border-bottom:1px solid #e8ecf0;">
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Client</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Coordonnées</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Séjours</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Statut</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr style="border-bottom:1px solid #f3f4f6;">
                    {{-- Avatar + Nom --}}
                    <td class="px-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                 style="width:42px; height:42px; background:#1a56db; font-size:0.85rem; flex-shrink:0;">
                                {{ strtoupper(substr($client->prenom, 0, 1) . substr($client->nom, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $client->prenom }} {{ $client->nom }}</div>
                                <div class="text-muted" style="font-size:0.75rem;">ID: #C-{{ str_pad($client->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Coordonnées --}}
                    <td class="px-4 py-3">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="text-muted" style="font-size:0.8rem;">✉️</span>
                            <span style="font-size:0.875rem;">{{ $client->email ?? 'Non renseigné' }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted" style="font-size:0.8rem;">📞</span>
                            <span style="font-size:0.875rem;">{{ $client->telephone }}</span>
                        </div>
                    </td>

                    {{-- Séjours --}}
                    <td class="px-4 py-3">
                        @php $sejours = $client->reservations()->count(); @endphp
                        <span class="fw-bold" style="font-size:1.1rem; color:#1a1d23;">{{ $sejours }}</span>
                    </td>

                    {{-- Statut --}}
                    <td class="px-4 py-3">
                        @if($sejours == 0)
                            <span class="badge px-3 py-2" style="background:#eff6ff; color:#1a56db; font-weight:600;">NOUVEAU</span>
                        @elseif($sejours >= 5)
                            <span class="badge px-3 py-2" style="background:#fef3c7; color:#92400e; font-weight:600;">⭐ VIP</span>
                        @else
                            <span class="badge px-3 py-2" style="background:#f3f4f6; color:#6b7280; font-weight:600;">RÉGULIER</span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-4 py-3">
                        <div class="d-flex align-items-center gap-2">
                            <a href="/clients/{{ $client->id }}/edit"
                               class="text-decoration-none fw-semibold" style="color:#1a56db;">
                                Détails >
                            </a>
                            <form method="POST" action="/clients/{{ $client->id }}" class="mb-0">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm" style="background:none; border:none; color:#ef4444; padding:0 8px;"
                                        onclick="return confirm('Supprimer ce client ?')">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <div style="font-size:3rem;">👤</div>
                        <p class="mt-2">Aucun client enregistré</p>
                        <a href="/clients/create" class="btn btn-primary btn-sm">+ Ajouter un client</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- FOOTER PAGINATION --}}
    <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top:1px solid #f3f4f6;">
        <span class="text-muted small">Affichage de {{ $clients->count() }} client(s)</span>
        <div class="d-flex gap-1">
            <button class="btn btn-sm btn-secondary" style="width:32px; height:32px; padding:0;">‹</button>
            <button class="btn btn-sm btn-primary" style="width:32px; height:32px; padding:0;">1</button>
            <button class="btn btn-sm btn-secondary" style="width:32px; height:32px; padding:0;">›</button>
        </div>
    </div>
</div>

@endsection