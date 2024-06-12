<?php

namespace Gskema\TypeSniff\Sniffs\fixtures;

class TestClass0
{
    public const int C1 = 1;

    /** @var array */
    public const int C2 = 2;

    public const array C3 = [];

    /** @var string[] */
    public const array C4 = [];

    private $prop1;

    /**
     * @see something
     */
    private $prop2;

    /** @var */
    private $prop3;

    /**  @var array */
    private $prop4;

    /** @var array|string */
    private $prop5;

    /** @var string */
    private $prop6 = [];

    /** @var string[] */
    private $prop7 = [];

    /** @var int $prop8 */
    private $prop8 = 8;

    /** @var string[]|object[] */
    private $prop9 = [];

    /** @var string[]|array */
    private $prop10 = [];

    /** @var int[]|null[] */
    public const array C5 = [null, 1];

    /** @var string[]|array */
    public const array C6 = [null, 1];

    /** @var array[] */
    public const array C7 = [];

    /** @var array[][] */
    private $prop11 = [];

    /** @var int|string */
    protected int|string $prop12;
}
