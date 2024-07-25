<?php

declare(strict_types=1);

namespace Backendbase\Specification;

interface SpecificationInterface
{
    public function isSatisfiedBy(
        SpecificationObjectInterface $object,
        SpecificationFailures|null &$failures = null
    ): bool;
}
