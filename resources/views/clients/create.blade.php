@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h2 class="fw-bold mb-1">Nouveau Client</h2>
        <p class="text-muted mb-0">Remplissez les informations d'identification du client.</p>
    </div>
    <a href="/clients" class="btn btn-secondary">← Retour</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4">
            @if($errors->any())
                <div class="alert alert-danger mb-4">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="/clients">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="mb-1">Prénom</label>
                        <input type="text" name="prenom" class="form-control" placeholder="ex: Moussa" required>
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1">Nom</label>
                        <input type="text" name="nom" class="form-control" placeholder="ex: Diallo" required>
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1">Type de pièce</label>
                        <select name="type_piece" class="form-select">
                            <option value="CIN">CIN</option>
                            <option value="Passeport">Passeport</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1">Numéro CIN / Passeport</label>
                        <div class="position-relative">
                            <span class="position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#9ca3af;">🪪</span>
                            <input type="text" name="cin" class="form-control" style="padding-left:36px;" placeholder="ex: 1234567890" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1">Adresse Email</label>
                        <div class="position-relative">
                            <span class="position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#9ca3af;">✉️</span>
                            <input type="email" name="email" class="form-control" style="padding-left:36px;" placeholder="ex: client@email.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1">Téléphone</label>
                        <div class="position-relative">
                            <span class="position-absolute" style="left:12px; top:50%; transform:translateY(-50%); color:#9ca3af;">📞</span>
                            <input type="text" name="telephone" class="form-control" style="padding-left:36px;" placeholder="ex: +221 77 000 00 00" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="mb-1">Nationalité</label>
                        <input type="text" name="nationalite" class="form-control" placeholder="ex: Sénégalaise">
                    </div>
                </div>

                <hr class="my-4" style="border-color:#f3f4f6;">

                <div class="d-flex justify-content-between align-items-center">
                    <a href="/clients" class="btn btn-secondary px-4">Annuler</a>
                    <button type="submit" class="btn btn-primary px-5 fw-bold">
                        👤 Enregistrer le Client
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection