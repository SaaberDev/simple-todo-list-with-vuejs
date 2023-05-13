<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PasswordCustom implements ValidationRule
{
    public array $errorMessages = [];

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) < 8) {
            $this->errorMessages[] = $this->getErrorMessage('validation.password.min');
        }

        if (!preg_match('/(\p{Ll}+.*\p{Lu})|(\p{Lu}+.*\p{Ll})/u', $value)) {
            $this->errorMessages[] = $this->getErrorMessage('validation.password.mixed');
        }

        if (!preg_match('/\p{Z}|\p{S}|\p{P}/u', $value)) {
            $this->errorMessages[] = $this->getErrorMessage('validation.password.symbols');
        }

        if (!preg_match('/\pN/u', $value)) {
            $this->errorMessages[] = $this->getErrorMessage('validation.password.numbers');
        }

        if (count($this->errorMessages) > 0) {
            $fail($this->displayErrorMessages());
        }
    }

    protected function getErrorMessage($key): string
    {
        $messages = [
            'validation.password.min' => ' 8 characters',
            'validation.password.mixed' => 'one uppercase and one lowercase letter',
            'validation.password.symbols' => 'one symbol',
            'validation.password.numbers' => 'one number'
        ];

        return $messages[$key];
    }

    /**
     * Display error message in comma separated manner
     *
     * @return string
     */
    public function displayErrorMessages(): string
    {
        $str = '';

        foreach ($this->errorMessages as $index => $errorMessage) {
            if ($index == 0) {
                $str .= $errorMessage;
            } elseif ($index == (count($this->errorMessages) - 1)) {
                $str .= ', ' . $errorMessage . '.';
            } else {
                $str .= ', ' . $errorMessage;
            }
        }

        return 'The :attribute ' . 'must contain at least ' . $str;
    }
}
