<?php

namespace App\Services;

use App\Models\User;
use App\Services\ImageOptimization\TinyPngService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public $user;
    protected $tinyPngService;

    public function __construct(TinyPngService $tinyPngService)
    {
        $this->tinyPngService = $tinyPngService;
    }

    public function list(): LengthAwarePaginator
    {
        $data = User::paginate(6);
        return $data;
    }

    
    public function store(array $data): User
    {
        if (isset($data['photo']) && $data['photo']) {
            $path = $data['photo']->store('users', 'public');
            $data['photo'] = $path;


            $optimizedImagePath = $this->tinyPngService->optimizeImage($path);
            if ($optimizedImagePath) {
                $data['photo'] = $optimizedImagePath;
            }
        }
        
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

}
