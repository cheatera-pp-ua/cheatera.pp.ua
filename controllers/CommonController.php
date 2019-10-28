<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class CommonController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param null $title
     * @param null $description
     */
    protected function setMeta($title = null, $description = null)
    {
        $this->view->title = $title;
        $this->view->registerMetaTag(['name' => 'description', 'content' => "$description"]);
    }
}
