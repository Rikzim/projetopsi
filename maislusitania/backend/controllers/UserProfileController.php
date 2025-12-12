<?php

namespace backend\controllers;

class UserProfileController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
