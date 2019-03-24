<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */
/* @var $searchModel app\controllers\CorrectionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Correction Logs');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class='correction-log-index'>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['timeout' => 10000 ]); ?>
        <?= $this->render('_search', ['model' => $searchModel]); ?>
        <?php
        $labels = [];
        $data = [];
        foreach ($dataProvider->models as $model) {
            $labels = array_merge([$model->date], $labels);
            $data = array_merge([$model->count], $data);
        }
    ?>
        <div class="table-responsive">
            <div class="ChartJs">
                <?= ChartJs::widget([
                    'type' => 'line',
                    'data' => [
                        'labels' => $labels,
                        'datasets' => [
                            [
                                'label' => Yii::t('app', 'Correction Logs'),
                                'backgroundColor' => 'rgba(255,99,132,0.2)',
                                'borderColor' => 'rgba(255,99,132,1)',
                                'pointBackgroundColor' => 'rgba(255,99,132,1)',
                                'pointBorderColor' => '#fff',
                                'pointHoverBackgroundColor' => '#fff',
                                'pointHoverBorderColor' => 'rgba(255,99,132,1)',
                                'data' => $data
                            ]
                        ]
                    ],
                    'options' => [
                        'responsive' => true,
                        'maintainAspectRatio' => false,
                        'tooltips' => [
                            'mode' => 'index',
                            'intersect' => false,
                        ],
                        'hover' => [
                            'mode' => 'nearest',
                            'intersect' => true
                        ],
                        // !app\helpers\ThemesHelper::isDark()
                        // ?: 'legend' => [
                        //     'labels' => [
                        //         'fontColor' => '#fff',
                        //         'fontSize' => 18,
                        //     ],
                        // ],
                    ],
                ]);?>
            </div>
        </div>
    <?php Pjax::end(); ?>

    <?php
        // echo '<pre>';
        //     var_export(  );
        // echo '</pre>';
    ?>

</div>
