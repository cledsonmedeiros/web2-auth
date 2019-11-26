<?php
// ActiveController.php

namespace app\components\controllers;

use yii\filters\auth\HttpBearerAuth;

class ActiveController extends \yii\rest\ActiveController{
  public function verbs(){
    return [
      'index' => ['GET', 'HEAD', 'OPTIONS'],
      'view' => ['GET', 'HEAD', 'OPTIONS'],
      'create' => ['POST', 'PUT', 'OPTIONS'],
      'update' => ['PUT', 'PATCH', 'OPTIONS'],
      'delete' => ['DELETE', 'OPTIONS'],
    ];
  }

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
