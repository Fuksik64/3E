<?php

namespace App\Http\Middleware;


class TrimStrings
{
    public function handle(): void
    {
        foreach ($_REQUEST as $key => $value) {
            $_REQUEST[$key] = trim($value);
        }
    }
}