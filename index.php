<?php
require_once './bin/connection/Connection.php';
require_once './bin/persistence/Crud.php';
require_once './bin/persistence/models/GenericModel.php';
require_once './bin/persistence/models/User.php';


$user = new User();
$register = $user->where("email", "=", 'solomeo@gmail.com')->get();

var_dump($register);

/*$user->setNames("JJ");
$user->setSurnames("FLORES");
$user->setAge("25");
$user->setEmail("jjflores@gmail.com");
$user->setPhone("6666666");
$user->setRegistrationDate(date("Y-m-d H:i:s"));
$user->insert();
var_dump((new User())->get());*/


/*$userModel = new User();
$list = $userModel->get();
var_dump($list);*/


