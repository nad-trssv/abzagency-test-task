<?php

namespace App\Services;

use App\Models\Position;

class PositionService
{
    /**
     * Create a new class instance.
     */
    public function list()
    {
        $data = Position::orderByDesc('id')->get();
        return $data;
    }
}
