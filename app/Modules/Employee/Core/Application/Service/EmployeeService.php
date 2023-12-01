<?php

namespace App\Modules\Employee\Core\Application\Service;

use App\Modules\Employee\Core\Domain\Repository\EmployeeRepository;
use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Shared\Core\Domain\Model\Location;
use Illuminate\Database\Eloquent\Collection;

class EmployeeService
{
    private $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function getAllEmployees(): Collection
    {
        return $this->employeeRepository->getAllEmployees();
    }

    public function getAllLocations(): Collection
    {
        return $this->employeeRepository->getAllLocations();
    }

    public function createEmployee($data): User
    {
        return $this->employeeRepository->createEmployee($data);
    }

    public function getEmployeeById($id): User
    {
        return $this->employeeRepository->getEmployeeById($id);
    }

    public function updateEmployee($employeeId, $data): User
    {
        return $this->employeeRepository->updateEmployee($employeeId, $data);
    }

    public function deleteEmployee($employeeId): void
    {
        $this->employeeRepository->deleteEmployee($employeeId);
    }
}

