<?php

namespace App\Services;

use App\Repositories\EligibleUserRepository;

class EligibleUserService
{
    protected $eligibleUserRepository;

    public function __construct(EligibleUserRepository $eligibleUserRepository)
    {
        $this->eligibleUserRepository = $eligibleUserRepository;
    }

    public function storeData(array $data)
    {
        foreach ($data as $row) {
            $this->eligibleUserRepository->updateOrCreate([
                'user_id' => $row[3]
            ], [
                'name' => $row[0],
                'email' => $row[1],
                'phone' => $row[2]
            ]);
        }
    }
}

