<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public $user;

    public function list(): LengthAwarePaginator
    {
        $data = User::paginate(5);
        return $data;
    }

    public function store(array $data)
    {
        //User store
    }
}
