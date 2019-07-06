<?php
require __DIR__ . '/../vendor/autoload.php';
use Utel\Util\Config;
use Utel\Util\Inventario;
use Utel\Util\DataSource;


if(($_SERVER['REQUEST_METHOD'] == 'GET') and isset($_GET['id'])){
    $dbcon = DataSource::getConnection();
    $pstm = $dbcon->prepare(Inventario::SQL_SELECT_INVENTARIO_BY_ID);
    $pstm->bindValue(1, $_GET['id']);
    $pstm->execute();
    $resultado = $pstm->fetch(PDO::FETCH_NAMED);
    extract($resultado);
}else if($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $tcirculacion = filter_var($tcirculacion, FILTER_SANITIZE_STRING);
    $poliza_seguro = filter_var($poliza_seguro, FILTER_SANITIZE_STRING);
    $num_inventario = filter_var($num_inventario, FILTER_SANITIZE_STRING);
    $vehiculo_tipo = filter_var($vehiculo_tipo, FILTER_SANITIZE_STRING);
    $color = filter_var($color, FILTER_SANITIZE_STRING);
    $accesorios = filter_var($accesorios, FILTER_SANITIZE_STRING);
    $carroceria = filter_var($carroceria, FILTER_SANITIZE_STRING);
    $observaciones = filter_var($observaciones, FILTER_SANITIZE_STRING);
    $errores = "";
    if(Config::camposVacios($tcirculacion, $poliza_seguro, $num_inventario, $vehiculo_tipo, $color, $accesorios,  $carroceria, $observaciones)) {
        $errores .= '<li class="list-group-item text-danger">Por favor rellena todos los datos correctamente</li>';
    }else{
        $dbcon = DataSource::getConnection();
        if($dbcon) {
            try {
                $pstm = $dbcon->prepare(Inventario::SQL_UPDATE_INVENTARIO);
                $pstm->bindParam(1, $tcirculacion);
                $pstm->bindParam(2, $poliza_seguro);
                $pstm->bindParam(3, $num_inventario);
                $pstm->bindParam(4, $vehiculo_tipo);
                $pstm->bindParam(5, $color);
                $pstm->bindParam(6, $accesorios);
                $pstm->bindParam(7, $carroceria);
                $pstm->bindParam(8, $observaciones);
                // Se utiliza bindValue debido a que se inserta el resultado
                // de la función md5() y no la variable directamente
                // $pstm->bindValue(5, md5($password));
                // Se actualiza al algortimo de hash SHA-256 que es mucho más seguro
                //$pstm->bindValue(5, hash('sha256', $password));
                $pstm->bindParam(9, $id);
                $pstm->execute();
            } catch(PDOException $e) {
                Config::getLogger()->error($e->getMessage());
            }
            header('Location: inventario.php');
        }
    }

}

require Config::getView('editar.inv.view.php');

?>