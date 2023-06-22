<?php
/**
 * @author Vladislav
 *
 * @email corchagin.vlad2005@yandex.ru
 *
 * @create date 2022-08-26 14:01:36
 *
 * @modify date 2022-08-26 14:01:36
 */

declare(strict_types=1);

namespace app\repositories\product;

use app\dto\product\Product3Dto;
use app\dto\product\ProductOfferDto;
use app\entities\product\OfferAdminJson;
use app\entities\product\OfferAllAdminJson;
use app\entities\product\ProductId;
use app\entities\product\ProductName;
use app\entities\product\ProductOffer;
use app\entities\product\ProductOfferActive;
use app\entities\product\ProductOfferCount;
use app\entities\product\ProductOfferId;
use app\entities\product\ProductOfferName;
use app\entities\product\ProductOfferPrice;
use app\entities\product\ProductOfferSort;
use app\entities\product\ProductOfferTovarId;
use app\repositories\Hydrator;
use app\repositories\NotFoundException;

/**
 * ProductOfferRepository.
 */
class ProductOfferRepository
{
    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * __construct.
     */
    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * addProductOffer.
     */
    public function addProductOffer(ProductOffer $offer): ProductOfferId
    {
        \Yii::$app->db->createCommand()->insert('offer', [
            'active' => $offer->getActive()->getValue(),
            'name' => $offer->getName()->getValue(),
            'price' => $offer->getPrice()->getValue(),
            'count' => $offer->getCount()->getValue(),
            'sort' => $offer->getSort()->getValue(),
            'productId' => $offer->getProductId()->getValue(),
        ])->execute();

        $id = \Yii::$app->db->createCommand('SELECT MAX(id) FROM `offer`')->queryScalar();

        return new ProductOfferId((int) $id);
    }

    /**
     * changeActive.
     */
    public function changeActive(ProductOffer $offer): void
    {
        \Yii::$app->db->createCommand('UPDATE `offer` SET `active`=:active WHERE `id`=:id')
            ->bindValue(':id', $offer->getId()->getValue())
            ->bindValue(':active', $offer->getActive()->getValue() === true ? 1 : 0)
            ->execute();
    }

    /**
     * changeTovar.
     *
     * @throws \yii\db\Exception
     */
    public function changeCount(ProductOffer $offer): void
    {
        \Yii::$app->db->createCommand('UPDATE `offer` SET `count`=:count WHERE `id`=:id')
            ->bindValue(':id', $offer->getId()->getValue())
            ->bindValue(':count', $offer->getCount()->getValue())
            ->execute();
    }

    /**
     * changeName.
     *
     * @throws \yii\db\Exception
     */
    public function changeName(ProductOffer $offer): void
    {
        \Yii::$app->db->createCommand('UPDATE `offer` SET `name`=:name WHERE `id`=:id')
            ->bindValue(':id', $offer->getId()->getValue())
            ->bindValue(':name', $offer->getName()->getValue())
            ->execute();
    }

    /**
     * changePrice.
     *
     * @throws \yii\db\Exception
     */
    public function changePrice(ProductOffer $offer): void
    {
        \Yii::$app->db->createCommand('UPDATE `offer` SET `price`=:price WHERE `id`=:id')
            ->bindValue(':id', $offer->getId()->getValue())
            ->bindValue(':price', $offer->getPrice()->getValue())
            ->execute();
    }

    /**
     * changeSort.
     *
     * @throws \yii\db\Exception
     */
    public function changeSort(ProductOffer $offer): void
    {
        \Yii::$app->db->createCommand('UPDATE `offer` SET `sort`=:sort WHERE `id`=:id')
            ->bindValue(':id', $offer->getId()->getValue())
            ->bindValue(':sort', $offer->getSort()->getValue())
            ->execute();
    }

    /**
     * Получить список всех офферов с названиями товаров.
     *
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     *
     * @return array<OfferAllAdminJson>
     */
    public function getAll(): array
    {
        $offers = \Yii::$app->db->createCommand('SELECT `product`.`name` AS productName, '.
            '`offer`.`name` AS offerName,`product`.`id`AS productId,`offer`.`id` AS offerId,`offer`.`price` AS price '.
            'FROM `offer` INNER JOIN `product` ON `product`.`id` = `offer`.`productId` WHERE '.
            '`offer`.`productId`=`product`.`id` ORDER BY `offer`.`id` DESC')
            ->queryAll();
        $res = [];

        foreach ($offers as $offer) {
            $dto = new Product3Dto();
            $dto->load($offer);
            $res[] = $this->hydrator->hydrate(OfferAllAdminJson::class, [
                'id' => new ProductOfferId($dto->offerId),
                'productId' => new ProductId($dto->productId),
                'offerName' => new ProductOfferName($dto->offerName),
                'price' => new ProductOfferPrice($dto->price),
                'productName' => new ProductName($dto->productName),
            ]);
        }

        return $res;
    }

    /**
     * getAllActiveByProduct.
     *
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     *
     * @return array<OfferAdminJson>
     */
    public function getAllActiveByProduct(ProductId $id): array
    {
        $offers = \Yii::$app->db->createCommand('SELECT * FROM `offer` WHERE `productId`=:id AND `active`=1 ORDER BY `price` ASC')
            ->bindValue(':id', $id->getValue())
            ->queryAll();
        $res = [];
        foreach ($offers as $offer) {
            $dto = new ProductOfferDto();
            $dto->load($offer);

            $res[] = $this->hydrator->hydrate(OfferAdminJson::class, [
                'id' => new ProductOfferId($dto->id),
                'productId' => new ProductId($dto->productId),
                'offerName' => new ProductOfferName($dto->name),
                'active' => new ProductOfferActive($dto->active === 1),
                'price' => new ProductOfferPrice($dto->price),
                'count' => new ProductOfferCount($dto->count),
                'sort' => new ProductOfferSort($dto->sort),
            ]);
        }

        return $res;
    }

