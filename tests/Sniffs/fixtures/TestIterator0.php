<?php

namespace Gskema\TypeSniff\Sniffs\fixtures;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class TestIterator0 implements IteratorAggregate
{
    public function getIterator(): Traversable
    {
        return new ArrayIterator([]);
    }
}
