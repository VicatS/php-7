<?php
require_once './bin/connection/Connection.php';
require_once './bin/persistence/Crud.php';

$crud = new Crud("users");
$id = $crud->insert([
    "names" => "MARCELO",
    "surnames" => "PACO ROQUE",
    "age" => "35",
    "email" => "chelito@gmail.com",
    "phone" => "72225800",
    "registration_date" => date("Y-m-d H:i:s"),
]);
echo "The ID INSERTED IS: ".$id;
$list = $crud->get();
var_dump($list);

