<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\controllers\Minus42Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => $breadcrumbs['name'], 'url' => [$breadcrumbs['url']]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="minus42-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['timeout' => 10000 ]); ?>
        <div class="table-responsive col-lg-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'xlogin',
                    [
                        'label' => 'to user',
                        'format' => 'raw',
                        'attribute' => '',
                        'value'  => function ($data) use ($subPage) {
                            return Html::a(Html::img(yii\helpers\Url::to('/web/img/profile.jpg'), ['width' => '20px']),"/$subPage/" . $data['xlogin'], ['data-pjax' => '0']);
                        },
                    ],
                    'name',
                    [
                        'label' => 'to project',
                        'format' => 'raw',
                        'attribute' => '',
                        'value'  => function ($data) use ($subPage) {
                            return Html::a(Html::img(yii\helpers\Url::to('/web/img/profile.jpg'), ['width' => '20px']),"/$subPage/projects/" . $data['slug'], ['data-pjax' => '0']);
                        },
                    ],
                    'final_mark',
                    'pool_year',
                    'pool_month',
                ],
            ]); ?>
        </div>
    <?php Pjax::end(); ?>
</div>
