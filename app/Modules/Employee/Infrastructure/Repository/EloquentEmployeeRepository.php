<?php

namespace App\Modules\Employee\Infrastructure\Repository;
use App\Modules\Employee\Core\Domain\Repository\EmployeeRepository;
use Cache;

use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Shared\Core\Domain\Model\Location;
use Illuminate\Database\Eloquent\Collection;


class EloquentEmployeeRepository implements EmployeeRepository
{
    public function getAllEmployees(): Collection
    {
        $employees = Cache::remember('employees', 120, function () {
            return User::where('role', '!=', 'pelanggan')->get();
        });

        foreach($employees as $employee)
        {
            $location = Location::findOrFail($employee->location_id);
            $employee->location_address = $location->alamat;
        }

        return $employees;
    }

    public function getAllLocations(): Collection
    {
        $locations = Cache::remember('locations', 120, function () {
            return Location::all();
        });

        return $locations;
    }

    public function createEmployee(array $data): User
    {
        return User::create($data);
    }

    public function getEmployeeById(int $employeeId): User
    {
        $employee = User::findOrFail($employeeId);
        return $employee;
    }

    public function updateEmployee(int $employeeId, array $data): User
    {
        $employee = User::findOrFail($employeeId);
        $employee->update($data);
        return $employee;
    }

    public function deleteEmployee(int $employeeId): void
    {
        User::destroy($employeeId);
    }
}
