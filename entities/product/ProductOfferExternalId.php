<?php

declare(strict_types=1);

namespace app\entities\product;

use Assert\Assertion;

class ProductOfferExternalId
{
    private $value;

    public function __construct($value = null)
    {
        Assertion::notNull($value);
        Assertion::integer($value);
        Assertion::greaterOrEqualThan($value, 0);
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isEquals(self $value): bool
    {
        return $this->getValue() === $value->getValue();
    }
}
