<?php

declare(strict_types=1);

namespace Backendbase\Specification;
use function array_map;
use function implode;

class OneOfSpecification extends Specification
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
                return true;
            }
        }

        return false;
    }

    public function whereExpression(string $alias): string
    {
        return implode(' OR ', array_map(
            static function (Specification $specification) use ($alias) {
                return '(' . $specification->whereExpression($alias) . ')';
            },
            $this->specifications,
        ));
    }

    /** @return Specification[] */
    public function specifications(): array
    {
        return $this->specifications;
    }
}
