<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FactureController;
use App\Models\Chambre;
use App\Models\Client;
use App\Models\Reservation;
use App\Models\Facture;

// Routes publiques
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $stats = [
            'chambres_total'       => Chambre::count(),
            'chambres_libres'      => Chambre::where('statut', 'libre')->count(),
            'chambres_occupees'    => Chambre::where('statut', 'occupee')->count(),
            'clients'              => Client::count(),
            'reservations'         => Reservation::count(),
            'reservations_checkin' => Reservation::where('statut', 'checkin')->count(),
            'revenus'              => Facture::sum('montant_total'),
        ];
        return view('dashboard', compact('stats'));
    })->name('dashboard');

    // Ressources CRUD
    Route::resource('chambres', ChambreController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('reservations', ReservationController::class);
    Route::resource('factures', FactureController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

    // Paramètres
    Route::get('/parametres', function () {
        return view('parametres');
    })->name('parametres');

    Route::post('/parametres/profil', function (Request $request) {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);
        auth()->user()->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);
        return back()->with('success_profil', 'Profil mis à jour avec succès !');
    })->name('parametres.profil');

    Route::post('/parametres/password', function (Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with('error_password', 'Mot de passe actuel incorrect.');
        }
        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);
        return back()->with('success_password', 'Mot de passe modifié avec succès !');
    })->name('parametres.password');

});