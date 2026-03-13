<?php
namespace App\Http\Controllers;

use App\Models\Chambre;
use Illuminate\Http\Request;

class ChambreController extends Controller
{
    public function index()
    {
        $chambres = Chambre::all();
        return view('chambres.index', compact('chambres'));
    }

    public function create()
    {
        return view('chambres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero'    => 'required|unique:chambres',
            'type'      => 'required',
            'prix_nuit' => 'required|numeric',
            'capacite'  => 'required|integer',
        ]);

        Chambre::create($request->all());
        return redirect('/chambres')->with('success', 'Chambre ajoutée avec succès !');
    }

    public function show(Chambre $chambre)
    {
        return view('chambres.show', compact('chambre'));
    }

    public function edit(Chambre $chambre)
    {
        return view('chambres.edit', compact('chambre'));
    }

    public function update(Request $request, Chambre $chambre)
    {
        $request->validate([
            'numero'    => 'required|unique:chambres,numero,' . $chambre->id,
            'type'      => 'required',
            'prix_nuit' => 'required|numeric',
            'capacite'  => 'required|integer',
        ]);

        $chambre->update($request->all());
        return redirect('/chambres')->with('success', 'Chambre modifiée avec succès !');
    }

    public function destroy(Chambre $chambre)
    {
        $chambre->delete();
        return redirect('/chambres')->with('success', 'Chambre supprimée !');
    }
}