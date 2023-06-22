<?php
/**
 * @author Vladislav
 *
 * @email corchagin.vlad2005@yandex.ru
 *
 * @create date 2022-11-02 09:26:38
 *
 * @modify date 2022-11-02 09:26:38
 *
 * @desc [description]
 */

declare(strict_types=1);

namespace app\controllers;

use app\dto\product\RequestPageDto;
use app\entities\product\ProductUrl;
use app\models\guest\CategoryModel;
use app\models\guest\ProductModel;
use app\repositories\NotFoundException;
use yii\web\Controller;

class ProductController extends Controller
{
    public function actionPage()
    {
        $url = \Yii::$app->request->get();
        $dto = new RequestPageDto();
        $dto->load($url);

        try {
            $category_model = new CategoryModel();
            $item_cat = $category_model->getCategoryByUrl($dto->category);
            $productUrl = new ProductUrl($dto->card);

            $productModel = new ProductModel();

            $product = $productModel->getFullProductByUrl($this, $productUrl->getValue());

            $product['link_name_category'] = $item_cat->getName()->getValue();
            $product['link_url_category'] = $item_cat->getUrl()->getValue();
            $this->layout = 'main';

            return $this->render('product', $product);
        } catch (\InvalidArgumentException|NotFoundException $exp) {
            \Yii::error($exp->getMessage());
        }

        throw new \yii\web\NotFoundHttpException();
    }
}
