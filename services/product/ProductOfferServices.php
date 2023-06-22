<?php
/**
 * @author Vladislav
 *
 * @email corchagin.vlad2005@yandex.ru
 *
 * @create date 2022-09-07 16:57:48
 *
 * @modify date 2022-09-07 16:57:48
 *
 * @desc [description]
 */

declare(strict_types=1);

namespace app\services\product;

use app\dto\product\ProductOfferDto;
use app\entities\product\ProductId;
use app\entities\product\ProductOffer;
use app\entities\product\ProductOfferActive;
use app\entities\product\ProductOfferCount;
use app\entities\product\ProductOfferId;
use app\entities\product\ProductOfferName;
use app\entities\product\ProductOfferPrice;
use app\entities\product\ProductOfferSort;
use app\repositories\product\ProductOfferRepository;

final class ProductOfferServices
{
    /**
     * @var ProductOfferRepository
     */
    private $repository;

    public function __construct(ProductOfferRepository $repo)
    {
        $this->repository = $repo;
    }

    public function addProductOffer(ProductOfferDto $dto): ProductOffer
    {
        $offer = new ProductOffer(
            new ProductOfferId(0),
            new ProductId($dto->productId),
            new ProductOfferName($dto->name),
            new ProductOfferActive(true),
            new ProductOfferPrice($dto->price),
            new ProductOfferCount($dto->count),
            new ProductOfferSort(1),
        );

        $offer->setId($this->repository->addProductOffer($offer));

        return $offer;
    }

    /**
     * changeActive.
     *
     * @param int|ProductOfferId      $id
     * @param bool|ProductOfferActive $active
     */
    public function changeActive($id, $active): void
    {
        $offer = $this->getProductOfferById($id);
        if ($active instanceof ProductOfferActive) {
            $offer->setActive($active);
        } else {
            $offer->setActive(new ProductOfferActive($active));
        }
        $this->repository->changeActive($offer);
    }

    /**
     * changeCount.
     *
     * @param int|ProductOfferId    $offerId
     * @param int|ProductOfferCount $count
     *
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     */
    public function changeCount($offerId, $count): void
    {
        $offer = $this->getProductOfferById($offerId);

        if ($count instanceof ProductOfferCount) {
            $offer->setCount($count);
        } else {
            $offer->setCount(new ProductOfferCount($count));
        }
        $this->repository->changeCount($offer);
    }

    /**
     * changeName.
     *
     * @param int|ProductOfferId      $id
     * @param ProductOfferName|string $name
     *
     * @throws \ReflectionException
     */
    public function changeName($id, $name): void
    {
        $offer = $this->getProductOfferById($id);
        if ($name instanceof ProductOfferName) {
            $offer->setName($name);
        } else {
            $offer->setName(new ProductOfferName($name));
        }
        $this->repository->changeName($offer);
    }

    /**
     * changePrice.
     *
     * @param int|ProductOfferId      $id
     * @param float|ProductOfferPrice $price
     *
     * @throws \ReflectionException
     */
    public function changePrice($id, $price): void
    {
        $offer = $this->getProductOfferById($id);
        if ($price instanceof ProductOfferPrice) {
            $offer->setPrice($price);
        } else {
            $offer->setPrice(new ProductOfferPrice($price));
        }
        $this->repository->changePrice($offer);
    }

    /**
     * @param int|ProductOfferId   $id
     * @param int|ProductOfferSort $sort
     *
     * @throws \ReflectionException
     */
    public function changeSort($id, $sort): void
    {
        $offer = $this->getProductOfferById($id);
        if ($sort instanceof ProductOfferSort) {
            $offer->setSort($sort);
        } else {
            $offer->setSort(new ProductOfferSort($sort));
        }
        $this->repository->changeSort($offer);
    }

    /**
     * @return array<OfferAllAdminJson>
     */
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    /**
     * @param int|ProductId $id
     *
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     *
     * @return array<OfferAdminJson>
     */
    public function getAllActiveByProduct($id): array
    {
        if ($id instanceof ProductId) {
            return $this->repository->getAllActiveByProduct($id);
        }

        return $this->repository->getAllActiveByProduct(new ProductId($id));
    }

    /**
     * @param int|ProductId $id
     *
     * @return array<OfferAdminJson>
     */
    public function getAllByProduct($id): array
    {
        if ($id instanceof ProductId) {
            return $this->repository->getAllByProduct($id);
        }

        return $this->repository->getAllByProduct(new ProductId($id));
    }

    /**
     * @param int|ProductId $id
     *
     * @return array<ProductOffer>
     */
    public function getAllOfferByProduct($id): array
    {
        if ($id instanceof ProductId) {
            return $this->repository->getAllOfferByProduct($id);
        }

        return $this->repository->getAllOfferByProduct(new ProductId($id));
    }

    /**
     * @param int|ProductOfferId $id
     *
     * @throws \ReflectionException
     */
    public function getProductOfferById($id): ProductOffer
    {
        if ($id instanceof ProductOfferId) {
            return $this->repository->getProductOfferById($id);
        }

        return $this->repository->getProductOfferById(new ProductOfferId($id));
    }

    /**
     * @param int|ProductId $id
     */
    public function getProductOfferByProductId($id): ProductOffer
    {
        if ($id instanceof ProductId) {
            return $this->repository->getProductOfferByProductId($id);
        }

        return $this->repository->getProductOfferByProductId(new ProductId($id));
    }

    /**
     * @param int|ProductOfferId $id
     *
     * @throws \ReflectionException
     */
    public function removeOffer($id): void
    {
        $offer = $this->getProductOfferById($id);
        $this->repository->removeOffer($offer->getId());
    }
}
