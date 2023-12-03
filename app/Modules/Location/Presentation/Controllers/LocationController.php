<?php

namespace App\Modules\Location\Presentation\Controllers;

use Cache;
use Illuminate\Http\Request;

use App\Modules\Location\Core\Application\Service\LocationService;

use App\Modules\Shared\Core\Domain\Model\Location;

class LocationController
{
    private $formData = [];
    private $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function index()
    {
        $locations = $this->locationService->getAllLocations();
        
        return view('location::index', compact('locations'));
    }

    public function create()
    {
        return view ('location::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaLokasi' => 'required',
            'alamat' => 'required',
        ]);

        $data = [
            'namaLokasi' => $request->input('namaLokasi'),
            'alamat' => $request->input('alamat'),
            'googleMap' => $request->input('googleMap', ''),
        ];
        
        $this->locationService->createLocation($data);

        Cache::forget('locations');

        return redirect()->route('location.index')->with('success', 'Location has been created!');
    }

    public function edit($id)
    {
        $location = $this->locationService->getLocationById($id);
        return view('location::edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'namaLokasi' => 'required',
            'alamat' => 'required',
        ]);

        $location = $this->locationService->getLocationById($id);

        $data = [
            'namaLokasi' => $request->input('namaLokasi', $location->namaLokasi),
            'alamat' => $request->input('alamat', $location->alamat),
            'googleMap' => $request->input('googleMap', $location->googleMap),
        ];
        
        $this->locationService->updateLocation($id, $data);

        Cache::forget('locations');
        return redirect()->route('location.index')->with('success', 'Location has been updated');    
    }

    public function destroy($id)
    {
        $this->locationService->deleteLocation($id);

        Cache::forget('locations');
    
        return redirect()->route('location.index')->with('success', 'Location deleted successfully');
    }
}
