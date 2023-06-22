<?php

declare(strict_types=1);

namespace app\entities\product;

use app\entities\category\CategoryId;

class Product
{
    /**
     * @var ProductActive
     */
    private $active;
    /**
     * @var CategoryId
     */
    private $category;
    /**
     * @var ProductDescription
     */
    private $description;
    /**
     * @var ProductId
     */
    private $id;
    /**
     * @var ProductImg
     */
    private $img;
    /**
     * @var ProductName
     */
    private $name;
    /**
     * @var ProductTitle
     */
    private $title;
    /**
     * @var ProductUrl
     */
    private $url;

    public function __construct(
        ProductId $id,
        ProductName $name,
        ProductDescription $description,
        ProductUrl $url,
        ProductImg $img,
        ProductTitle $title,
        ProductActive $active,
        CategoryId $category

    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->url = $url;
        $this->img = $img;
        $this->title = $title;
        $this->active = $active;
        $this->category = $category;
    }

    public function getActive(): ProductActive
    {
        return $this->active;
    }

    public function getCategory(): CategoryId
    {
        return $this->category;
    }

    public function getDescription(): ProductDescription
    {
        return $this->description;
    }

    public function getId(): ProductId
    {
        return $this->id;
    }

    public function getImg(): ProductImg
    {
        return $this->img;
    }

    public function getName(): ProductName
    {
        return $this->name;
    }

    public function getTitle(): ProductTitle
    {
        return $this->title;
    }

    public function getUrl(): ProductUrl
    {
        return $this->url;
    }
    public function remove(): void
    {
    }

    public function setActive(ProductActive $active): void
    {
        $this->active = $active;
    }

    public function setCategory(CategoryId $category): void
    {
        $this->category = $category;
    }

    public function setDescription(ProductDescription $description): void
    {
        $this->description = $description;
    }
    public function setId(ProductId $id): void
    {
        $this->id = $id;
    }

    public function setImg(ProductImg $img): void
    {
        $this->img = $img;
    }

    public function setName(ProductName $name): void
    {
        $this->name = $name;
    }

    public function setTitle(ProductTitle $title): void
    {
        $this->title = $title;
    }

    public function setUrl(ProductUrl $url): void
    {
        $this->url = $url;
    }
}
