<?php

declare(strict_types=1);

namespace Blockpc\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class OnlyKeysFromCollectionRule implements ValidationRule
{
    public function __construct(
        protected $collection,
        protected string $message = 'El valor seleccionado no es valido.'
    ) {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // if collection is an Collection get the keys
        if (is_a($this->collection, 'Illuminate\Support\Collection')) {
            $keys = $this->collection->keys()->all();
        }

        // if collection is an array get the keys
        if (is_array($this->collection)) {
            $keys = array_keys($this->collection);
        }

        // if collection is empty, return 'La collecion esta vacia.'
        if (empty($keys)) {
            $fail('La colección esta vacia.');

            return;
        }

        if (! in_array($value, $keys)) {
            $fail($this->message);
        }
    }
}
