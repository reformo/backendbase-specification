<?php

declare(strict_types=1);

namespace Backendbase\Specification;

use function sprintf;

class AndSpecification extends Specification
{
    public function __construct(private Specification $one, private Specification $other)
    {
    }

    public function isSatisfiedBy(
        SpecificationObjectInterface $object,
        SpecificationFailures|null &$failures = null
    ): bool {
        $isSatisfied = true;
        if (!$this->one->isSatisfiedBy($object, $failures)) {
            $isSatisfied = false;
        }
        if (!$this->other->isSatisfiedBy($object, $failures)) {
            $isSatisfied = false;
        }


        return $isSatisfied;
    }

    public function whereExpression(string $alias): string
    {
        return sprintf(
            '(%s) AND (%s)',
            $this->one()->whereExpression($alias),
            $this->other()->whereExpression($alias),
        );
    }

    public function one(): Specification
    {
        return $this->one;
    }

    public function other(): Specification
    {
        return $this->other;
    }
}
