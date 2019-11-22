<?php
//UserController.php
namespace app\controllers;

use Yii;
use app\models\User;

class UserController extends \yii\rest\Controller {
  public function actionLogin(){
    $login = Yii::$app->requet->post('login');
    $password = Yii::$app->requet->post('password');
    $user = User::findByLogin($login);
    if($user){
      if($user->validatePassword($password)){
        if($user->generateToken()){
          return $user;
        }
      }
    }
    return [
      'error' => Yii::t('app', 'Invalid credentials')
    ];
  }

  public function actionCreate($login, $password){
    $user = new User();
    $user->login = $login;
    $user->password = $password;
    $user->name = 'teste';
    return [
      'success' => $user->save(),
      'errors' => $user->getErrors()
    ];
  }
}
