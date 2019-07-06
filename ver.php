<?php 
require __DIR__ . '/../vendor/autoload.php';
use Utel\Util\Config;
use Utel\Util\DataSource;

$dbcon = DataSource::getConnection();
if (isset($dbcon)) {
    $sentencia = $dbcon->prepare("SELECT tcirculacion,poliza_seguro,num_inventariovehiculo_tipo,coloraccesorios,carroceria,observaciones,fecha,mantenimiento
     FROM padron INNER JOIN mantenimiento");
    $sentencia->execute();
    $padron = $sentencia->fetchALL(PDO::FETCH_ASSOC);
}

require Config::getView('ver.view.php');

?>