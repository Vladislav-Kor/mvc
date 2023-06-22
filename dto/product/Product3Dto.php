<?php
/**
 * @author Vladislav
 *
 * @email corchagin.vlad2005@yandex.ru
 *
 * @create date 2023-06-13 12:05:28
 *
 * @modify date 2023-06-13 12:05:28
 *
 * @desc [description]
 */
declare(strict_types=1);

namespace app\dto\product;

class Product3Dto
{
    public $offerId;
    public $offerName;
    public $price;
    public $productId;
    public $productName;

    public function load(?array $data = null): void
    {
        if ($data !== null && \is_array($data)) {
            if (isset($data['productId'])) {
                $this->productId = (int) $data['productId'];
            }
            if (isset($data['offerId'])) {
                $this->offerId = (int) $data['offerId'];
            }
            if (isset($data['price'])) {
                $this->price = (float) $data['price'];
            }
            if (isset($data['productName'])) {
                $this->productName = $data['productName'];
            }
            if (isset($data['offerName'])) {
                $this->offerName = $data['offerName'];
            }
        }
    }
}
