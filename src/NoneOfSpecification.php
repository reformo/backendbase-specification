<?php

declare(strict_types=1);

namespace Backendbase\Specification;
class NoneOfSpecification extends Specification
{
    /** @var Specification[] */
    private array $specifications;

    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(
        SpecificationObjectInterface $object,
        SpecificationFailures|null &$failures = null
    ): bool {
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($object, $failures)) {
                return false;
            }
        }

        return true;
    }

    /** @return Specification[] */
    public function specifications(): array
    {
        return $this->specifications;
    }
}
