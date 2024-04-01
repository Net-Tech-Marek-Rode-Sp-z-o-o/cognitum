<?php

declare(strict_types=1);

namespace Tests\Mocks;

use Illuminate\Contracts\Translation\Translator;

class MockTranslator implements Translator
{
    public function get($key, array $replace = [], $locale = null)
    {
        return $key;
    }

    public function choice($key, $number, array $replace = [], $locale = null)
    {
        return $key;
    }

    public function getLocale()
    {
        return 'pl';
    }

    public function setLocale($locale)
    {
        // do nothing
    }
}
