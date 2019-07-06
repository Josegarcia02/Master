<?php
require __DIR__ . '/../vendor/autoload.php';
use Utel\Util\Config;
use Utel\Util\Coche;
use Utel\Util\DataSource;


if ($_SERVER['REQUEST_METHOD'] =='POST') {
    extract($_POST);
    $num_inventario = filter_var ($num_inventario, FILTER_SANITIZE_STRING);
    $serie = filter_var ($serie, FILTER_SANITIZE_STRING);
    $vehiculo = filter_var ($vehiculo, FILTER_SANITIZE_STRING);
    $marca = filter_var ($marca, FILTER_SANITIZE_STRING);
    $modelo = filter_var ($modelo, FILTER_SANITIZE_STRING);
    $placa = filter_var ($placa, FILTER_SANITIZE_STRING);
    $color = filter_var ($color, FILTER_SANITIZE_STRING);
    $asignado = filter_var ($asignado, FILTER_SANITIZE_STRING);
    $resguardo = filter_var ($resguardo, FILTER_SANITIZE_STRING);
    $observaciones = filter_var ($observaciones, FILTER_SANITIZE_STRING);
    $errores="";
    if(Config::camposVacios($num_inventario, $serie, $vehiculo, $marca, $modelo, $placa, $color, $asignado, $resguardo, $observaciones)){
        $errores .='<li class="list-group-item text-danger">Por favor rellena todos los campos</li>';
    }else{
        $dbcon = DataSource::getConnection();
        if($dbcon){
            try {
                $sentencia = $dbcon->prepare(Coche::SQL_INSERT_COCHE);
                $sentencia->bindParam(1, $num_inventario);
                $sentencia->bindParam(2,$serie);
                $sentencia->bindParam(3,$vehiculo);
                $sentencia->bindParam(4,$marca);
                $sentencia->bindParam(5,$modelo);
                $sentencia->bindParam(6,$placa);
                $sentencia->bindParam(7,$color);
                $sentencia->bindParam(8,$asignado);
                $sentencia->bindParam(9,$resguardo);
                $sentencia->bindParam(10,$observaciones);
                $sentencia->execute();   
            } catch (PDOException $e) {
                Config::getLogger()->error($e->getMessage());
            }
            header('Location: index.php');
            
        
        }
    }
}

require Config::getView('agregar.view.php');
?>