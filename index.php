<?php 
require __DIR__ . '/../vendor/autoload.php';
use Utel\Util\Config;
use Utel\Util\Coche;
use Utel\Util\DataSource;

$dbcon = DataSource::getConnection();
if (isset($dbcon)) {
    $sentencia = $dbcon->prepare("SELECT * FROM vehiculos");
    $sentencia->execute();
    $padron = $sentencia->fetchALL(PDO::FETCH_NAMED);
}

require Config::getView('index.view.php');

?>