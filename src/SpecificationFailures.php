<?php

declare(strict_types=1);

namespace Backendbase\Specification;

class SpecificationFailures
{

    /**
     * @var array<string, mixed>[]
     */
    private array $failures = [];

    public function hasError(): bool
    {
        return !empty($this->failures);
    }

    /**
     * @param bool|null $throwException
     * @return array<int<0, max>, array<int|string, mixed>>
     */
    public function failures(bool|null $throwException = false): array
    {
        $failures = [

        ];
        foreach ($this->failures as $failure) {
            if ($throwException) {
                /** @var class-string $fqcn */
                $fqcn = $failure['type'];
                throw $fqcn::create($failure['message'], $failure['context']);
            }
            $failures[] =
                [
                    $failure['code'] => $failure['message'],
                    'context' => $failure['context']
                ]
            ;
        }

        return $failures;
    }

    /**
     * @param string $type
     * @param string $code
     * @param string $message
     * @param array<string, mixed>|null $context
     * @return void
     */
    public function append(string $type, string $code, string $message, array|null $context = null): void
    {
        $this->failures[] = [
            'type' => $type,
            'code' => $code,
            'message' => $message,
            'context' => $context,
        ];
    }
}
