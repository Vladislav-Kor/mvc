<?php

declare(strict_types=1);

namespace app\entities\product;

use Assert\Assertion;

class ProductActive
{
    /**
     * @var bool|null
     */
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
