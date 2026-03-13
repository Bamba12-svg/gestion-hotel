@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-danger text-white"><h5>🧾 Générer une Facture</h5></div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="/factures">
                    @csrf
                    <div class="mb-3">
                        <label>Réservation</label>
                        <select name="reservation_id" class="form-select" required>
                            <option value="">-- Choisir une réservation --</option>
                            @foreach($reservations as $res)
                                <option value="{{ $res->id }}">
                                    {{ $res->client->nom }} {{ $res->client->prenom }} —
                                    Chambre N°{{ $res->chambre->numero }} —
                                    {{ $res->date_arrivee }} au {{ $res->date_depart }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Montant Services supplémentaires (FCFA)</label>
                        <input type="number" name="montant_services" class="form-control" value="0">
                    </div>
                    <div class="mb-3">
                        <label>Mode de paiement</label>
                        <select name="mode_paiement" class="form-select" required>
                            <option value="especes">💵 Espèces</option>
                            <option value="carte">💳 Carte bancaire</option>
                            <option value="virement">🏦 Virement</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Générer la Facture</button>
                    <a href="/factures" class="btn btn-secondary w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection