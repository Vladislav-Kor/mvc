<?php
/**
 * @author Vladislav
 * @email corchagin.vlad2005@yandex.ru
 * @create date 2022-11-02 09:47:54
 * @modify date 2022-11-02 09:47:54
 * @desc [description]
 */
$this->params['breadcrumbs'][] = [
    'template' => "<li typeof=\"v:Breadcrumb\">{link} </li>\n",
    'label' => 'Главная',
    'url' => ['/'],
    'rel' => 'v:url',
    'property' => 'v:title',
];
$this->params['breadcrumbs'][] = [
    'template' => "<li typeof=\"v:Breadcrumb\">{link} </li>\n",
    'label' => 'Каталог',
    'url' => ['/catalog'],
    'rel' => 'v:url',
    'property' => 'v:title',
];
$this->params['breadcrumbs'][] = [
    'template' => "<li typeof=\"v:Breadcrumb\">{link} </li>\n",
    'label' => $link_name_category,
    'url' => ["catalog/{$link_url_category}"],
    'rel' => 'v:url',
    'property' => 'v:title',
];
$this->params['breadcrumbs'][] = ['template' => "<li>{link}</li>\n", //  шаблон для этой ссылки
    'label' =>$name
];
$this->title= $title;
// $items = str_replace('"', "&quot;", $offer_array);
$this->registerMetaTag(['description'=>$htmlDescription]);
use yii\widgets\Breadcrumbs;
?>
<div class="container">
    <div class="row">
        <div class="b-breadcrumbs">
            <?php echo Breadcrumbs::widget(['homeLink' => false, 'links' => $this->params['breadcrumbs'] ?? [], 'options' => ['xmlns:v' => 'http://rdf.data-vocabulary.org/#', 'class' => 'b-breadcrumbs__items']]); ?>
        </div>
    </div>
</div>
<div class="b-product">
    <div class="row">
        <h1 class="b-product__name"><?php echo $name; ?></h1>
        <div class="b-product__text">
            <div class="b-offer">
                <?php echo $offer; ?>
                <div class="b-product_container-koll">
                    <div class="b-product__number-box">
                        <button class="b-product__number-minus">-</button>
                        <input type="number" disabled="disabled" name="amount" min="0" max="1" value="1" class="b-product__number">
                        <button class="b-product__number-minus-plus">+</button>
                    </div>
                    <p class="b-product__order">купить</p>
                    <p class="b-product__count"><?php echo $count ?></p>
                </div>
            </div>
        </div>
    </div>
</div>