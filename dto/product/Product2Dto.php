<?php
/*
 * @author hexman84 <hexman@live.ru>
 * Date: 16.11.2022
 * Time: 14:39
*/
declare(strict_types=1);

namespace app\dto\product;

class Product2Dto
{
    public $productId;

    public function load(?array $data = null): void
    {
        if ($data !== null && \is_array($data)) {
            if (isset($data['productId'])) {
                $this->productId = (int) $data['productId'];
            }
        }
    }
}
