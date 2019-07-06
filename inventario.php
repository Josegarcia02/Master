<?php session_start();
require __DIR__ . '/../vendor/autoload.php';

use Utel\Util\Config;
use Utel\Util\DataSource;
use Utel\Util\Inventario;




$dbcon = DataSource::getConnection();
if(isset($dbcon)) {
    $sentencia = $dbcon->prepare("SELECT * FROM inventario");
    $sentencia->execute();
    $inventario = $sentencia->fetchAll(PDO::FETCH_NAMED);
}

require Config::getView('inventario.view.php');
?>

