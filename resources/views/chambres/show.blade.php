@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow overflow-hidden">
            <div class="position-relative">
                <img src="{{ $chambre->image ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80' }}"
                     style="width:100%; height:320px; object-fit:cover;" alt="Chambre">
                <div class="position-absolute bottom-0 start-0 w-100 p-4"
                     style="background: linear-gradient(transparent, rgba(26,21,8,0.95));">
                    <div class="d-flex justify-content-between align-items-end">
                        <div>
                            <h3 class="fw-bold text-white mb-0">Chambre N°{{ $chambre->numero }}</h3>
                            <span style="color:#d4af37;">{{ ucfirst($chambre->type) }}</span>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold" style="color:#d4af37; font-size:1.4rem;">{{ number_format($chambre->prix_nuit, 0, ',', ' ') }} FCFA</div>
                            <small class="text-muted">par nuit</small>
                        </div>
                    </div>
                </div>
                @if($chambre->statut == 'libre')
                    <span class="position-absolute top-0 start-0 m-3 badge rounded-pill px-3 py-2" style="background:rgba(74,222,128,0.9); color:#1a1508;">✅ Disponible</span>
                @elseif($chambre->statut == 'occupee')
                    <span class="position-absolute top-0 start-0 m-3 badge rounded-pill px-3 py-2" style="background:rgba(248,113,113,0.9);">🔴 Occupée</span>
                @else
                    <span class="position-absolute top-0 start-0 m-3 badge rounded-pill px-3 py-2" style="background:rgba(251,191,36,0.9); color:#1a1508;">🔧 Maintenance</span>
                @endif
            </div>

            <div class="card-body p-4">
                {{-- Infos clés --}}
                <div class="row g-3 mb-4">
                    <div class="col-4">
                        <div class="text-center p-3 rounded-3" style="background:rgba(212,175,55,0.08); border:1px solid rgba(212,175,55,0.2);">
                            <div style="font-size:1.5rem;">🛏️</div>
                            <div class="small fw-bold" style="color:#d4af37;">{{ ucfirst($chambre->type) }}</div>
                            <div class="small text-muted">Type</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center p-3 rounded-3" style="background:rgba(212,175,55,0.08); border:1px solid rgba(212,175,55,0.2);">
                            <div style="font-size:1.5rem;">👥</div>
                            <div class="small fw-bold" style="color:#d4af37;">{{ $chambre->capacite }} pers.</div>
                            <div class="small text-muted">Capacité</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center p-3 rounded-3" style="background:rgba(212,175,55,0.08); border:1px solid rgba(212,175,55,0.2);">
                            <div style="font-size:1.5rem;">💰</div>
                            <div class="small fw-bold" style="color:#d4af37;">{{ number_format($chambre->prix_nuit, 0, ',', ' ') }}</div>
                            <div class="small text-muted">FCFA/nuit</div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <h6 class="fw-bold mb-2" style="color:#d4af37;">📝 Description</h6>
                <p style="color:rgba(232,213,163,0.7); line-height:1.7;">
                    {{ $chambre->description ?? 'Une chambre confortable et élégante, idéale pour un séjour agréable.' }}
                </p>

                {{-- Actions --}}
                <div class="d-flex gap-2 mt-4">
                    <a href="/reservations/create" class="btn btn-primary flex-grow-1 py-2 fw-bold">📋 Réserver cette chambre</a>
                    <a href="/chambres/{{ $chambre->id }}/edit" class="btn btn-warning py-2">✏️ Modifier</a>
                    <a href="/chambres" class="btn btn-secondary py-2">← Retour</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection