<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class PromoController extends Controller
{
    private $formData = [];
    public function index()
    {
        $expired_promos = Cache::remember('expired_promos', 120, function () {
            $current_date = Carbon::now()->format('Y-m-d');
            return Promo::where('expired', '<', $current_date)->get();
        });
        $active_promos = Cache::remember('active_promos', 120, function () {
            $current_date = Carbon::now()->format('Y-m-d');
            return Promo::where('expired', '>=', $current_date)->get();
        });
    
        return view('promo.index', compact('expired_promos', 'active_promos'));
    }

    public function create()
    {
        return view ('promo.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'detail' => 'required',
            'persenDiskon' => 'required|numeric|min:0|max:100',
            'maxDiskon' => 'required|numeric|min:0',
            'expired' => 'required|date'
        ]);

        $this->formData['detail'] = $request->input('detail');
        $this->formData['persenDiskon'] = $request->input('persenDiskon');
        $this->formData['maxDiskon'] = $request->input('maxDiskon');
        $this->formData['expired'] = $request->input('expired');

        Promo::create($this->formData);

        Cache::forget('expired_promos');
        Cache::forget('active_promos');
    
        return redirect()->route('promo.index')->with('success', 'Promo has been created!');
    }

    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return view('promo.edit', compact('promo'));
    }

    public function update(Request $request, $id)
    {
        

        $promo = Promo::find($id);
        if ($request->input('detail'))
        {
            $promo->detail = $request->input('detail');
        }
        if ($request->input('persenDiskon'))
        {
            $promo->persenDiskon = $request->input('persenDiskon');
        }
        if ($request->input('maxDiskon'))
        {
            $promo->maxDiskon = $request->input('maxDiskon');
        }
        if ($request->input('expired'))
        {
            $promo->expired = $request->input('expired');
        }
        
        $promo->save();
        Cache::forget('expired_promos');
        Cache::forget('active_promos');
    
        return redirect()->route('promo.index')->with('success', 'Promotion has been updated');    
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        Cache::forget('expired_promos');
        Cache::forget('active_promos');
    
        return redirect()->route('promo.index')->with('success', 'Promotion deleted successfully');
    }
}
