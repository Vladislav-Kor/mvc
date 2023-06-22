<?php
/**
 * @author Vladislav
 *
 * @email corchagin.vlad2005@yandex.ru
 *
 * @create date 2022-09-06 19:17:59
 *
 * @modify date 2022-09-06 19:17:59
 *
 * @desc [description]
 */

declare(strict_types=1);

namespace app\dto\product;

class ExternalDto
{
    public $count;
    public $external;
    public $id;

    public function load(?array $data = null): void
    {
        if (\is_array($data)) {
            if (isset($data['id'])) {
                $this->id = (int) $data['id'];
            }
            if (isset($data['external'])) {
                $this->external = (int) $data['external'];
            }
            if (isset($data['count'])) {
                $this->count = (int) $data['count'];
            }
        }
    }
}
