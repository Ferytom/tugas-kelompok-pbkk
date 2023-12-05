<?php

namespace App\Modules\Waitlist\Infrastructure\Repository;
use App\Modules\Waitlist\Core\Domain\Repository\WaitlistRepository;
use App\Modules\Shared\Core\Domain\Model\Waitlist;
use App\Modules\Shared\Core\Domain\Model\Location;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Modules\Shared\Core\Domain\Model\Menu;
use Illuminate\Database\Eloquent\Collection;


class EloquentWaitlistRepository implements WaitlistRepository
{
    public function getAllWaitlists(): Collection
    {
        if (Auth::user()->role == 'pemilik')
        {
            $waitlists = Cache::remember('waitlists', 120, function () {
                return Waitlist::all();
            });
        }
        else
        {
            $waitlists = Cache::remember('waitlists', 120, function () {
                return Waitlist::where('location_id', '=', Auth::user()->location_id)->get();
            });
        }

        foreach ($waitlists as $waitlist)
        {
            $location = Location::findOrFail($waitlist->location_id);
            $waitlist->alamat = $location->alamat;
        }

        return $waitlists;
    }

    public function getAllLocations(): Collection
    {
        if(Auth::user()->role == 'pemilik')
        {
            $locations = Cache::remember('locations', 120, function () {
                return Location::all();
            });
        }
        else
        {
            $locations = Cache::remember('locations', 120, function () {
                return Location::where('id', '=', Auth::user()->location_id)->get();
            });
        }

        return $locations;
    }
    
    public function getWaitlistById(int $id): Waitlist
    {
        $waitlist = Waitlist::findOrFail($id);
        return $waitlist;
    }

    public function createWaitlist(array $data): Waitlist
    {
        return Waitlist::create($data);
    }

    public function deleteWaitlist(int $waitlistId): void
    {
        Waitlist::destroy($waitlistId);
    }
}
