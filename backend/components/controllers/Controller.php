<?php
// Controller.php

namespace app\components\controllers;

class Controller extends \yii\rest\Controller{

  public function behaviors() {
    $behaviors = parent::behaviors();
    $behaviors['corsFilter'] = [
      'class' => \yii\filters\Cors::className()
    ];
    return $behaviors;
  }
  
}
