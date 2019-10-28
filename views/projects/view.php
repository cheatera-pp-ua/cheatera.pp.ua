<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\helpers\ViewHelper;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var array $breadcrumbs */
/* @var $searchModel app\controllers\ProjectsAllSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var string $pageName */
/* @var array $months */
/* @var array $years */
/* @var int $team */

$this->params['breadcrumbs'][] =
    ['label' => Yii::t('app', ucfirst($breadcrumbs['0']['name'])), 'url' => [$breadcrumbs['0']['url']]];
$this->params['breadcrumbs'][] =
    ['label' => Yii::t('app', ucfirst($breadcrumbs['1']['name'])), 'url' => [$breadcrumbs['1']['url']]];
if ($team > 0) {
    if (isset($breadcrumbs['2'])) {
        $this->params['breadcrumbs'][] =
            ['label' => Yii::t('app', ucfirst($breadcrumbs['2']['name'])), 'url' => [$breadcrumbs['2']['url']]];
    }
    $this->params['breadcrumbs'][] =
        ['label' => ucfirst(strtok($this->title, '::')), 'url' => '/' . Yii::$app->language . '/' . $action];
    $this->params['breadcrumbs'][] = Yii::t('app', 'Team') . ' ' . $team;
} else {
    $this->params['breadcrumbs'][] = ucfirst(strtok($this->title, '::'));
}


?>
<div class="projects-view">
    <h1><?php if (isset($breadcrumbs['2']['name'])) {
            echo $breadcrumbs['2']['name'];
        } ?> <?= Html::encode(ucfirst(strtok($this->title, '::'))) ?></h1>

    <?php Pjax::begin(['timeout' => 10000]); ?>
    <div class="projects-all-search">
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
    </div>

    <?php $tmp = Yii::$app->session->get('username') ?>

    <div class="table-responsive col-lg-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered table-responsive',
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
                [
                    'label' => Yii::t('app', 'Team'),
                    'attribute' => 'current_team_id',
                    'format' => 'raw',
                    'value' => function ($data) use ($action) {
                        return Html::a($data['current_team_id'], [$action
                                                                  . '/team/'
                                                                  . $data['current_team_id']], ['data-pjax' => 0]);
                    },
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end();
    $this->registerJs("
    $('table tr[data-href]').click(function () {
        if ($(this).data('href') !== undefined) {
            window.location.href = $(this).data('href');
        }
    });"); ?>
</div>
