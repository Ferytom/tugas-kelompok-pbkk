<?php

namespace App\Modules\Promo\Presentation\Controllers;

use App\Modules\Promo\Core\Application\Service\PromoService;
use Cache;
use Illuminate\Http\Request;

class PromoController
{
    private $formData = [];
    private $promoService;

    public function __construct(PromoService $promoService)
    {
        $this->promoService = $promoService;
    }

    public function index()
    {
        $expired_promos =$this->promoService->getAllExpiredPromos(); 
        $active_promos = $this->promoService->getAllActivePromos();
        
        return view('promo::index', compact('expired_promos', 'active_promos'));
    }

    public function create()
    {
        return view('promo::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'detail' => 'required',
            'persenDiskon' => 'required|numeric|min:0|max:100',
            'maxDiskon' => 'required|numeric|min:0',
            'expired' => 'required|date'
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'detail' => $request->input('detail'),
            'persenDiskon' => $request->input('persenDiskon'),
            'maxDiskon' => $request->input('maxDiskon'),
            'expired' => $request->input('expired'),
        ];

        $this->promoService->createPromo($data);

        Cache::forget('expired_promos');
        Cache::forget('active_promos');
    
        return redirect()->route('promo.index')->with('success', 'Promo has been created!');
    }

    public function edit($id)
    {
        $promo = $this->promoService->getPromoById($id);
        return view('promo::edit', compact('promo'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'persenDiskon' => 'numeric|min:0|max:100',
            'maxDiskon' => 'numeric|min:0',
            'expired' => 'date'
        ]);

        $promo = $this->promoService->getPromoById($id);

        $data = [
            'nama' => $request->input('nama', $promo->nama),
            'detail' => $request->input('detail', $promo->detail),
            'persenDiskon' => $request->input('persenDiskon', $promo->persenDiskon),
            'maxDiskon' => $request->input('maxDiskon', $promo->maxDiskon),
            'expired' => $request->input('expired', $promo->expired),
        ];
        
        $this->promoService->updatePromo($id, $data);

        Cache::forget('expired_promos');
        Cache::forget('active_promos');
    
        return redirect()->route('promo.index')->with('success', 'Promotion has been updated');    
    }

    public function destroy($id)
    {
        $this->promoService->deletePromo($id);

        Cache::forget('expired_promos');
        Cache::forget('active_promos');
    
        return redirect()->route('promo.index')->with('success', 'Promotion deleted successfully');
    }
}