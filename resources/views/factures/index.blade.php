@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h2 class="fw-bold mb-1">Factures</h2>
        <p class="text-muted mb-0">Gérez toutes les factures de l'hôtel.</p>
    </div>
    <a href="/factures/create" class="btn btn-primary px-4">+ Générer une Facture</a>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr style="border-bottom:1px solid #e8ecf0;">
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Référence</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Client</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Chambre</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Montant</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Statut</th>
                    <th class="px-4 py-3" style="color:#9ca3af; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($factures as $facture)
                <tr style="border-bottom:1px solid #f3f4f6;">
                    <td class="px-4 py-3">
                        <span class="fw-bold" style="color:#1a56db; font-size:0.875rem;">
                            #INV-{{ str_pad($facture->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                        <div class="text-muted" style="font-size:0.75rem;">
                            {{ $facture->created_at->format('d/m/Y') }}
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                 style="width:36px; height:36px; background:#1a56db; font-size:0.75rem; flex-shrink:0;">
                                {{ strtoupper(substr($facture->reservation->client->prenom, 0, 1) . substr($facture->reservation->client->nom, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold" style="font-size:0.875rem;">
                                    {{ $facture->reservation->client->prenom }} {{ $facture->reservation->client->nom }}
                                </div>
                                <div class="text-muted" style="font-size:0.75rem;">
                                    {{ $facture->reservation->client->email ?? $facture->reservation->client->telephone }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-2" style="background:#f3f4f6; font-size:0.8rem; font-weight:600; color:#374151;">
                            🛏️ {{ ucfirst($facture->reservation->chambre->type) }} #{{ $facture->reservation->chambre->numero }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="fw-bold" style="color:#1a56db;">
                            {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
                        </div>
                        <div class="text-muted" style="font-size:0.75rem;">
                            {{ ucfirst(str_replace('_', ' ', $facture->mode_paiement)) }}
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        @if($facture->statut_paiement == 'paye')
                            <span class="badge px-3 py-2 rounded-pill" style="background:#ecfdf5; color:#065f46;">✅ Payé</span>
                        @elseif($facture->statut_paiement == 'partiel')
                            <span class="badge px-3 py-2 rounded-pill" style="background:#fffbeb; color:#92400e;">⏳ Partiel</span>
                        @else
                            <span class="badge px-3 py-2 rounded-pill" style="background:#fef2f2; color:#991b1b;">❌ Non payé</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="d-flex gap-2">
                            <a href="/factures/{{ $facture->id }}" class="btn btn-sm btn-primary px-3">
                                👁️ Voir
                            </a>
                            <form method="POST" action="/factures/{{ $facture->id }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm" style="background:#fef2f2; border:1px solid #fecaca; color:#ef4444;"
                                        onclick="return confirm('Supprimer cette facture ?')">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <div style="font-size:3rem;">🧾</div>
                        <p class="mt-2">Aucune facture générée</p>
                        <a href="/factures/create" class="btn btn-primary btn-sm">+ Générer une facture</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 d-flex justify-content-between align-items-center" style="border-top:1px solid #f3f4f6;">
        <span class="text-muted small">{{ $factures->count() }} facture(s) au total</span>
        <div class="fw-bold" style="color:#1a56db;">
            Total : {{ number_format($factures->sum('montant_total'), 0, ',', ' ') }} FCFA
        </div>
    </div>
</div>

@endsection