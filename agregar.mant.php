<?php
require __DIR__ . '/../vendor/autoload.php';

use Utel\Util\Config;
use Utel\Util\DataSource;
use Utel\Util\Mantenimiento;



if($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $id_vehiculo = filter_var($id_vehiculo, FILTER_SANITIZE_STRING);
    $marca = filter_var($marca, FILTER_SANITIZE_STRING);
    $placa = filter_var($placa,FILTER_SANITIZE_STRING);
    $serie = filter_var($serie, FILTER_SANITIZE_STRING);
    $num_inventario = filter_var($num_inventario, FILTER_SANITIZE_STRING);
    $fecha = filter_var($fecha, FILTER_SANITIZE_STRING);
    $mantenimiento = filter_var($mantenimiento, FILTER_SANITIZE_STRING);
    $observaciones = filter_var($observaciones, FILTER_SANITIZE_STRING);
    $errores = "";
    if(Config::camposVacios($id_vehiculo, $marca, $placa, $serie, $num_inventario, $fecha, $mantenimiento, $accesorios, $observaciones)) {
        $errores .= '<li class="list-group-item text-danger">Por favor rellena todos los datos correctamente</li>';
    }else{
        $dbcon = DataSource::getConnection();
        if($dbcon) {
            try {
                $pstm = $dbcon->prepare(Mantenimiento::SQL_INSERT_MANTENIMIENTO);
                $pstm->bindParam(1, $id_vehiculo);
                $pstm->bindParam(2, $marca);
                $pstm->bindParam(3, $placa);
                $pstm->bindParam(4, $serie);
                $pstm->bindParam(5, $num_inventario);
                $pstm->bindParam(6, $fecha);
                $pstm->bindParam(7, $mantenimiento);
                $pstm->bindParam(8, $observaciones);
                // Se utiliza bindValue debido a que se inserta el resultado
                // de la función md5() y no la variable directamente
                // $pstm->bindValue(5, md5($password));
                // Se actualiza al algortimo de hash SHA-256 que es mucho más seguro
                //$pstm->bindValue(5, hash('sha256', $password));
                $pstm->execute();
            } catch(PDOException $e) {
                echo "Error: " . $ex->getMessage();
                //Config::getLogger()->error($e->getMessage());
            }
            header('Location: mantenimiento.php');
        }
    }

}
require Config::getView('agregar.mant.view.php');
?>
