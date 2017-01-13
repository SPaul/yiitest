<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PicturesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pictures';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pictures-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data', 'method' => 'post']
        ]) ?>
        <?= $form->field($model, 'imageFile')->fileInput() ?>
        <button>Submit</button>
    <?php ActiveForm::end() ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'format' => 'raw',
                'label' => 'image',
                'value' => function($data){
                    return HTML::img('uploads/'.$data->name, ['style' => 'width: 200px']);
                },
            ],

            [
                'format' => 'raw',
                'label' => 'actions',
                'value' => function($data){
                    $a = HTML::a('<span class="glyphicon glyphicon-refresh"></span> ', ['pictures/rotate', 'id'=>$data->id], ['format' => 'raw', 'title' => 'Rotate']);
                    $a .= HTML::a('<span class="glyphicon glyphicon-trash"></span> ', ['pictures/delete', 'id'=>$data->id], ['format' => 'raw', 'title' => 'Delete']);
                    return $a;
                },
            ],
        ],
    ]); ?>
</div>
