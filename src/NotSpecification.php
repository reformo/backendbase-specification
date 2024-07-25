<?php

declare(strict_types=1);

namespace Backendbase\Specification;
class NotSpecification extends Specification
{
    public function __construct(private Specification $specification)
    {
    }

    public function isSatisfiedBy(
        SpecificationObjectInterface $object,
        SpecificationFailures|null &$failures = null
    ): bool {
        return ! $this->specification->isSatisfiedBy($object, $failures);
    }

    public function specification(): Specification
    {
        return $this->specification;
    }
}
