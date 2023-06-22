<?php
/**
 * @author Vladislav
 *
 * @email corchagin.vlad2005@yandex.ru
 *
 * @create date 2022-09-06 18:44:12
 *
 * @modify date 2022-09-06 18:44:12
 *
 * @desc [description]
 */

declare(strict_types=1);

namespace app\dto\product;

class ProductDto
{
    /**
     * @var int
     */
    public $active;
    /**
     * @var string
     */
    public $block_1;
    /**
     * @var string
     */
    public $block_2;
    /**
     * @var string
     */
    public $block_3;
    /**
     * @var string
     */
    public $block_4;
    /**
     * @var string
     */
    public $block_5;
    /**
     * @var int
     */
    public $category;
    /**
     * @var string
     */
    public $description;
    /**
     * @var int
     */
    public $height_box;
    /**
     * @var int
     */
    public $hor;
    /**
     * @var string|null
     */
    public $html_description;
    /**
     * @var int|null
     */
    public $id;
    /**
     * @var string|null
     */
    public $img;
    /**
     * @var string|null
     */
    public $krat_description;
    /**
     * @var int|null
     */
    public $length_box;
    /**
     * @var string|null
     */
    public $name;
    /**
     * @var string|null
     */
    public $small_description;
    /**
     * @var string|null
     */
    public $title;
    /**
     * @var string|null
     */
    public $url;
    /**
     * @var int|null
     */
    public $Weight_box;
    /**
     * @var int|null
     */
    public $width_box;

    public function load(?array $data = null): void
    {
        if (\is_array($data)) {
            if (isset($data['id'])) {
                $this->id = (int) $data['id'];
            }
            if (isset($data['Weight_box'])) {
                $this->Weight_box = (float) $data['Weight_box'];
            }
            if (isset($data['active'])) {
                $this->active = (int) $data['active'];
            }
            if (isset($data['block_1'])) {
                $this->block_1 = $data['block_1'];
            }
            if (isset($data['block_2'])) {
                $this->block_2 = $data['block_2'];
            }
            if (isset($data['block_3'])) {
                $this->block_3 = $data['block_3'];
            }
            if (isset($data['block_4'])) {
                $this->block_4 = $data['block_4'];
            }
            if (isset($data['block_5'])) {
                $this->block_5 = $data['block_5'];
            }
            if (isset($data['description'])) {
                $this->description = $data['description'];
            }
            if (isset($data['height_box'])) {
                $this->height_box = (int) $data['height_box'];
            }
            if (isset($data['html_description'])) {
                $this->html_description = $data['html_description'];
            }
            if (isset($data['krat_description'])) {
                $this->krat_description = $data['krat_description'];
            }
            if (isset($data['length_box'])) {
                $this->length_box = (int) $data['length_box'];
            }
            if (isset($data['name'])) {
                $this->name = $data['name'];
            }
            if (isset($data['small_description'])) {
                $this->small_description = $data['small_description'];
            }
            if (isset($data['title'])) {
                $this->title = $data['title'];
            }
            if (isset($data['url'])) {
                $this->url = $data['url'];
            }
            if (isset($data['width_box'])) {
                $this->width_box = (int) $data['width_box'];
            }
            if (isset($data['img'])) {
                $this->img = $data['img'];
            }
            if (isset($data['hor'])) {
                $this->hor = $data['hor'];
            }
            if (isset($data['category'])) {
                $this->category = (int) $data['category'];
            }
        }
    }
}
