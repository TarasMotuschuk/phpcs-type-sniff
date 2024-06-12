<?php

namespace Gskema\TypeSniff\Core\CodeElement\fixtures;

class TestClass2
{
    public const int|null C01 = null;
    public const false C02 = false;
    public const bool C03 = true;
    public const int C04 = 1;
    public const float C05 = 1.1;
    public const C06 = -1;
    public const string C07 = 'a';
    public const C08 = "b";
    public const C09 = <<<MUL
c
MUL;
    public const array C10 = [];
    public const C11 = array(1, 2, 3);
    public const C12 = self::C01;
    public const C13 = SomeClass::CONST1;
    public const C14    = /*comment*/2;
    public $prop1;
    public $prop2 = 1;
}
