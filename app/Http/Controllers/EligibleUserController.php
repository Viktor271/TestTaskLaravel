<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessEligibleUsersFile;
use App\Services\EligibleUserService;
use Illuminate\Http\Request;

class EligibleUserController extends Controller
{
    protected $eligibleUserService;

    public function __construct(EligibleUserService $eligibleUserService)
    {
        $this->eligibleUserService = $eligibleUserService;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'eligible_users' => 'required|file'
        ]);

        $path = $request->file('eligible_users')->store('eligible_files');

        dispatch(new ProcessEligibleUsersFile($path));

        return response()->json(['message' => 'File uploaded and processing']);
    }
}
