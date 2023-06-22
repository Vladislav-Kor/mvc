<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\adm\ImgModel;
use app\models\adm\OfferModel;
use app\models\adm\ProductModel;
use yii\web\Controller;
use yii\web\Response;

class AuditController extends Controller
{
    public function actionIndex()
    {
        if (!$this->isAdmin()) {
            return $this->redirect(\yii\helpers\Url::to('/audit/login', 'https'));
        }

        $this->layout = 'audit';

        return $this->render('index', ['content' => '']);
    }

    public function actionLogin()
    {
        if ($this->isAdmin()) {
            return $this->redirect(\yii\helpers\Url::to('/audit', 'https'));
        }
        if (\Yii::$app->request->isPost && \Yii::$app->request->isAjax) {
            $model = new \app\models\adm\LoginModel();
            $post = \Yii::$app->request->post();
            if ($model->login($post)) {
                $res = ['ok' => 1];
            } else {
                $res = ['error' => $post];
                \Yii::$app->response->statusCode = 200;
            }
            $response = \Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = $res;

            return $response;
        }

        $this->layout = 'login';

        return $this->render('login');
    }

    public function actionLoginoff()
    {
        $this->layout = 'login';
        \Yii::$app->user->logout();

        return $this->redirect(\yii\helpers\Url::to('/audit/login', 'https'));
    }

    public function actionOffer()
    {
        if (!$this->isAdmin()) {
            throw new \yii\web\NotFoundHttpException();
        }
        if (null !== \Yii::$app->request->get('action', null)
        && \Yii::$app->request->isPost) {
            $action = \Yii::$app->request->get('action');
            $post = \Yii::$app->request->post();
            $model = new OfferModel();

            switch ($action) {
                case 'get':
                    $res = $model->getAllOffers($post, \Yii::$app->response);

                    break;
                case 'get-all':
                    $res = $model->getAll($post, \Yii::$app->response);

                    break;
                case 'add':
                    $res = $model->addOffer($post, \Yii::$app->response);

                    break;
                case 'delete':
                    $res = $model->deleteOffer($post, \Yii::$app->response);

                    break;
                case 'update':
                    $res = $model->updateOffer($post, \Yii::$app->response);

                    break;
                default:
                    $res = ['error' => 'Неправильный запрос к cайту! Ошибку надо исправлять в продуктах'];
                    \Yii::$app->response->statusCode = 400;
            }
            $response = \Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $response->data = $res;

            return $response;
        }

        throw new \yii\web\NotFoundHttpException();
    }

    public function actionProduct()
    {
        if (!$this->isAdmin()) {
            throw new \yii\web\NotFoundHttpException();
        }
        if (null !== \Yii::$app->request->get('action', null)
        && \Yii::$app->request->isPost) {
            $action = \Yii::$app->request->get('action');
            $post = \Yii::$app->request->post();
            $productModel = new ProductModel();

            switch ($action) {
                case 'get':
                    $res = $productModel->getAllProduct($post, \Yii::$app->response);

                    break;
                case 'add':
                    $res = $productModel->addProduct($post, \Yii::$app->response);

                    break;
                case 'delete':
                    $res = $productModel->deleteProduct($post);

                    break;
                case 'update':
                    $res = $productModel->updateProduct($post, \Yii::$app->response);

                    break;
                case 'delete-img':
                    $img = new ImgModel();
                    $res = $img->deleteImg($post, \Yii::$app->response);

                    break;
                default:
                    $res = ['error' => 'Не запрос к cайту! Ошибку надо исправлять в продуктах'];
                    \Yii::$app->response->statusCode = 400;
            }
            $response = \Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $response->data = $res;

            return $response;
        }

        throw new \yii\web\NotFoundHttpException();
    }

}
