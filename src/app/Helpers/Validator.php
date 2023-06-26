<?php

namespace App\Helpers;

class Validator
{
    private array $errors = [];

    public function validate(array $rules): array
    {
        $result = [];
        foreach ($rules as $param => $rule) {
            $parts = explode('|', $rule);

            foreach ($parts as $part) {
                $this->validateRule($param, $part);
            }
            $this->printErrors();

            $result[$param] = $_REQUEST[$param];
        }
        return $result;
    }

    private function validateRule(string $param, string $part): void
    {
        $matchPart = $part;
        if (str_contains($part, ':')) {
            $matchPart = explode(':', $part)[0];
        }

        match ($matchPart) {
            'required' => $this->validateRequired($param),
            'string' => $this->validateString($param),
            'email' => $this->validateEmail($param),
            'numeric' => $this->validateNumeric($param),
            'phone' => $this->validatePhone($param),
            'min' => $this->validateMin($param, $part),
            'max' => $this->validateMax($param, $part),
            'unique' => $this->validateUnique($param, $part),
            default => throw new \RuntimeException('Unknown rule')
        };

    }

    private function printErrors(): void
    {
        if (count($this->errors) > 0) {
            echo '<pre>';
            foreach ($this->errors as $error) {
                echo $error . PHP_EOL;
            }
            throw new \RuntimeException('Validation failed');
            echo '<pre>';
        }
    }

    private function validateUnique($param, $part): void
    {
        preg_match('/:(.*),/', $part, $matches);
        $table = rtrim(ltrim($matches[1], ':'), ',');
        preg_match('/,(.*)/', $part, $matches);
        $column = ltrim($matches[1], ',');

        $result = (new \App\Models\Model())->getByColumn($table, $column, $_REQUEST[$param]);
        if (count($result)) {
            $this->errors[] = "{$param} must be unique";
        }
    }

    private function validateMin($param, $part): void
    {
        $min = explode(':', $part)[1];
        if (is_numeric($_REQUEST[$param]) && (int)$_REQUEST[$param] < $min) {
            $this->errors[] = "{$param} must be at least {$min}";
        } else if (strlen((string)$_REQUEST[$param]) < $min) {
            $this->errors[] = "{$param} must be at least {$min} characters";
        }
    }

    private function validateMax($param, $part): void
    {
        $max = explode(':', $part)[1];
        if (is_numeric($_REQUEST[$param]) && (int)$_REQUEST[$param] > $max) {
            $this->errors[] = "{$param} must be at most {$max}";
        } else if (strlen((string)$_REQUEST[$param]) > $max) {
            $this->errors[] = "{$param} must be at most {$max} characters";
        }
    }


    private function validatePhone($param): void
    {
        if (isset($_REQUEST[$param]) && !preg_match('/[0-9]{3}-[0-9]{3}-[0-9]{3}/', $_REQUEST[$param])) {
            $this->errors[] = "{$param} must be phone";
        }
    }

    private function validateEmail($param): void
    {
        if (isset($_REQUEST[$param]) && !filter_var($_REQUEST[$param], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "{$param} must be email";
        }
    }

    private function validateString($param): void
    {
        if (isset($_REQUEST[$param]) && !is_string($_REQUEST[$param])) {
            $this->errors[] = "{$param} must be string";
        }
    }

    private function validateNumeric($param): void
    {
        if (isset($_REQUEST[$param]) && !is_numeric($_REQUEST[$param])) {
            $this->errors[] = "{$param} must be numeric";
        }
    }

    private function validateRequired($param): void
    {
        if (!isset($_REQUEST[$param])) {
            $this->errors[] = "{$param} is required";
        }
    }
}