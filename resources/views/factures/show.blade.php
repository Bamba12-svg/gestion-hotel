<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #INV-{{ str_pad($facture->id, 4, '0', STR_PAD_LEFT) }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f4f6f9; font-family:'Segoe UI', sans-serif; }
        .topbar { background:white; padding:16px 32px; border-bottom:1px solid #e8ecf0; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:10; }
        .invoice-wrap { max-width:860px; margin:40px auto; padding:0 16px 60px; }
        .invoice-card { background:white; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08); }
        .invoice-header { padding:40px 48px; border-bottom:1px solid #f3f4f6; }
        .invoice-section { padding:32px 48px; border-bottom:1px solid #f3f4f6; }
        .invoice-footer { padding:24px 48px; background:#f9fafb; text-align:center; color:#9ca3af; font-size:0.8rem; }
        .brand-icon { width:40px; height:40px; background:#1a56db; border-radius:10px; display:flex; align-items:center; justify-content:center; color:white; font-size:1.1rem; }
        .btn-action { padding:8px 20px; border-radius:8px; font-weight:600; font-size:0.875rem; display:flex; align-items:center; gap:8px; border:1px solid #e8ecf0; background:white; color:#374151; text-decoration:none; cursor:pointer; }
        .btn-action:hover { background:#f9fafb; }
        .btn-send { background:#1a56db; color:white; border-color:#1a56db; }
        .btn-send:hover { background:#1447c0; color:white; }
        table.invoice-table { width:100%; border-collapse:collapse; }
        table.invoice-table th { color:#9ca3af; font-size:0.72rem; text-transform:uppercase; letter-spacing:1.5px; font-weight:700; padding:0 0 12px 0; border-bottom:1px solid #e8ecf0; }
        table.invoice-table td { padding:20px 0; border-bottom:1px solid #f3f4f6; vertical-align:top; }
        table.invoice-table tr:last-child td { border-bottom:none; }
        .label-sm { font-size:0.68rem; text-transform:uppercase; letter-spacing:1.5px; color:#9ca3af; font-weight:700; margin-bottom:4px; }
        @media print {
            .topbar { display:none !important; }
            body { background:white; }
            .invoice-wrap { margin:0; padding:0; }
            .invoice-card { box-shadow:none; border-radius:0; }
        }
    </style>
</head>
<body>

{{-- TOPBAR --}}
<div class="topbar">
    <div class="d-flex align-items-center gap-3">
        <div class="brand-icon">🏨</div>
        <div>
            <div class="fw-bold">Grand Hôtel</div>
            <div style="font-size:0.72rem; color:#9ca3af; text-transform:uppercase; letter-spacing:1px;">Portail de Gestion</div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn-action" onclick="window.print()">📥 PDF</button>
        <button class="btn-action" onclick="window.print()">🖨️ Imprimer</button>
        <a href="/factures" class="btn-action btn-send">← Retour</a>
    </div>
</div>

<div class="invoice-wrap">
<div class="invoice-card">

    {{-- EN-TÊTE FACTURE --}}
    <div class="invoice-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="brand-icon">🏨</div>
                    <span class="fw-bold" style="font-size:1.1rem; letter-spacing:2px; text-transform:uppercase; color:#1a1d23;">Grand Hôtel</span>
                </div>
                <div style="color:#6b7280; font-size:0.875rem; line-height:1.8;">
                    Dakar, Sénégal<br>
                    +221 77 000 00 00<br>
                    contact@grandhotel.sn
                </div>
            </div>
            <div class="text-end">
                <div class="fw-bold" style="font-size:2rem; color:#1a56db; letter-spacing:2px;">FACTURE</div>
                <div class="label-sm mt-2">Référence</div>
                <div class="fw-bold" style="font-size:1rem; color:#1a1d23;">
                    #INV-{{ str_pad($facture->id, 4, '0', STR_PAD_LEFT) }}
                </div>
                <div class="label-sm mt-2">Date d'émission</div>
                <div class="fw-semibold" style="color:#1a1d23;">
                    {{ $facture->created_at->format('d F Y') }}
                </div>
            </div>
        </div>
    </div>

    {{-- FACTURÉ À + DÉTAILS SÉJOUR --}}
    <div class="invoice-section">
        <div class="row g-4">
            <div class="col-md-5">
                <div class="label-sm mb-3">Facturé à</div>
                <div class="fw-bold" style="font-size:1.1rem; color:#1a1d23;">
                    {{ $facture->reservation->client->prenom }} {{ $facture->reservation->client->nom }}
                </div>
                <div style="color:#6b7280; font-size:0.875rem; line-height:1.8; margin-top:6px;">
                    CIN : {{ $facture->reservation->client->cin }}<br>
                    {{ $facture->reservation->client->telephone }}<br>
                    {{ $facture->reservation->client->email ?? '' }}
                </div>
            </div>
            <div class="col-md-7">
                <div class="label-sm mb-3">Détails du Séjour</div>
                <div class="p-3 rounded-3" style="background:#f9fafb; border:1px solid #e8ecf0;">
                    <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #e8ecf0;">
                        <span style="color:#6b7280; font-size:0.875rem;">Arrivée :</span>
                        <span class="fw-semibold" style="font-size:0.875rem;">{{ \Carbon\Carbon::parse($facture->reservation->date_arrivee)->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #e8ecf0;">
                        <span style="color:#6b7280; font-size:0.875rem;">Départ :</span>
                        <span class="fw-semibold" style="font-size:0.875rem;">{{ \Carbon\Carbon::parse($facture->reservation->date_depart)->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span style="color:#6b7280; font-size:0.875rem;">Type de Chambre :</span>
                        <span class="fw-semibold" style="font-size:0.875rem;">{{ ucfirst($facture->reservation->chambre->type) }} #{{ $facture->reservation->chambre->numero }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- LIGNES DE FACTURATION --}}
    <div class="invoice-section">
        @php
            $nuits = max(1, \Carbon\Carbon::parse($facture->reservation->date_arrivee)->diffInDays($facture->reservation->date_depart));
        @endphp
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="text-align:left; width:45%;">Description</th>
                    <th style="text-align:center;">Quantité</th>
                    <th style="text-align:right;">Prix Unitaire</th>
                    <th style="text-align:right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="fw-semibold" style="color:#1a1d23;">Chambre {{ ucfirst($facture->reservation->chambre->type) }}</div>
                        <div style="color:#9ca3af; font-size:0.8rem;">N° {{ $facture->reservation->chambre->numero }} • {{ $facture->reservation->chambre->description ?? 'Chambre confortable' }}</div>
                    </td>
                    <td style="text-align:center; color:#374151;">{{ $nuits }} nuit(s)</td>
                    <td style="text-align:right; color:#374151;">{{ number_format($facture->reservation->chambre->prix_nuit, 0, ',', ' ') }} FCFA</td>
                    <td style="text-align:right; font-weight:600; color:#1a1d23;">{{ number_format($facture->montant_chambre, 0, ',', ' ') }} FCFA</td>
                </tr>
                @if($facture->montant_services > 0)
                <tr>
                    <td>
                        <div class="fw-semibold" style="color:#1a1d23;">Services supplémentaires</div>
                        <div style="color:#9ca3af; font-size:0.8rem;">Prestations additionnelles</div>
                    </td>
                    <td style="text-align:center; color:#374151;">1</td>
                    <td style="text-align:right; color:#374151;">{{ number_format($facture->montant_services, 0, ',', ' ') }} FCFA</td>
                    <td style="text-align:right; font-weight:600; color:#1a1d23;">{{ number_format($facture->montant_services, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- PAIEMENT + TOTAUX --}}
    <div class="invoice-section" style="border-bottom:none;">
        <div class="row">
            <div class="col-md-5">
                <div class="label-sm mb-3">Paiement</div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="font-size:1.2rem;">💳</span>
                    <span class="fw-semibold" style="color:#1a1d23;">
                        {{ ucfirst(str_replace('_', ' ', $facture->mode_paiement)) }}
                    </span>
                </div>
                @if($facture->date_paiement)
                <div style="color:#6b7280; font-size:0.8rem; font-style:italic;">
                    Paiement traité le {{ \Carbon\Carbon::parse($facture->date_paiement)->format('d/m/Y') }}.
                </div>
                @endif
            </div>
            <div class="col-md-7">
                <div class="p-4 rounded-3" style="background:#f9fafb; border:1px solid #e8ecf0;">
                    <div class="d-flex justify-content-between mb-2">
                        <span style="color:#6b7280;">Sous-total</span>
                        <span class="fw-semibold">{{ number_format($facture->montant_chambre + $facture->montant_services, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pb-3" style="border-bottom:1px solid #e8ecf0;">
                        <span style="color:#6b7280;">Services</span>
                        <span class="fw-semibold">{{ number_format($facture->montant_services, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold" style="font-size:1rem; color:#1a1d23;">TOTAL TTC</span>
                        <span class="fw-bold" style="font-size:1.5rem; color:#1a56db;">
                            {{ number_format($facture->montant_total, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                    <div class="mt-3 text-center">
                        @if($facture->statut_paiement == 'paye')
                            <span class="badge px-4 py-2" style="background:#ecfdf5; color:#065f46; font-size:0.85rem;">✅ Payé</span>
                        @elseif($facture->statut_paiement == 'partiel')
                            <span class="badge px-4 py-2" style="background:#fffbeb; color:#92400e; font-size:0.85rem;">⏳ Paiement partiel</span>
                        @else
                            <span class="badge px-4 py-2" style="background:#fef2f2; color:#991b1b; font-size:0.85rem;">❌ Non payé</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="invoice-footer">
        <p class="mb-1">Merci d'avoir séjourné au Grand Hôtel. À bientôt !</p>
        <p class="mb-0">contact@grandhotel.sn • +221 77 000 00 00 • Dakar, Sénégal</p>
    </div>

</div>
</div>

<div style="max-width:860px; margin:0 auto 40px; padding:0 16px; display:flex; justify-content:space-between; align-items:center;">
    <a href="/factures" style="color:#6b7280; font-size:0.875rem; text-decoration:none;">© {{ date('Y') }} Grand Hôtel. Tous droits réservés.</a>
    <div style="display:flex; gap:24px;">
        <a href="#" style="color:#6b7280; font-size:0.875rem; text-decoration:none;">Conditions Générales</a>
        <a href="#" style="color:#6b7280; font-size:0.875rem; text-decoration:none;">Support</a>
        <a href="#" style="color:#6b7280; font-size:0.875rem; text-decoration:none;">Confidentialité</a>
    </div>
</div>

</body>
</html>