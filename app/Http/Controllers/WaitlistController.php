<?php

namespace App\Http\Controllers;

use App\Models\Waitlist;
use Illuminate\Http\Request;
use Cache;

class WaitlistController extends Controller
{
    private $formData = [];

    public function index()
    {
        $waitlists = Cache::remember('waitlists', 120, function () {
            return Waitlist::all();
        });
        
        return view('waitlist.index', compact('waitlists'));
    }

    public function create()
    {
        return view('waitlist.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'jumlahOrang' => 'required|numeric',
        ]);

        $this->formData['nama'] = $request->input('nama');
        $this->formData['jumlahOrang'] = $request->input('jumlahOrang');

        Waitlist::create($this->formData);

        Cache::forget('waitlists');

        return redirect()->route('waitlist.index')->with('success', 'Waitlist has been created!');
    }

    public function destroy($id)
    {
        $waitlist = Waitlist::findOrFail($id);
        $waitlist->delete();
        Cache::forget('waitlists');
    
        return redirect()->route('waitlist.index')->with('success', 'Waitlist deleted successfully');
    
    }
}
