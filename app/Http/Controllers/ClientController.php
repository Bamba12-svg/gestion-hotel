<?php
namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'       => 'required',
            'prenom'    => 'required',
            'cin'       => 'required|unique:clients',
            'telephone' => 'required',
        ]);

        Client::create($request->all());
        return redirect('/clients')->with('success', 'Client ajouté avec succès !');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'nom'       => 'required',
            'prenom'    => 'required',
            'cin'       => 'required|unique:clients,cin,' . $client->id,
            'telephone' => 'required',
        ]);

        $client->update($request->all());
        return redirect('/clients')->with('success', 'Client modifié avec succès !');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect('/clients')->with('success', 'Client supprimé !');
    }
}