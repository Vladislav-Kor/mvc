<?php

declare(strict_types=1);

namespace app\entities\product;

use Assert\Assertion;

class ProductUrl
{
    private $value;

    public function __construct($value = null)
    {
        Assertion::notNull($value);
        Assertion::string($value);
        Assertion::notBlank($value);
        Assertion::maxLength($value, 120);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
