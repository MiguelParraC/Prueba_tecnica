<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="/favicon.ico">
    <meta name="theme-color" content="#212529">
</head>
<body class="d-flex flex-column h-100 bg-light">
    <?php $this->beginBody() ?>
    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->user->isGuest ? '<i class="bi bi-box"></i> Inventarios' : '<i class="bi bi-box"></i> INVENTARIOS',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                // Colores inspirados en la tortuga: verde oscuro y acento marrón/arena
                'class' => 'navbar navbar-expand-md navbar-dark shadow-sm fixed-top',
                'style' => 'background: linear-gradient(90deg, #355C3A 0%, #A67C52 100%);',
            ],
        ]);
        $menuItems = [];
        if (!Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '<i class="bi bi-list"></i> Productos', 'url' => ['/productspool/index'], 'encode' => false];
            $menuItems[] = ['label' => '<i class="bi bi-tags"></i> Categorías', 'url' => ['/category/index'], 'encode' => false];
            if(Yii::$app->user->identity->see_out_product == 1){
                $menuItems[] = ['label' => '<i class="bi bi-box-arrow-up"></i> Salida de Productos', 'url' => ['/productsouts/index'], 'encode' => false];
            }
            if(Yii::$app->user->identity->see_history == 1){
                $menuItems[] = ['label' => '<i class="bi bi-clock-history"></i> Historial', 'url' => ['/bitacora/index'], 'encode' => false];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
                'items' => $menuItems,
                'encodeLabels' => false,
            ]);
            echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                . Html::submitButton(
                    '<i class="bi bi-box-arrow-right"></i> Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout text-decoration-none text-light']
                )
                . Html::endForm();
        } else {
            echo Html::tag('div', Html::a('<i class="bi bi-box-arrow-in-right"></i> Login', ['/site/login'], ['class' => ['btn btn-link login text-decoration-none text-light']]), ['class' => ['d-flex']]);
        }
        NavBar::end();
        ?>
    </header>
    <main role="main" class="flex-shrink-0 pt-5 mt-4">
        <div class="container py-4">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-light shadow-sm" style="background: linear-gradient(90deg, #355C3A 0%, #A67C52 100%);">
        <div class="container d-flex justify-content-between align-items-center">
            <span>&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></span>
            
            <span><a href="mailto:parracmiguel@gmail.com" class="text-light"><i class="bi bi-envelope"></i> Soporte</a></span>
        </div>
    </footer>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
