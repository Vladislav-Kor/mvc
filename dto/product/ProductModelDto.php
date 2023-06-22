<?php
/**
 * @author Vladislav
 *
 * @email corchagin.vlad2005@yandex.ru
 *
 * @create date 2022-09-21 19:23:00
 *
 * @modify date 2022-09-21 19:23:00
 *
 * @desc [description]
 */
declare(strict_types=1);

namespace app\dto\product;

class ProductModelDto
{
    public $id;
    public $type;
    public $val;

    public function load(?array $data = null): void
    {
        if ($data !== null && \is_array($data)) {
            if (isset($data['id'])) {
                $this->id = (int) $data['id'];
            }
            if (isset($data['type'])) {
                $this->type = $data['type'];
            }
            if (isset($data['val'])) {
                $this->val = $data['val'];
            }
        }
    }
}
