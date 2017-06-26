<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use kartik\datetime\DateTimePicker;
use lo\modules\noty\Wrapper;
use yii\widgets\MaskedInput;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1><?=$this->title?></h1>
    <?= Wrapper::widget([
        'layerClass' => 'lo\modules\noty\layers\Growl',
    ]);?>
</div>
<div class="page-container col-lg-6">
<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

<?= $form->field($user, 'firstName')->textInput(['autofocus' => true]) ?>

<?= $form->field($user, 'lastName') ?>

    <?=$form->field($user,'phoneNumber')
        ->widget(MaskedInput::className(),['mask'=>'+7 (999) 999-99-99'])
        ->textInput(['placeholder'=>'+7 (999) 999-99-99','class'=>'form-control'] )?>

<?= $form->field($user, 'birthday')->widget(DateTimePicker::classname(), [
        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'endDate'=> date('d.m.Y'),
            'minView' =>'month',
            'format' => 'd.m.yyyy',
            'autoclose' => true,
        ]
    ])
?>

<hr>


<?= $form->field($user, 'text')->textarea(['rows' => 3]) ?>

<hr>

<?= $form->field($user, 'verifyCode')->widget(Captcha::className(), [
    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-4">{input}</div></div>',
]) ?>

<div class="form-group ">
    <?= Html::submitButton($this->title, ['class' => 'btn btn-primary', 'name' =>
        'contact-button']) ?>
</div>

<?php ActiveForm::end(); ?>
</div>
