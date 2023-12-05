<?php

namespace App\Modules\Employee\Presentation\Controllers;

use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use App\Modules\Employee\Core\Application\Service\EmployeeService;

use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Shared\Core\Domain\Model\Location;

class EmployeeController
{
    private $formData = [];
    private $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        $employees = $this->employeeService->getAllEmployees();
        $locations = $this->employeeService->getAllLocations();
        
        return view('employee::index', compact('employees', 'locations'));
    }

    public function create()
    {
        $locations = $this->employeeService->getAllLocations();
        return view ('employee::create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'noTelepon' => 'required',
            'alamat' => 'required',
            'email' => 'required|unique:users,email|email',
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'noTelepon' => $request->input('noTelepon'),
            'alamat' => $request->input('alamat'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password', 'password')),
            'location_id' => $request->input('location_id', 1),
            'role' => $request->input('role', 'karyawan'),
        ];
        
        $this->employeeService->createEmployee($data);

        Cache::forget('employees');

        return redirect()->route('employee.index')->with('success', 'Employee has been created!');
    }

    public function edit($id)
    {
        $employee = $this->employeeService->getEmployeeById($id);
        $locations = $this->employeeService->getAllLocations();
        return view('employee::edit', compact('employee', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $employee = $this->employeeService->getEmployeeById($id);

        $data = [
            'nama' => $request->input('nama', $employee->nama),
            'noTelepon' => $request->input('noTelepon', $employee->noTelepon),
            'alamat' => $request->input('alamat', $employee->alamat),
            'email' => $request->input('email', $employee->email),
            'location_id' => $request->input('location_id', $employee->location_id),
            'role' => $request->input('role', $employee->role),
        ];

        
        $this->employeeService->updateEmployee($id, $data);

        Cache::forget('employees');
        return redirect()->route('employee.index')->with('success', 'Employee has been updated');    
    }

    public function destroy($id)
    {
        $this->employeeService->deleteEmployee($id);

        Cache::forget('employees');
    
        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully');
    }
}
