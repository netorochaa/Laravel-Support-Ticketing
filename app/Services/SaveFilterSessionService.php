<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class SaveFilterSessionService
{
    public function __construct()
    {
    }

    public function save(array $filters): void
    {
        session()->put("filters", $filters);
    }

    public function clear(): void
    {
        session()->forget('filters');
    }
}
