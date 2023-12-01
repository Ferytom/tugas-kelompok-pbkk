<?php

namespace App\Modules\Employee\Core\Domain\Repository;

use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Shared\Core\Domain\Model\Location;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeRepository
{
    public function getAllEmployees(): Collection;

    public function getAllLocations(): Collection;

    public function getEmployeeById(int $employeeId): User;

    public function createEmployee(array $data): User;

    public function updateEmployee(int $employeeId, array $data): User;

    public function deleteEmployee(int $employeeId): void;
}
