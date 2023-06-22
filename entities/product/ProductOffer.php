<?php
/*
 * @author hexman84 <hexman@live.ru>
 * Date: 05.08.2022
 * Time: 10:40
*/
declare(strict_types=1);

namespace app\entities\product;

class ProductOffer
{
    /**
     * @var ProductOfferActive
     */
    private $active;
    /**
     * @var ProductOfferCount
     */
    private $count;
    /**
     * @var ProductOfferId
     */
    private $id;
    /**
     * @var ProductOfferName
     */
    private $name;
    /**
     * @var ProductOfferPrice
     */
    private $price;
    /**
     * @var ProductId
     */
    private $productId;
    /**
     * @var ProductOfferSort
     */
    private $sort;
    /**
     * @var ProductOfferTovarId
     */
    private $tovar;

    public function __construct(
        ProductOfferId $id,
        ProductId $productId,
        ProductOfferName $name,
        ProductOfferActive $active,
        ProductOfferPrice $price,
        ProductOfferCount $count,
        ProductOfferSort $sort
    ) {
        $this->id = $id;
        $this->productId = $productId;
        $this->active = $active;
        $this->name = $name;
        $this->price = $price;
        $this->sort = $sort;
        $this->count = $count;
     
    }

    public function getActive(): ProductOfferActive
    {
        return $this->active;
    }

    public function getCount(): ProductOfferCount
    {
        return $this->count;
    }

    public function getId(): ProductOfferId
    {
        return $this->id;
    }

    public function getName(): ProductOfferName
    {
        return $this->name;
    }

    public function getPrice(): ProductOfferPrice
    {
        return $this->price;
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function getSort(): ProductOfferSort
    {
        return $this->sort;
    }

    public function isEquals(self $value): bool
    {
        return $this->getId()->getValue() === $value->getId()->getValue();
    }

    public function remove(): void
    {
    }

    public function setActive(ProductOfferActive $active): void
    {
        $this->active = $active;
    }

    public function setCount(ProductOfferCount $count): void
    {
        $this->count = $count;
    }

    public function setId(ProductOfferId $id): void
    {
        $this->id = $id;
    }

    public function setName(ProductOfferName $name): void
    {
        $this->name = $name;
    }

    public function setPrice(ProductOfferPrice $price): void
    {
        $this->price = $price;
    }

    public function setProductId(ProductId $productId): void
    {
        $this->productId = $productId;
    }

    public function setSort(ProductOfferSort $sort): void
    {
        $this->sort = $sort;
    }

}
