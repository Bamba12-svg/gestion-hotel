@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-warning"><h5>✏️ Modifier la Réservation</h5></div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="/reservations/{{ $reservation->id }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Client</label>
                        <select name="client_id" class="form-select" required>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $reservation->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->nom }} {{ $client->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Chambre</label>
                        <select name="chambre_id" class="form-select" required>
                            @foreach($chambres as $chambre)
                                <option value="{{ $chambre->id }}" {{ $reservation->chambre_id == $chambre->id ? 'selected' : '' }}>
                                    N°{{ $chambre->numero }} — {{ ucfirst($chambre->type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Date d'arrivée</label>
                        <input type="date" name="date_arrivee" class="form-control" value="{{ $reservation->date_arrivee }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Date de départ</label>
                        <input type="date" name="date_depart" class="form-control" value="{{ $reservation->date_depart }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Statut</label>
                        <select name="statut" class="form-select">
                            <option value="en_attente" {{ $reservation->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="confirmee" {{ $reservation->statut == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                            <option value="checkin" {{ $reservation->statut == 'checkin' ? 'selected' : '' }}>Check-in</option>
                            <option value="checkout" {{ $reservation->statut == 'checkout' ? 'selected' : '' }}>Check-out</option>
                            <option value="annulee" {{ $reservation->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Observations</label>
                        <textarea name="observations" class="form-control" rows="2">{{ $reservation->observations }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Mettre à jour</button>
                    <a href="/reservations" class="btn btn-secondary w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection