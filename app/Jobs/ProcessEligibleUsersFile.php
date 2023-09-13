<?php

namespace App\Jobs;

use App\Services\EligibleUserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessEligibleUsersFile implements ShouldQueue
{
    use Queueable;

    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function handle(EligibleUserService $eligibleUserService)
    {
        $data = array_map('str_getcsv', file($this->path));
        $eligibleUserService->storeData($data);
    }
}
