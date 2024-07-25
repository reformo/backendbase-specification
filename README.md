# PHP Specification

Basic classes for [Specification pattern](https://en.wikipedia.org/wiki/Specification_pattern) in PHP. On top of the typical set of `and`, `or` and `not` specificaitons, `anyOf`, `oneOf`, `noneOf` specifications are proposed.

This package is based on the implementation in [carlosbuenosvinos/ddd](https://github.com/dddinphp/ddd).

## Installation

```
$ composer require reformo/backendbase-specification
```

## Usage example

```php
<?php

use Backendbase\Specification\Specification;
use Backendbase\Specification\OneOfSpecification;

class Order
{
    public function isPaid()
    {
        return true;
    }

    public function isShipped()
    {
        return false;
    }
    
    public function isCancelled()
    {
        return false;
    }
}

class UnshippedOrderSpecification extends Specification
{
    public function isSatisfiedBy($order): bool
    {
        return !$order->isShipped();
    }
}

class PaidOrderSpecification extends Specification
{
    public function isSatisfiedBy($order): bool
    {
        return $order->isPaid();
    }
}

class CancelledOrderSpecification extends Specification
{
    public function isSatisfiedBy($order): bool
    {
        return $order->isCancelled();
    }
}

$paid = new PaidOrderSpecification;
$unshipped = new UnshippedOrderSpecification;
$cancelled = new CancelledOrderSpecification;


$paid->and($unshipped)->isSatisfiedBy(new Order); // => true
(new OneOfSpecification($paid, $unshipped, $cancelled))->isSatisfiedBy(new Order); // => true
```
