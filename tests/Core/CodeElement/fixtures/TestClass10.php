<?php

namespace Gskema\TypeSniff\Core\CodeElement\fixtures;

class TestClass10
{
    public string $countryCode {
        set (string $countryCode) {
            $this->countryCode = strtoupper($countryCode);
        }
    }
}
