<?php

declare(strict_types=1);

namespace app\entities\product;

use Assert\Assertion;

class ProductOfferActive
{
    private $value;

    public function __construct($value = null)
    {
        Assertion::notNull($value);
        Assertion::boolean($value);
        $this->value = $value;
    }

    public function getValue(): bool
    {
        return $this->value;
    }
}
