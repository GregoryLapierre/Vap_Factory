<?php

if(isset($_GET['ID']))
{   $id=$_GET['ID'];
    $mysqlClient = new PDO('mysql:host=localhost;dbname=Vap_Factory;charset=utf8', 'admin', 'adminpwd');
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mysqlClient->query("DELETE FROM Articles WHERE ID = $id");
    
}
header('location:index.php');
?>