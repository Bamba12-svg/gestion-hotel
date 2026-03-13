@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">🛏️ Nos Chambres</h2>
    <a href="/chambres/create" class="btn btn-primary px-4">+ Ajouter</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-4">
    @forelse($chambres as $chambre)
    <div class="col-md-4">
        <div class="card shadow overflow-hidden h-100">
            <div class="position-relative">
                <img src="{{ $chambre->image ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80' }}"
                     style="width:100%; height:200px; object-fit:cover;" alt="Chambre">
                <span class="position-absolute top-0 end-0 m-2 px-2 py-1 rounded-2 fw-bold"
                      style="background:rgba(212,175,55,0.95); color:#1a1508; font-size:0.85rem;">
                    {{ number_format($chambre->prix_nuit, 0, ',', ' ') }} FCFA/nuit
                </span>
                @if($chambre->statut == 'libre')
                    <span class="position-absolute top-0 start-0 m-2 badge rounded-pill" style="background:rgba(74,222,128,0.9); color:#1a1508;">✅ Disponible</span>
                @elseif($chambre->statut == 'occupee')
                    <span class="position-absolute top-0 start-0 m-2 badge rounded-pill" style="background:rgba(248,113,113,0.9);">🔴 Occupée</span>
                @else
                    <span class="position-absolute top-0 start-0 m-2 badge rounded-pill" style="background:rgba(251,191,36,0.9); color:#1a1508;">🔧 Maintenance</span>
                @endif
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="fw-bold mb-0" style="color:#d4af37;">Chambre N°{{ $chambre->numero }}</h5>
                    <span class="badge" style="background:rgba(212,175,55,0.15); color:#d4af37; border:1px solid rgba(212,175,55,0.3);">{{ ucfirst($chambre->type) }}</span>
                </div>
                <p class="small text-muted mb-3">{{ $chambre->description ?? 'Une chambre confortable et élégante.' }}</p>
                                <div class="d-flex gap-3 small" style="color:#374151; font-weight:500;">
                    <span>👥 {{ $chambre->capacite }} pers.</span>
                    <span>🛏️ {{ ucfirst($chambre->type) }}</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="/chambres/{{ $chambre->id }}/edit" class="btn btn-warning btn-sm flex-grow-1">✏️ Modifier</a>
                    <a href="/chambres/{{ $chambre->id }}" class="btn btn-sm flex-grow-1" style="background:rgba(212,175,55,0.15); color:#d4af37; border:1px solid rgba(212,175,55,0.3);">👁️ Détails</a>
                    <form method="POST" action="/chambres/{{ $chambre->id }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">🗑️</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div style="font-size:4rem;">🛏️</div>
        <p class="text-muted mt-2">Aucune chambre enregistrée</p>
        <a href="/chambres/create" class="btn btn-primary mt-2">+ Ajouter une chambre</a>
    </div>
    @endforelse
</div>
@endsection