<?php
/*
 * @author hexman84 <hexman@live.ru>
 * Date: 11.01.2023
 * Time: 15:25
*/
declare(strict_types=1);

namespace app\models\guest;

use app\repositories\doc\DocRepository;
use app\repositories\Hydrator;
use app\repositories\img\ImgRepository;
use app\repositories\product\ProductCrmRepository;
use app\repositories\product\ProductOfferRepository;
use app\repositories\product\ProductRepository;
use app\services\doc\DocService;
use app\services\img\ImgService;
use app\services\product\ProductOfferServices;
use app\services\product\ProductServices;
use yii\helpers\Html;

class ProductModel
{
    public function getFullProductByUrl($controller, $url): array
    {
        $res = '';

        $offer_service = new ProductOfferServices(
            new ProductOfferRepository(new Hydrator()),
            new ProductCrmRepository(new Hydrator())
        );
        $product_service = new ProductServices(
            new ProductRepository(new Hydrator(), new ImgRepository(new Hydrator()), new DocRepository(new Hydrator()))
        );
        $item_product = $product_service->getActiveProductByUrl($url);

        $document_service = new DocService(new DocRepository(new Hydrator()));
        $document = '';

        $documentArray = $document_service->getDocByProductId($item_product->getId());

        if (\count($documentArray) === 0) {
            $document = 'В разработке';
        }
        foreach ($documentArray as $key) {
            if (strpbrk($key->getDocFile()->getValue(), '.zip')) {
                $typeImg = 'zip.png';
            } elseif (strpbrk($key->getDocFile()->getValue(), '.pdf')) {
                $typeImg = 'pdf.png';
            } else {
                $typeImg = 'img-fale.png';
            }
            $contentDoc = [
                'name' => $key->getName()->getValue(),
                'file' => $key->getDocFile()->getValue(),
                'img' => $typeImg,
            ];
            $document .= $controller->renderPartial('doc', $contentDoc);
        }

        $imgNew = '';
        $modelVopros = new VoprosModel();
        $get_render_vopros = $modelVopros->getVoprosByProductId($controller, $item_product->getId());
        if ($item_product->getImg()->getValue() !== ''
            && file_exists(\Yii::getAlias('@app/web/img/'.$item_product->getImg()->getValue()))) {
            $imgNew .= $item_product->getImg()->getValue();
        } else {
            $imgNew .= 'none.png';
        }
        $imgService = new ImgService(new ImgRepository(new Hydrator()));
        $portfolio = $imgService->getImgByProductId($item_product->getId());
        if (\count($portfolio) > 0) {
            foreach ($portfolio as $key) {
                $imgNew .= ','.$key->getUrl()->getValue();
            }
        }
        $offer_array = $offer_service->getAllOfferByProduct($item_product->getId());
        if (\count($offer_array) === 0) {
            $price = [0];
        }
        foreach ($offer_array as $offer) {
            $price[] = $offer->getPrice()->getValue();
            if (min($price) === $offer->getPrice()->getValue()) {
                $textPrise = '+0 ₽';
            } elseif ((-min($price)) < $offer->getPrice()->getValue() && 0 < $offer->getPrice()->getValue()) {
                $number = (min($price) - $offer->getPrice()->getValue()) * (-1);
                $textPrise = "+{$number} ₽";
            } else {
                $number = (min($price) - $offer->getPrice()->getValue()) * (-1);
                $textPrise = "-{$number} ₽";
            }
            $content = [
                'name' => $item_product->getName()->getValue(),
                'count' => $offer->getCount()->getValue(),
                'price' => $textPrise,
                'id' => $item_product->getId()->getValue(),
                'tovarId' => $offer->getTovarId()->getValue(),
            ];

            $res .= $controller->renderPartial('offer', $content);
        }

        $class_block_1 = '';
        $class_block_2 = '';
        $class_block_3 = '';
        $class_block_4 = '';
        $class_block_5 = '';

        if ($item_product->getBlock1()->getValue() === '') {
            $class_block_1 = '-none';
        }
        if ($item_product->getBlock2()->getValue() === '') {
            $class_block_2 = '-none';
        }
        if ($item_product->getBlock3()->getValue() === '') {
            $class_block_3 = '-none';
        }
        if ($item_product->getBlock4()->getValue() === '') {
            $class_block_4 = '-none';
        }
        if ($item_product->getBlock5()->getValue() === '') {
            $class_block_5 = '-none';
        }

        $content_offer_json = $offer_service->getAllActiveByProduct($item_product->getId()->getValue());
        $content_offer_json = str_replace('"', '&quot;', json_encode($content_offer_json));
        $bigDescription = $item_product->getDescription()->getValue();
        if (!strpos($bigDescription, 'b-description__text')) {
            '<p class="b-description__text">'.$bigDescription.'</p>';
        }
        return [
            'id' => $item_product->getId()->getValue(),
            'bigDescription' => $bigDescription,//Описание (Под продуктом)
            'block_1' => $item_product->getBlock1()->getValue(),
            'block_2' => $item_product->getBlock2()->getValue(),
            'block_3' => $item_product->getBlock3()->getValue(),
            'block_4' => $item_product->getBlock4()->getValue(),
            'block_5' => $item_product->getBlock5()->getValue(),
            'title' => $item_product->getTitle()->getValue(),
            'class_block_1' => $class_block_1,
            'class_block_2' => $class_block_2,
            'class_block_3' => $class_block_3,
            'class_block_4' => $class_block_4,
            'class_block_5' => $class_block_5,
            'count' => 'В наличии: 1 шт.',
            'htmlDescription' => $item_product->getHtmlDescription()->getValue(),
            'miniDescription' => $item_product->getKratDescription()->getValue(),//Описание под ценой
            'doc' => $document,
            'hor' => $item_product->getHor()->getValue(),
            'img' => $imgNew,
            'link_url_product' => $item_product->getUrl()->getValue(),
            'max_count' => 1,
            'name' => Html::encode($item_product->getName()->getValue()),
            'offer' => $res,
            'offer_array' => $content_offer_json,
            'price' => min($price),
            'vopros' => $get_render_vopros,
        ];
    }
}
