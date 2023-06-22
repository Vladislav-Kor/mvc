<?php

declare(strict_types=1);

namespace app\entities\product;

use Assert\Assertion;

class ProductOfferSort
{
    private $value;

    public function __construct($value = null)
    {
        Assertion::integer($value);
        Assertion::max($value, 12640);
        Assertion::greaterOrEqualThan($value, 0);
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
