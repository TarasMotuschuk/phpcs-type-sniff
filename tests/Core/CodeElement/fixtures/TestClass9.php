<?php

namespace Gskema\TypeSniff\Core\CodeElement\fixtures;

class Factory9
{
    public function create(): object
    {
        return new \stdClass();
    }
}

class TestClass9
{
    public object $prop1 = new Factory9()->create();
}
