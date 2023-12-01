<?php

namespace App\Modules\Member\Presentation\Controllers;

use App\Modules\Member\Core\Application\Service\MemberService;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use App\Modules\Shared\Core\Domain\Model\User;
use App\Modules\Shared\Core\Domain\Model\Transaction;
use App\Modules\Shared\Core\Domain\Model\Location;

class MemberController
{
    private $formData = [];
    private $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function index()
    {
        $members = $this->memberService->getAllMembers();
        
        return view('member::index', compact('members'));
    }
}
