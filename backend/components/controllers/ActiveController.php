<?php
// ActiveController.php

namespace app\components\controllers;

class ActiveController extends Controller{
  public function verbs(){
    return [
      'index' => ['GET', 'HEAD', 'OPTIONS'],
      'view' => ['GET', 'HEAD', 'OPTIONS'],
      'create' => ['POST', 'PUT', 'OPTIONS'],
      'update' => ['PUT', 'PATCH', 'OPTIONS'],
      'delete' => ['DELETE', 'OPTIONS'],
    ];
  }

}
