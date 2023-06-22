<?php
/*
 * @author hexman84 <hexman@live.ru>
 * Date: 13.12.2022
 * Time: 10:20
*/
declare(strict_types=1);

namespace app\models\adm;

use app\dto\product\ProductDto;
use app\dto\product\ProductModelDto;
use app\repositories\doc\DocRepository;
use app\repositories\Hydrator;
use app\repositories\img\ImgRepository;
use app\repositories\NotFoundException;
use app\repositories\product\ProductRepository;
use app\services\product\ProductServices;

class ProductModel
{
    /**
     * @param array             $post
     * @param \yii\web\Response $response
     */
    public function addProduct($post, $response): array
    {
        $service = new ProductServices(
            new ProductRepository(new Hydrator(), new ImgRepository(new Hydrator()), new DocRepository(new Hydrator()))
        );
        $dto = new ProductDto();
        $dto->load($post);

        try {
            try {
                $service->getProductByUrl($dto->url);
                return ['error' => 'Не могу создать продукт с оноименным url'];
            } catch (\NotFoundException $th) {
                $product= $service->addProduct($dto);
                return ['ok' => $product->getId()->getValue()];
            }
        } catch (\DomainException $exp) {
            $response->statusCode = 400;

            return ['error' => $exp->getMessage()];
        }
    }

    /**
     * @param array $post
     */
    public function deleteProduct($post): array
    {
        $dto = new ProductModelDto();
        $dto->load($post);
        $service = new ProductServices(
            new ProductRepository(new Hydrator(), new ImgRepository(new Hydrator()), new DocRepository(new Hydrator()))
        );

        try {
            $service->removeProduct($dto->id);

            return ['ok' => 1];
        } catch (NotFoundException $exp) {
            return ['error' => $exp->getMessage()];
        }
    }

    /**
     * @param \yii\web\Response $response
     *
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     */
    public function getAllProduct($response): array
    {
        $service = new ProductServices(
            new ProductRepository(new Hydrator(), new ImgRepository(new Hydrator()), new DocRepository(new Hydrator()))
        );

        try {
            return $service->getProductByAll();
        } catch (NotFoundException $exp) {
            $response->statusCode = 400;

            return ['error' => $exp->getMessage()];
        }
    }

    /**
     * @param array             $post
     * @param \yii\web\Response $response
     *
     * @throws \yii\base\Exception
     *
     * @return array|int[]|string[]
     */
    public function updateProduct($post, $response): array
    {
        $dto = new ProductModelDto();
        $dto->load($post);
        $service = new ProductServices(
            new ProductRepository(new Hydrator(), new ImgRepository(new Hydrator()), new DocRepository(new Hydrator()))
        );

        try {
            switch ($dto->type) {
                case 'active':
                    $service->changeActive($dto->id, (int) $dto->val === 1);
                    $res = ['ok' => 1];

                    break;
                
                case 'description':
                    $service->changeDescription($dto->id, $dto->val);
                    $res = ['ok' => 1];

                    break;
                case 'category':
                    $service->changeCategoryId($dto->id, (int) $dto->val);
                    $res = ['ok' => 1];

                    break;
                case 'img':
                    $model = new PictureModel();
                    $name = $model->saveImage($dto->val);
                    $service->changeImg($dto->id, $name);
                    $res = ['ok' => $name];

                    break;
                case 'name':
                    $service->changeName($dto->id, $dto->val);
                    $res = ['ok' => 1];

                    break;
                case 'title':
                    $service->changeTitle($dto->id, $dto->val);
                    $res = ['ok' => 1];

                    break;
                case 'url':
                    try {
                        $service->getProductByUrl($dto->val);
                        $res = ['ok' => 'такой url уже существует'];
                    } catch (\NotFoundException $th) {
                        $service->changeUrl($dto->id, $dto->val);
                        $res = ['ok' => 1];
                    }
                    break;
                default:
                    $res = ['error' => 'Неправильный запрос к cайту! Ошибку надо исправлять в продуктах'];
                    \Yii::$app->response->statusCode = 400;
            }

            return $res;
        } catch (\InvalidArgumentException $exp) {
            $response->statusCode = 400;

            return ['error' => $exp->getMessage(), 'type' => $dto->type];
        }
    }
}
