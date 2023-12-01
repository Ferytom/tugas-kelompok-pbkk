<?php

namespace App\Modules\Member\Core\Application\Service;

use App\Modules\Member\Core\Domain\Repository\MemberRepository;
use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Shared\Core\Domain\Model\Location;
use Illuminate\Database\Eloquent\Collection;

class MemberService
{
    private $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function getAllMembers(): Collection
    {
        return $this->memberRepository->getAllMembers();
    }
}

