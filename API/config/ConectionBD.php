<?php
/*$mysql=new mysqli('181.174.224.104','root','y4kWfX/EMXW62aFH','PillPop');
if($mysql->connect_error){
    die("Error de conexión: " . $mysql->connect_error);
}else{
    echo "Conectado con éxito";
}*/

$host = '181.174.224.104';
$db_name = 'PillPop';
$username = 'root';
$password = 'y4kWfX/EMXW62aFH';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conectado con éxito";
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
