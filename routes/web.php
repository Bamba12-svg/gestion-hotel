<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FactureController;
use App\Models\Chambre;
use App\Models\Client;
use App\Models\Reservation;
use App\Models\Facture;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'chambres_total'    => Chambre::count(),
            'chambres_libres'   => Chambre::where('statut', 'libre')->count(),
            'chambres_occupees' => Chambre::where('statut', 'occupee')->count(),
            'clients'           => Client::count(),
            'reservations'      => Reservation::count(),
            'reservations_checkin' => Reservation::where('statut', 'checkin')->count(),
            'revenus'           => Facture::sum('montant_total'),
        ];
        return view('dashboard', compact('stats'));
    })->name('dashboard');
});



Route::middleware('auth')->group(function () {
    // ... routes existantes ...
    Route::resource('chambres', ChambreController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('reservations', ReservationController::class);
    Route::resource('factures', FactureController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::get('/parametres', function () {
    return view('parametres');
})->name('parametres');

Route::post('/parametres/profil', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . auth()->id(),
    ]);
    auth()->user()->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);
    return back()->with('success_profil', 'Profil mis à jour avec succès !');
})->name('parametres.profil');

Route::post('/parametres/password', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'current_password' => 'required',
        'password' => 'required|min:8|confirmed',
    ]);
    if (!\Illuminate\Support\Facades\Hash::check($request->current_password, auth()->user()->password)) {
        return back()->with('error_password', 'Mot de passe actuel incorrect.');
    }
    auth()->user()->update([
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
    ]);
    return back()->with('success_password', 'Mot de passe modifié avec succès !');
})->name('parametres.password');
});



// Dans le groupe middleware('auth')
