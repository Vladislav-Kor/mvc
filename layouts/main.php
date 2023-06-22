<?php
/** @var yii\web\View $this */
use app\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags(); ?>
    <link rel="icon" href="/favicon.ico">
    <title><?php echo Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>
<div class="wrap" id="app" >
    <mainmenu>
    </mainmenu>
    <?php echo $content; ?>
   
    <noscript>
        <div class="error-msg__script">У вас отключены скрипты :((</div>
    </noscript>
</div>
<footer class="footer" role="contentinfo">
    <div class="row">
        
    </div>
</footer>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>