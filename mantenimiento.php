<?php session_start();
require __DIR__ . '/../vendor/autoload.php';

use Utel\Util\Config;
use Utel\Util\DataSource;
use Utel\Util\Mantenimiento;




$dbcon = DataSource::getConnection();
if(isset($dbcon)) {
    $sentencia = $dbcon->prepare("SELECT * FROM mantenimiento");
    $sentencia->execute();
    $mantenimiento = $sentencia->fetchAll(PDO::FETCH_NAMED);
}

require Config::getView('mantenimiento.view.php');
?>

