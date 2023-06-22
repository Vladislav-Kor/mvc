<?php

declare(strict_types=1);

namespace app\entities\product;

use Assert\Assertion;

class ProductImg
{
    /**
     * @var string|null
     */
    private $value;

    public function __construct($value = null)
    {
        Assertion::notNull($value);
        Assertion::string($value);
        Assertion::maxLength($value, 45);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
