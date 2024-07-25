<?php

declare(strict_types=1);

namespace Backendbase\Specification;
use function array_map;
use function implode;

class OneOfSpecification extends Specification
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
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($object, $failures)) {
                return true;
            }
        }

        return false;
    }

    public function whereExpression(string $alias): string
    {
        return implode(' OR ', array_map(
            static function (SpecificationInterface $specification) use ($alias) {
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
