<?php

namespace App\Http\Controllers;

use App\Models\User;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    private $formData = [];
    public function index()
    {
        $employees = Cache::remember('employees', 120, function () {
            return User::where('role', '!=', 'pelanggan')->get();
        });
        
        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        return view ('employee.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'noTelepon' => 'required',
            'alamat' => 'required',
            'email' => 'required|unique:users,email|email',
        ]);

        $this->formData['nama'] = $request->input('nama');
        $this->formData['noTelepon'] = $request->input('noTelepon');
        $this->formData['alamat'] = $request->input('alamat');
        $this->formData['email'] = $request->input('email');
        $this->formData['password'] = Hash::make('password');
        if($request->input('role'))
        {
            $this->formData['role'] = $request->input('role');
        }
        else
        {
            $this->formData['role'] = 'karyawan';
        }

        User::create($this->formData);

        Cache::forget('employees');

        return redirect()->route('employee.index')->with('success', 'Employee has been created!');
    }

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        return view('employee.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = User::find($id);

        if ($request->input('nama'))
        {
            $employee->nama = $request->input('name');
        }
        if ($request->input('noTelepon'))
        {
            $employee->noTelepon = $request->input('noTelepon');
        }
        if ($request->input('alamat'))
        {
            $employee->alamat = $request->input('alamat');
        }
        if ($request->input('email'))
        {
            $employee->email = $request->input('email');
        }
        if ($request->input('role'))
        {
            $employee->role = $request->input('role');
        }
        
        $employee->save();

        Cache::forget('employees');
        return redirect()->route('employee.index')->with('success', 'Employee has been updated');    
    }

    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();

        Cache::forget('employees');
    
        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully');
    }
}
