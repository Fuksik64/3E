<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use App\Http\Middleware\TrimStrings;

class Controller
{
    private Validator $validator;

    private array $middlewares = [
        TrimStrings::class
    ];

    public function __construct()
    {
        $this->handleMiddlewares();
        $this->validator = new Validator();
    }

    private function handleMiddlewares(): void
    {
        foreach ($this->middlewares as $middleware) {
            $middleware = new $middleware();
            $middleware->handle();
        }
    }

    protected function validate(array $rules): array
    {
        return $this->validator->validate($rules);
    }
}