<?php

use yii\grid\GridView;
use lo\modules\noty\Wrapper;
use yii\helpers\Url;
$this->title = 'My Yii Application';
?>
<?= Wrapper::widget([
    'layerClass' => 'lo\modules\noty\layers\Growl',
]);?>
<div class="page-header ">
        <h1>Список Пользователей
        <a class="btn btn-primary pull-right" href="<?=Url::toRoute('/site/form')?>">Добавить пользователя</a>
        </h1>
</div>

<div class="page-container row">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'firstName',
        'lastName',
        'phoneNumber',
        'birthday',
        'text',
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}'],
        ]
        ]);?>
    </div>


