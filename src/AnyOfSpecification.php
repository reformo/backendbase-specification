<?php

declare(strict_types=1);

namespace Backendbase\Specification;
use function array_map;
use function implode;

class AnyOfSpecification extends Specification
{
    /** @var Specification[] */
    private array $specifications;

    public function __construct(SpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(
        SpecificationObjectInterface $object,
        SpecificationFailures|null &$failures = null
    ): bool {
        $isSatisfied = true;
        foreach ($this->specifications as $specification) {
            if (! $specification->isSatisfiedBy($object, $failures)) {
                $isSatisfied  = false;
            }
        }

        return $isSatisfied;
    }

    public function whereExpression(string $alias): string
    {
        return implode(' AND ', array_map(
            static function (Specification $specification) use ($alias) {
                return '(' . $specification->whereExpression($alias) . ')';
            },
            $this->specifications,
        ));
    }

    /** @return SpecificationInterface[] */
    public function specifications(): array
    {
        return $this->specifications;
    }
}
