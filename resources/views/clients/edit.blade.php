@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-warning"><h5>✏️ Modifier le Client</h5></div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="/clients/{{ $client->id }}">
                    @csrf @method('PUT')
                    <div class="mb-3"><label>Nom</label><input type="text" name="nom" class="form-control" value="{{ $client->nom }}" required></div>
                    <div class="mb-3"><label>Prénom</label><input type="text" name="prenom" class="form-control" value="{{ $client->prenom }}" required></div>
                    <div class="mb-3">
                        <label>Type de pièce</label>
                        <select name="type_piece" class="form-select">
                            <option value="CIN" {{ $client->type_piece == 'CIN' ? 'selected' : '' }}>CIN</option>
                            <option value="Passeport" {{ $client->type_piece == 'Passeport' ? 'selected' : '' }}>Passeport</option>
                        </select>
                    </div>
                    <div class="mb-3"><label>Numéro CIN / Passeport</label><input type="text" name="cin" class="form-control" value="{{ $client->cin }}" required></div>
                    <div class="mb-3"><label>Téléphone</label><input type="text" name="telephone" class="form-control" value="{{ $client->telephone }}" required></div>
                    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="{{ $client->email }}"></div>
                    <div class="mb-3"><label>Nationalité</label><input type="text" name="nationalite" class="form-control" value="{{ $client->nationalite }}"></div>
                    <button type="submit" class="btn btn-warning w-100">Mettre à jour</button>
                    <a href="/clients" class="btn btn-secondary w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection