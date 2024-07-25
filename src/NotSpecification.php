<?php

declare(strict_types=1);

namespace Backendbase\Specification;
class NotSpecification extends Specification
{
    public function __construct(private SpecificationInterface $specification)
    {
    }

    public function isSatisfiedBy(
        SpecificationObjectInterface $object,
        SpecificationFailures|null &$failures = null
    ): bool {
        return ! $this->specification->isSatisfiedBy($object, $failures);
    }

    public function specification(): SpecificationInterface
    {
        return $this->specification;
    }
}
