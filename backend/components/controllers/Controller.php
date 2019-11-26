<?php
// Controller.php

namespace app\components\controllers;

use yii\filters\auth\HttpBearerAuth;

class Controller extends \yii\rest\Controller{

  public function behaviors() {
    $behaviors = parent::behaviors();
    $behaviors['corsFilter'] = [
      'class' => \yii\filters\Cors::className()
    ];
    $behaviors['authenticator'] = [
      'class' => HttpBearerAuth::className(),
    ];
    return $behaviors;
  }
  
}
