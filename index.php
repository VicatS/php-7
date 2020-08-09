<?php
require_once './bin/connection/Connection.php';
require_once './bin/persistence/Crud.php';

$crud = new Crud("users");
//$id = $crud->insert([
//    "names" => "CRISTINA",
//    "surnames" => "PACO ROQUE",
//    "age" => "34",
//    "email" => "cristy@gmail.com",
//    "phone" => "57-5651656465250",
//    "registration_date" => date("Y-m-d H:i:s"),
//]);
//echo "The ID INSERTED IS: ".$id;
echo "<br>";
$rowsAffected = $crud->where("id", "=", 9)->update([
    "names" => "AURONPLAY",
    "surnames" => "ROJAS FLORES",
    "age" => "33",
    "email" => "elauron@gmail.com",
    "phone" => "34-1651544090"
]);

$rowsDeleted = $crud->where("id", "=",3)->delete();

echo "Rows Affected: " . $rowsAffected;
echo "<br>";
echo "DELETED: " . $rowsDeleted;
echo "<br>";

$list = $crud->get();
var_dump($list);



