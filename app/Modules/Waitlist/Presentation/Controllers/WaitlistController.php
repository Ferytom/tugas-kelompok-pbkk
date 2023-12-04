<?php

namespace App\Modules\Waitlist\Presentation\Controllers;

use App\Modules\Waitlist\Core\Application\Service\WaitlistService;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaitlistController
{
    private $formData = [];
    private $waitlistService;

    public function __construct(WaitlistService $waitlistService)
    {
        $this->waitlistService = $waitlistService;
    }

    public function index()
    {
        $waitlists = $this->waitlistService->getAllWaitlists(); 
        $locations = $this->waitlistService->getAllLocations();

        return view('waitlist::index', compact('waitlists', 'locations'));
    }

    public function create()
    {
        $locations = $this->waitlistService->getAllLocations();
        return view('waitlist::create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'jumlahOrang' => 'required|numeric|min:0',
            'alamat' => 'required|exists:locations,id'
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'jumlahOrang' => $request->input('jumlahOrang'),
            'location_id' => $request->input('alamat', Auth::user()->location_id)
        ];

        $this->waitlistService->createWaitlist($data);

        Cache::forget('waitlists');

        return redirect()->route('waitlist.index')->with('success', 'Waitlist has been created!');
    }

    public function destroy($id)
    {
        $waitlist = $this->waitlistService->getWaitlistById($id);
        if((Auth::user()->role != 'pemilik') && (Auth::user()->location_id != $waitlist->location_id))
        {   
            return redirect()->route('waitlist.index')->with('error', 'You do not have permission to delete this waitlist');
        }

        $this->waitlistService->deleteWaitlist($id);

        Cache::forget('waitlists');
    
        return redirect()->route('waitlist.index')->with('success', 'Waitlist deleted successfully');
    }
}
