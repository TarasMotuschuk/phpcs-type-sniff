<?php

namespace Gskema\TypeSniff\Sniffs\fixtures;

class TestClass16
{
    public string $countryCode
    {
        set (string $countryCode) {
            $this->countryCode = strtoupper($countryCode);
        }
    }

    public string $combinedCode
    {
        get => $this->languageCode . '_' . $this->countryCode;
    }

    public function __construct(
        private string $languageCode,
        private string $countryCode,
    ) {
    }
}
