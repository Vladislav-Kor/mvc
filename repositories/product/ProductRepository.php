<?php
/**
 * @author Vladislav
 *
 * @email corchagin.vlad2005@yandex.ru
 *
 * @create date 2022-08-26 14:01:50
 *
 * @modify date 2022-08-26 14:01:50
 *
 * @desc [description]
 */

declare(strict_types=1);

namespace app\repositories\product;

use app\dto\product\ProductDto;
use app\entities\category\CategoryId;
use app\entities\product\Product;
use app\entities\product\ProductActive;
use app\entities\product\ProductAdminJson;
use app\entities\product\ProductDescription;
use app\entities\product\ProductId;
use app\entities\product\ProductImg;
use app\entities\product\ProductName;
use app\entities\product\ProductTitle;
use app\entities\product\ProductUrl;
use app\repositories\Hydrator;
use app\repositories\NotFoundException;

class ProductRepository
{
    /**
     * @var Hydrator
     */
    private $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * addProduct.
     */
    public function addProduct(Product $product): ProductId
    {
        \Yii::$app->db->createCommand()->insert('product', [
            'active' => $product->getActive()->getValue(),
            'category' => $product->getCategory()->getValue(),
            'img' => $product->getImg()->getValue(),
            'name' => $product->getName()->getValue(),
            'title' => $product->getTitle()->getValue(),
            'url' => $product->getUrl()->getValue(),
        ])->execute();
        $id = \Yii::$app->db->createCommand('SELECT MAX(`id`) FROM `product`')->queryScalar();

        return new ProductId((int) $id);
    }

    /**
     * changeActive.
     */
    public function changeActive(Product $product): void
    {
        \Yii::$app->db->createCommand('UPDATE `product` SET `active`=:active WHERE `id`=:id')
            ->bindValue(':id', $product->getId()->getValue())
            ->bindValue(':active', $product->getActive()->getValue() ? 1 : 0)
            ->execute();
    }


    public function changeCategoryId(Product $product): void
    {
        \Yii::$app->db->createCommand('UPDATE `product` SET `category`=:categoryId WHERE `id`=:id')
            ->bindValue(':id', $product->getId()->getValue())
            ->bindValue(':categoryId', $product->getCategory()->getValue())
            ->execute();
    }

    /**
     * changeDescription.
     */
    public function changeDescription(Product $product): void
    {
        \Yii::$app->db->createCommand('UPDATE `product` SET `description`=:description WHERE `id`=:id')
            ->bindValue(':id', $product->getId()->getValue())
            ->bindValue(':description', $product->getDescription()->getValue())
            ->execute();
    }

    /**
     * changeImg.
     */
    public function changeImg(Product $product): void
    {
        \Yii::$app->db->createCommand('UPDATE `product` SET `img`=:img WHERE `id`=:id')
            ->bindValue(':id', $product->getId()->getValue())
            ->bindValue(':img', $product->getImg()->getValue())
            ->execute();
    }

    /**
     * changeName.
     */
    public function changeName(Product $product): void
    {
        \Yii::$app->db->createCommand('UPDATE `product` SET `name`=:name WHERE `id`=:id')
            ->bindValue(':id', $product->getId()->getValue())
            ->bindValue(':name', $product->getName()->getValue())
            ->execute();
    }

    /**
     * changeUrl.
     */
    public function changeUrl(Product $product): void
    {
        \Yii::$app->db->createCommand('UPDATE `product` SET `url`=:url WHERE `id`=:id')
            ->bindValue(':id', $product->getId()->getValue())
            ->bindValue(':url', $product->getUrl()->getValue())
            ->execute();
    }

    /**
     * getActiveProductByUrl.
     *
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     */
    public function getActiveProductByUrl(ProductUrl $url): Product
    {
        $product = \Yii::$app->db->createCommand('SELECT * FROM `product` WHERE `url`=:url AND `active`=1')
            ->bindValue(':url', $url->getValue())
            ->queryOne();

        if (!$product) {
            throw new NotFoundException('Продукт не найден');
        }

        $dto = new ProductDto();
        $dto->load($product);

        return $this->hydrator->hydrate(Product::class, [
            'active' => new ProductActive($dto->active === 1),
            'category' => new CategoryId($dto->category),
            'description' => new ProductDescription($dto->description),
            'id' => new ProductId($dto->id),
            'img' => new ProductImg($dto->img),
            'name' => new ProductName($dto->name),
            'title' => new ProductTitle($dto->title),
            'url' => new ProductUrl($dto->url),
        ]);
    }

