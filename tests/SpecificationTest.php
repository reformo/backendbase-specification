<?php

namespace Backendbase\Test\Specification;

use PHPUnit\Framework\TestCase;
use Backendbase\Specification\AnyOfSpecification;
use Backendbase\Specification\AndSpecification;
use Backendbase\Specification\NoneOfSpecification;
use Backendbase\Specification\OneOfSpecification;
use Backendbase\Specification\OrSpecification;
class SpecificationTest extends TestCase
{
    public function testSpecification()
    {

        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);
        $this->assertTrue($trueSpec->isSatisfiedBy(new SpecificationTestObject()));
        $this->assertFalse($falseSpec->isSatisfiedBy(new SpecificationTestObject()));
    }

    public function testNotSpecification()
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);
        $notTrueSpec  = $trueSpec->not();
        $notFalseSpec = $falseSpec->not();
        $this->assertFalse($notTrueSpec->isSatisfiedBy(new SpecificationTestObject()));
        $this->assertTrue($notFalseSpec->isSatisfiedBy(new SpecificationTestObject()));
    }

    public function testAndSpecification()
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);
        $trueAndTrueSpec  = $trueSpec->and($trueSpec);
        $trueAndFalseSpec = $trueSpec->and($falseSpec);
        $this->assertTrue($trueAndTrueSpec->isSatisfiedBy(new SpecificationTestObject()));
        $this->assertFalse($trueAndFalseSpec->isSatisfiedBy(new SpecificationTestObject()));
    }

    public function testOrSpecification()
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);
        $trueOrTrueSpec  = $trueSpec->or($trueSpec);
        $trueOrFalseSpec = $trueSpec->or($falseSpec);
        $this->assertTrue($trueOrTrueSpec->isSatisfiedBy(new SpecificationTestObject()));
        $this->assertTrue($trueOrFalseSpec->isSatisfiedBy(new SpecificationTestObject()));
    }

    public function testAnyOfSpecification()
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);
        $this->assertTrue((new AnyOfSpecification($trueSpec, $trueSpec, $trueSpec))
            ->isSatisfiedBy(new SpecificationTestObject()));
        $this->assertFalse((new AnyOfSpecification($trueSpec, $trueSpec, $falseSpec))
            ->isSatisfiedBy(new SpecificationTestObject()));
    }

    public function testOneOfSpecification()
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);
        $this->assertFalse((new OneOfSpecification($falseSpec, $falseSpec, $falseSpec))
            ->isSatisfiedBy(new SpecificationTestObject()));
        $this->assertTrue((new OneOfSpecification($falseSpec, $falseSpec, $trueSpec))
            ->isSatisfiedBy(new SpecificationTestObject()));
    }

    public function testNoneOfSpecification()
    {
        $trueSpec  = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);
        $this->assertTrue((new NoneOfSpecification($falseSpec, $falseSpec, $falseSpec))
            ->isSatisfiedBy(new SpecificationTestObject()));
        $this->assertFalse((new NoneOfSpecification($falseSpec, $falseSpec, $trueSpec))
            ->isSatisfiedBy(new SpecificationTestObject()));
    }

    public function testCriteriaComposition()
    {
        $trueSpec = new BoolSpecification(true);
        $falseSpec = new BoolSpecification(false);
        $compositeSpec =
            new AnyOfSpecification(
                $trueSpec->and($falseSpec)->or($trueSpec)->and($falseSpec),
                new OneOfSpecification($trueSpec, $falseSpec, $trueSpec),
                $trueSpec
            );
        $this->assertSame(
            '((((1) AND (0)) OR (1)) AND (0)) AND ((1) OR (0) OR (1)) AND (1)',
            $compositeSpec->whereExpression('a')
        );
    }

    public function testWhereExpressionIsNotSupported()
    {
        $this->expectException(\BadMethodCallException::class);
        (new BoolSpecification(true))->not()->whereExpression('a');
    }
}


