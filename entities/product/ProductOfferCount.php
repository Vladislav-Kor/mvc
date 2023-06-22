<?php

declare(strict_types=1);

namespace app\entities\product;

use Assert\Assertion;

class ProductOfferCount
{
    private $value;

    public function __construct($value = null)
    {
        Assertion::notNull($value);
        Assertion::integer($value);
        Assertion::greaterOrEqualThan($value, 0);
        Assertion::max($value, 10000);
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
