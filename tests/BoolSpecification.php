<?php

namespace Backendbase\Test\Specification;

use Backendbase\Specification\Specification;
use Backendbase\Specification\SpecificationFailures;
use Backendbase\Specification\SpecificationObjectInterface;

class BoolSpecification extends Specification
{
    private bool $bool;

    public function __construct(bool $bool)
    {
        $this->bool = $bool;
    }

    public function isSatisfiedBy(
        SpecificationObjectInterface $object,
        SpecificationFailures|null &$failures = null
    ): bool {
        return $this->bool;
    }

    public function whereExpression(string $alias): string
    {
        return $this->bool ? '1' : '0';
    }
}