<?php

declare(strict_types=1);

namespace app\entities\product;

use Assert\Assertion;

class ProductOfferName
{
    private $value;

    public function __construct($value = null)
    {
        Assertion::notNull($value);
        Assertion::string($value);
        Assertion::maxLength($value, 50);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
