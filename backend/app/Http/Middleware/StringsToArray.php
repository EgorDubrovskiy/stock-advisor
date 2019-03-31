<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class StringsToArray extends TransformsRequest
{
    /**
     * @var array $available
     */
    protected $available = [
        'years',
        'months',
    ];

    /**
     * @param string $key
     * @param mixed $value
     * @return array|mixed|null
     */
    protected function transform($key, $value)
    {
        if (!in_array($key, $this->available, true)) {
            return $value;
        }

        return is_null($value) ? null : explode(',', $value);
    }
}
