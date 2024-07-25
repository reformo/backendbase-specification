<?php

declare(strict_types=1);

namespace Backendbase\Specification;

use BadMethodCallException;

abstract class Specification implements SpecificationInterface
{
    public function whereExpression(string $alias): string
    {
        throw new BadMethodCallException('Where expression is not supported');
    }

    public function and(Specification $specification): AndSpecification
    {
        return new AndSpecification($this, $specification);
    }

    public function or(Specification $specification): OrSpecification
    {
        return new OrSpecification($this, $specification);
    }

    public function not(): NotSpecification
    {
        return new NotSpecification($this);
    }
}
