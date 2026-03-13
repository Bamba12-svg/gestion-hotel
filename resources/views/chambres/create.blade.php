@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-header"><h5 class="mb-0">➕ Ajouter une Chambre</h5></div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="/chambres">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Numéro</label>
                            <input type="text" name="numero" class="form-control" placeholder="Ex: 101" required>
                        </div>
                        <div class="col-md-6">
                            <label>Type</label>
                            <select name="type" class="form-select" required>
                                <option value="simple">Simple</option>
                                <option value="double">Double</option>
                                <option value="suite">Suite</option>
                                <option value="familiale">Familiale</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Prix / Nuit (FCFA)</label>
                            <input type="number" name="prix_nuit" class="form-control" placeholder="Ex: 50000" required>
                        </div>
                        <div class="col-md-6">
                            <label>Capacité</label>
                            <input type="number" name="capacite" class="form-control" value="1" required>
                        </div>
                        <div class="col-md-6">
                            <label>Statut</label>
                            <select name="statut" class="form-select">
                                <option value="libre">Libre</option>
                                <option value="occupee">Occupée</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>URL Image</label>
                            <input type="text" name="image" class="form-control" placeholder="https://... (optionnel)">
                        </div>
                        <div class="col-12">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Décrivez la chambre..."></textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary flex-grow-1 py-2">Enregistrer</button>
                        <a href="/chambres" class="btn btn-secondary flex-grow-1 py-2">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection