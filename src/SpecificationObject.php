<?php

declare(strict_types=1);

namespace Backendbase\Specification;

use function get_object_vars;

abstract class SpecificationObject implements SpecificationObjectInterface
{
    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