    /**
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     *
     * @return array<OfferAdminJson>
     */
    public function getAllByProduct(ProductId $id): array
    {
        $offers = \Yii::$app->db->createCommand('SELECT * FROM `offer` WHERE `productId`=:id')
            ->bindValue(':id', $id->getValue())
            ->queryAll();
        $res = [];

        foreach ($offers as $offer) {
            $dto = new ProductOfferDto();
            $dto->load($offer);
            $res[] = $this->hydrator->hydrate(OfferAdminJson::class, [
                'id' => new ProductOfferId($dto->id),
                'productId' => new ProductId($dto->productId),
                'offerName' => new ProductOfferName($dto->name),
                'active' => new ProductOfferActive($dto->active === 1),
                'price' => new ProductOfferPrice($dto->price),
                'count' => new ProductOfferCount($dto->count),
                'sort' => new ProductOfferSort($dto->sort),
            ]);
        }

        return $res;
    }

    /**
     * getAllOfferByProduct.
     *
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     *
     * @return array<ProductOffer>
     */
    public function getAllOfferByProduct(ProductId $id): array
    {
        $offers = \Yii::$app->db->createCommand('SELECT * FROM `offer`  WHERE `productId`=:id ORDER BY `price` ASC')
            ->bindValue(':id', $id->getValue())
            ->queryAll();
        $res = [];

        foreach ($offers as $offer) {
            $dto = new ProductOfferDto();
            $dto->load($offer);

            $res[] = $this->hydrator->hydrate(ProductOffer::class, [
                'id' => new ProductOfferId($dto->id),
                'active' => new ProductOfferActive($dto->active === 1),
                'count' => new ProductOfferCount($dto->count),
                'name' => new ProductOfferName($dto->name),
                'price' => new ProductOfferPrice($dto->price),
                'productId' => new ProductId($dto->productId),
                'sort' => new ProductOfferSort($dto->sort),
            ]);
        }

        return $res;
    }

    public function getOfferByIdTovar(int $id): ProductOffer
    {
        $offer = \Yii::$app->db->createCommand('SELECT * FROM `offer` WHERE `tovar`=:id')
            ->bindValue(':id', $id)
            ->queryOne();
        if (!$offer) {
            throw new NotFoundException('Предложение не найдено');
        }
        $dto = new ProductOfferDto();
        $dto->load($offer);

        return $this->hydrator->hydrate(ProductOffer::class, [
            'id' => new ProductOfferId($dto->id),
            'active' => new ProductOfferActive($dto->active === 1),
            'count' => new ProductOfferCount($dto->count),
            'name' => new ProductOfferName($dto->name),
            'price' => new ProductOfferPrice($dto->price),
            'productId' => new ProductId($dto->productId),
            'sort' => new ProductOfferSort($dto->sort),
        ]);
    }

    /**
     * getProductOfferByProductOfferId.
     *
     * @throws \ReflectionException
     */
    public function getProductOfferById(ProductOfferId $id): ProductOffer
    {
        $offer = \Yii::$app->db->createCommand('SELECT * FROM `offer` WHERE `id`=:id')
            ->bindValue(':id', $id->getValue())
            ->queryOne();
        if (!$offer) {
            throw new NotFoundException('Предложение не найдено');
        }
        $dto = new ProductOfferDto();
        $dto->load($offer);

        return $this->hydrator->hydrate(ProductOffer::class, [
            'id' => new ProductOfferId($dto->id),
            'active' => new ProductOfferActive($dto->active === 1),
            'count' => new ProductOfferCount($dto->count),
            'name' => new ProductOfferName($dto->name),
            'price' => new ProductOfferPrice($dto->price),
            'productId' => new ProductId($dto->productId),
            'sort' => new ProductOfferSort($dto->sort),
        ]);
    }

    /**
     * TODO: Разобраться почему не array.
     *
     * getProductOfferByProductId.
     *
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     */
    public function getProductOfferByProductId(ProductId $id): ProductOffer
    {
        $offer = \Yii::$app->db->createCommand('SELECT * FROM `offer` WHERE `productId`=:id')
            ->bindValue(':id', $id->getValue())
            ->queryOne();
        if (!$offer) {
            throw new NotFoundException('Предложение не найдено');
        }
        $dto = new ProductOfferDto();
        $dto->load($offer);

        return $this->hydrator->hydrate(ProductOffer::class, [
            'id' => new ProductOfferId($dto->id),
            'productId' => new ProductId($dto->productId),
            'name' => new ProductOfferName($dto->name),
            'active' => new ProductOfferActive($dto->active === 1),
            'price' => new ProductOfferPrice($dto->price),
            'count' => new ProductOfferCount($dto->count),
            'sort' => new ProductOfferSort($dto->sort),
        ]);
    }

    /**
     * removeOffer.
     *
     * @throws \yii\db\Exception
     */
    public function removeOffer(ProductOfferId $id): void
    {
        \Yii::$app->db->createCommand('DELETE FROM `offer` WHERE `id`=:id')
            ->bindValue(':id', $id->getValue())
            ->execute();
    }
}
