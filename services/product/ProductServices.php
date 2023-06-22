<?php
/**
 * @author Vladislav
 *
 * @email corchagin.vlad2005@yandex.ru
 *
 * @create date 2022-09-07 16:00:00
 *
 * @modify date 2022-09-07 16:00:00
 *
 * @desc [description]
 */

declare(strict_types=1);

namespace app\services\product;

use app\dto\product\ProductDto;
use app\entities\category\CategoryId;
use app\entities\product\Product;
use app\entities\product\ProductActive;
use app\entities\product\ProductDescription;
use app\entities\product\ProductId;
use app\entities\product\ProductImg;
use app\entities\product\ProductName;
use app\entities\product\ProductTitle;
use app\entities\product\ProductUrl;
use app\repositories\NotFoundException;
use app\repositories\product\ProductRepository;

final class ProductServices
{
    /**
     * @var ProductRepository
     */
    private $repository;

    public function __construct(ProductRepository $repo)
    {
        $this->repository = $repo;
    }

    /**
     * addProduct.
     */
    public function addProduct(ProductDto $dto): Product
    {
        try {
            $this->getProductByUrl($dto->url);

            throw new \DomainException('Продукт с таким URL уже существует');
        } catch (NotFoundException $exp) {
            // значит все хорошо
        }

        $product = new Product(
            new ProductId(0),
            new ProductName($dto->name),
            new ProductDescription($dto->description),
            new ProductUrl($dto->url),
            new ProductImg($dto->img),
            new ProductTitle($dto->title),
            new ProductActive($dto->active === 1),
            new CategoryId($dto->category)
        );

        $product->setId($this->repository->addProduct($product));

        return $product;
    }

    /**
     * changeActive.
     *
     * @param int|ProductId        $id
     * @param ProductActive|string $active
     */
    public function changeActive($id, $active): void
    {
        $product = $this->getProductById($id);
        if ($active instanceof ProductActive) {
            $product->setActive($active);
        } else {
            $product->setActive(new ProductActive($active));
        }
        $this->repository->changeActive($product);
    }

    /**
     * changeDescription.
     *
     * @param int|ProductId             $id
     * @param ProductDescription|string $description
     */
    public function changeDescription($id, $description): void
    {
        $product = $this->getProductById($id);
        if ($description instanceof ProductDescription) {
            $product->setDescription($description);
        } else {
            $product->setDescription(new ProductDescription($description));
        }
        $this->repository->changeDescription($product);
    }

    /**
     * changeImg.
     *
     * @param int|ProductId     $id
     * @param ProductImg|string $picture
     */
    public function changeImg($id, $picture): void
    {
        $product = $this->getProductById($id);
        $file = \Yii::getAlias('@app/web/img/'.$product->getImg()->getValue());

        if ($product->getImg()->getValue() !== '' && file_exists($file)) {
            unlink($file);
        }
        if ($picture instanceof ProductImg) {
            $product->setImg($picture);
        } else {
            $product->setImg(new ProductImg($picture));
        }
        $this->repository->changeImg($product);
    }

    /**
     * changeName.
     *
     * @param int|ProductId      $id
     * @param ProductName|string $name
     */
    public function changeName($id, $name): void
    {
        $product = $this->getProductById($id);
        if ($name instanceof ProductName) {
            $product->setName($name);
        } else {
            $product->setName(new ProductName($name));
        }
        $this->repository->changeName($product);
    }


    /**
     * changeUrl.
     *
     * @param int|ProductId     $id
     * @param ProductUrl|string $url
     */
    public function changeUrl($id, $url): void
    {
        $product = $this->getProductById($id);
        if ($url instanceof ProductUrl) {
            $product->setUrl($url);
        } else {
            $product->setUrl(new ProductUrl($url));
        }
        $this->repository->changeUrl($product);
    }

    /**
     * getActiveProductByUrl.
     *
     * @param ProductUrl|string $url
     */
    public function getActiveProductByUrl($url): Product
    {
        if ($url instanceof ProductUrl) {
            return $this->repository->getActiveProductByUrl($url);
        }

        return $this->repository->getActiveProductByUrl(new ProductUrl($url));
    }

    /**
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     *
     * @return array<Product>
     */
    public function getAllByActive(): array
    {
        return $this->repository->getAllByActive();
    }

    /**
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     *
     * @return array<ProductAdminJson>
     */
    public function getProductByAll(): array
    {
        return $this->repository->getProductByAll();
    }

    /**
     * getProductById.
     *
     * @param int|ProductId $id
     */
    public function getProductById($id): Product
    {
        if ($id instanceof ProductId) {
            return $this->repository->getProductById($id);
        }

        return $this->repository->getProductById(new ProductId($id));
    }

    /**
     * getProductByUrl.
     *
     * @param ProductUrl|string $url
     */
    public function getProductByUrl($url): Product
    {
        if ($url instanceof ProductUrl) {
            return $this->repository->getProductByUrl($url);
        }

        return $this->repository->getProductByUrl(new ProductUrl($url));
    }

    /**
     * removeProduct.
     *
     * @param int|ProductId $id
     */
    public function removeProduct($id): void
    {
        $product = $this->getProductById($id);
        $product->remove();
        $this->repository->removeProduct($product->getId());
    }
}
