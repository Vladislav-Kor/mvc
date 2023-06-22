<?php
/**
 * @author Vladislav
 *
 * @email corchagin.vlad2005@yandex.ru
 *
 * @create date 2022-09-06 19:17:59
 *
 * @modify date 2022-09-06 19:17:59
 *
 * @desc [description]
 */

declare(strict_types=1);

namespace app\dto\product;

class ProductOfferDto
{
    public $active;
    public $count;
    public $id;
    public $name;
    public $price;
    public $productId;
    public $sort;
    public $tovar;

    public function load(?array $data = null): void
    {
        if ($data !== null && \is_array($data)) {
            if (isset($data['id'])) {
                $this->id = (int) $data['id'];
            }
            if (isset($data['sort'])) {
                $this->sort = (int) $data['sort'];
            }
            if (isset($data['price'])) {
                $this->price = (float) $data['price'];
            }
            if (isset($data['count'])) {
                $this->count = (int) $data['count'];
            }
            // if (isset($data['externalId'])) {
            //     $this->externalId = (int) $data['externalId'];
            // }
            if (isset($data['active'])) {
                $this->active = (int) $data['active'];
            }
            if (isset($data['name'])) {
                $this->name = $data['name'];
            }
            if (isset($data['productId'])) {
                $this->productId = (int) $data['productId'];
            }
            if (isset($data['tovar'])) {
                $this->tovar = (int) $data['tovar'];
            }
        }
    }
}
