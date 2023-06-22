<?php
/**
 * @author Vladislav
 *
 * @email corchagin.vlad2005@yandex.ru
 *
 * @create date 2022-08-15 13:48:51
 *
 * @modify date 2022-08-15 13:48:51
 *
 * @desc [description]
 */

declare(strict_types=1);

namespace app\entities\product;

use Assert\Assertion;

class ProductTitle
{
    private $value;

    public function __construct($value = null)
    {
        Assertion::notNull($value);
        Assertion::string($value);
        Assertion::maxLength($value, 140);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
