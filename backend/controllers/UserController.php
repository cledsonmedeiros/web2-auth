<?php
//UserController.php
namespace app\controllers;

use Yii;
use app\models\User;

class UserController extends \app\components\controllers\Controller {

  public function verbs(){
    $verbs = parent::verbs();
    $verbs['login'] = ['POST', 'OPTIONS'];
    return $verbs;
    // return [
    //   'login' => ['POST', 'OPTIONS'],
    //   'create' => ['GET', 'OPTIONS'],
    // ];
  }

  public function actionLogin(){
    $login = Yii::$app->request->post('login');
    $password = Yii::$app->request->post('password');
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

  // public function actionCreate($login, $password){
  //   $user = new User();
  //   $user->login = $login;
  //   $user->password = $password;
  //   $user->name = 'teste';
  //   return [
  //     'success' => $user->save(),
  //     'errors' => $user->getErrors()
  //   ];
  // }
}