    /**
     * Получить все активные продукты.
     *
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     *
     * @return array<Product>
     */
    public function getAllByActive(): array
    {
        $products = \Yii::$app->db->createCommand(
            'SELECT * FROM `product` WHERE `active`=1 ORDER BY `product`.`id` DESC'
        )->queryAll();
        $res = [];
        foreach ($products as $product) {
            $dto = new ProductDto();
            $dto->load($product);
            $res[] = $this->hydrator->hydrate(Product::class, [
                'active' => new ProductActive($dto->active === 1),
                'category' => new CategoryId($dto->category),
                'description' => new ProductDescription($dto->description),
                'id' => new ProductId($dto->id),
                'img' => new ProductImg($dto->img),
                'name' => new ProductName($dto->name),
                'title' => new ProductTitle($dto->title),
                'url' => new ProductUrl($dto->url)
            ]);
        }

        return $res;
    }

    /**
     * Получить все-все продукты.
     *
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     *
     * @return array<ProductAdminJson>
     */
    public function getProductByAll(): array
    {
        $products = \Yii::$app->db->createCommand('SELECT * FROM `product` ORDER BY `product`.`id` DESC')->queryAll();
        $res = [];

        foreach ($products as $product) {
            $dto = new ProductDto();
            $dto->load($product);

            $res[] = $this->hydrator->hydrate(ProductAdminJson::class, [
                'active' => new ProductActive($dto->active === 1),
                'category' => new CategoryId($dto->category),
                'description' => new ProductDescription($dto->description),
                'id' => new ProductId($dto->id),
                'img' => new ProductImg($dto->img),
                'name' => new ProductName($dto->name),
                'title' => new ProductTitle($dto->title),
                'url' => new ProductUrl($dto->url),
            ]);
        }

        return $res;
    }

    /**
     * Получить список продуктов по категории.
     *
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     *
     * @return array<Product>
     */
    public function getProductByCategory(CategoryId $id): array
    {
        $res = [];
        $products = \Yii::$app->db->createCommand('SELECT * FROM `product` WHERE `category`=:id AND `active`=1')
            ->bindValue(':id', $id->getValue())
            ->queryAll();
        foreach ($products as $product) {
            $dto = new ProductDto();
            $dto->load($product);
            $res[] = $this->hydrator->hydrate(Product::class, [
                'active' => new ProductActive($dto->active === 1),
                'category' => new CategoryId($dto->category),
                'description' => new ProductDescription($dto->description),
                'id' => new ProductId($dto->id),
                'img' => new ProductImg($dto->img),
                'name' => new ProductName($dto->name),
                'title' => new ProductTitle($dto->title),
                'url' => new ProductUrl($dto->url)
            ]);
        }

        return $res;
    }

    /**
     * getProductById.
     */
    public function getProductById(ProductId $id): Product
    {
        $product = \Yii::$app->db->createCommand('SELECT * FROM `product` WHERE `id`=:id')
            ->bindValue(':id', $id->getValue())
            ->queryOne();
        if (!$product) {
            throw new NotFoundException('Продукт не найден');
        }
        $dto = new ProductDto();
        $dto->load($product);

        return $this->hydrator->hydrate(Product::class, [
            'active' => new ProductActive($dto->active === 1),
            'category' => new CategoryId($dto->category),
            'description' => new ProductDescription($dto->description),
            'id' => new ProductId($dto->id),
            'img' => new ProductImg($dto->img),
            'name' => new ProductName($dto->name),
            'title' => new ProductTitle($dto->title),
            'url' => new ProductUrl($dto->url)
        ]);
    }

    /**
     * getProductByUrl.
     *
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     */
    public function getProductByUrl(ProductUrl $url): Product
    {
        $product = \Yii::$app->db->createCommand('SELECT * FROM `product` WHERE `url`=:url')
            ->bindValue(':url', $url->getValue())
            ->queryOne();

        if (!$product) {
            throw new NotFoundException('Продукт не найден');
        }

        $dto = new ProductDto();
        $dto->load($product);

        return $this->hydrator->hydrate(Product::class, [
            'active' => new ProductActive($dto->active === 1),
            'category' => new CategoryId($dto->category),
            'description' => new ProductDescription($dto->description),
            'id' => new ProductId($dto->id),
            'img' => new ProductImg($dto->img),
            'name' => new ProductName($dto->name),
            'title' => new ProductTitle($dto->title),
            'url' => new ProductUrl($dto->url),
        ]);
    }

    /**
     * removeProduct.
     */
    public function removeProduct(ProductId $id): void
    {
        \Yii::$app->db->createCommand('DELETE FROM `product` WHERE `id`=:id')
            ->bindValue(':id', $id->getValue())
            ->execute();
    }
}
