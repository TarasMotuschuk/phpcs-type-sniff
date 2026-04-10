<?php

namespace Gskema\TypeSniff\Core\CodeElement\fixtures;

class TestClass13
{
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
