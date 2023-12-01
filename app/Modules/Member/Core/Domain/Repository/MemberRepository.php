<?php

namespace App\Modules\Member\Core\Domain\Repository;

use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Shared\Core\Domain\Model\Location;
use Illuminate\Database\Eloquent\Collection;

interface MemberRepository
{
    public function getAllMembers(): Collection;
}
