<?php

declare(strict_types=1);

namespace app\entities\product;

use Assert\Assertion;

class ProductDescription
{
    /**
     * @var string|null
     */
    private $value;

    public function __construct($value = null)
    {
        Assertion::notNull($value);
        Assertion::string($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
