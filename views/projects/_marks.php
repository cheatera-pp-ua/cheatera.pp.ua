<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\helpers\ViewHelper;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\controllers\ProjectsFilterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var string $pageName */
/* @var string $case */
/* @var string $subPage */
/* @var array $months */
/* @var array $years */

$tmp = Yii::$app->session->get('username');

?>

<?php Pjax::begin(['timeout' => 10000]); ?>
<div class="projects-all-search-marks">

    <?php $form = ActiveForm::begin([
        'layout' => 'inline',
        'action' => [$action],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
        ],
        'fieldConfig' => [
            'template' => "{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'options' => [
                'class' => 'col-sm-3',
            ],
        ],
    ]); ?>

    <?= $form->field($searchModel, 'pool_month')->widget(Select2::classname(), [
        'data' => $months,
        'options' => ['placeholder' => Yii::t('app', 'Pool Month')],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>
    <?= $form->field($searchModel, 'pool_year')->widget(Select2::classname(), [
        'data' => $years,
        'options' => ['placeholder' => Yii::t('app', 'Pool Year')],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php $tmp = Yii::$app->session->get('username'); ?>

    <div class="table-responsive col-lg-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered',
            ],
            'rowOptions' => function ($data) use ($tmp) {
                if ($data['xlogin'] == $tmp) {
                    return ['class' => 'warning'];
                } elseif ($data['lastloc'] == 0) {
                    return ['class' => 'success'];
                }
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'xlogin',
                [
                    'label' => '',
                    'format' => 'raw',
                    'attribute' => '',
                    'contentOptions' => ['style' => 'position: relative'],
                    'value' => function ($data) use ($pageName) {
                        return ViewHelper::getLinkWithHover($data['xlogin'], $pageName);
                    },
                ],
                'final_mark',
                'occurrence',
                'status',
                'validated',
                'location',
                [
                    'label' => Yii::t('app', 'lastloc'),
                    'attribute' => 'lastloc',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if ($data['lastloc'] == 0) {
                            return Yii::t('app', 'ONLINE');
                        }

                        return ViewHelper::getHumanTime($data['lastloc']);
                    },
                ],
            ],
        ]); ?>
    </div>
</div>
<?php Pjax::end(); ?>

