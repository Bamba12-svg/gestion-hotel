@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-warning"><h5>✏️ Modifier la Chambre</h5></div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="/chambres/{{ $chambre->id }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Numéro</label>
                        <input type="text" name="numero" class="form-control" value="{{ $chambre->numero }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Type</label>
                        <select name="type" class="form-select">
                            <option value="simple" {{ $chambre->type == 'simple' ? 'selected' : '' }}>Simple</option>
                            <option value="double" {{ $chambre->type == 'double' ? 'selected' : '' }}>Double</option>
                            <option value="suite" {{ $chambre->type == 'suite' ? 'selected' : '' }}>Suite</option>
                            <option value="familiale" {{ $chambre->type == 'familiale' ? 'selected' : '' }}>Familiale</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Prix / Nuit (FCFA)</label>
                        <input type="number" name="prix_nuit" class="form-control" value="{{ $chambre->prix_nuit }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Capacité</label>
                        <input type="number" name="capacite" class="form-control" value="{{ $chambre->capacite }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Statut</label>
                        <select name="statut" class="form-select">
                            <option value="libre" {{ $chambre->statut == 'libre' ? 'selected' : '' }}>Libre</option>
                            <option value="occupee" {{ $chambre->statut == 'occupee' ? 'selected' : '' }}>Occupée</option>
                            <option value="maintenance" {{ $chambre->statut == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="2">{{ $chambre->description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Mettre à jour</button>
                    <a href="/chambres" class="btn btn-secondary w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection