<?php
/*
 * @author hexman84 <hexman@live.ru>
 * Date: 11.01.2023
 * Time: 15:28
*/
declare(strict_types=1);

namespace app\dto\product;

class RequestPageDto
{
    public $card;
    public $category;

    public function load(?array $data = null): void
    {
        if ($data !== null && \is_array($data)) {
            if (isset($data['category'])) {
                $this->category = $data['category'];
            }
            if (isset($data['card'])) {
                $this->card = $data['card'];
            }
        }
    }
}
