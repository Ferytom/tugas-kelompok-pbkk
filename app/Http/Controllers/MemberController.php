<?php

namespace App\Http\Controllers;

use App\Models\User;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    private $formData = [];
    public function index()
    {
        $members = Cache::remember('members', 120, function () {
            return User::where('role', '==', 'pelanggan')->get();
        });
        
        return view('member.index', compact('members'));
    }
}
