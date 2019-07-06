<?php
require __DIR__ . '/../vendor/autoload.php';
use Utel\Util\Config;
use Utel\Util\Coche;
use Utel\Util\DataSource;


if(($_SERVER['REQUEST_METHOD'] == 'GET') and isset($_GET['id'])){
    $dbcon = DataSource::getConnection();
    $pstm = $dbcon->prepare(Coche::SQL_SELECT_COCHE_BY_ID);
    $pstm->bindValue(1, $_GET['id']);
    $pstm->execute();
    $resultado = $pstm->fetch(PDO::FETCH_NAMED);
    extract($resultado);
}else if($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $num_inventario = filter_var($num_inventario, FILTER_SANITIZE_STRING);
    $serie = filter_var($serie, FILTER_SANITIZE_STRING);
    $vehiculo = filter_var($vehiculo, FILTER_SANITIZE_STRING);
    $marca = filter_var($marca, FILTER_SANITIZE_STRING);
    $modelo = filter_var($modelo, FILTER_SANITIZE_STRING);
    $placa = filter_var($placa, FILTER_SANITIZE_STRING);
    $color = filter_var($color, FILTER_SANITIZE_STRING);
    $asignado = filter_var($asignado, FILTER_SANITIZE_STRING);
    $resguardo = filter_var($resguardo, FILTER_SANITIZE_STRING);
    $observaciones = filter_var($observaciones, FILTER_SANITIZE_STRING);
    $errores = "";
    if(Config::camposVacios($num_inventario, $serie, $vehiculo, $marca, $modelo, $placa, $color, $asignado, $resguardo, $observaciones)) {
        $errores .= '<li class="list-group-item text-danger">Por favor rellena todos los datos correctamente</li>';
    }else{
        $dbcon = DataSource::getConnection();
        if($dbcon) {
            try {
                $pstm = $dbcon->prepare(Coche::SQL_UPDATE_COCHE);
                $pstm->bindParam(1, $num_inventario);
                $pstm->bindParam(2, $serie);
                $pstm->bindParam(3, $vehiculo);
                $pstm->bindParam(4, $marca);
                $pstm->bindParam(5, $modelo);
                $pstm->bindParam(6, $placa);
                $pstm->bindParam(7, $color);
                $pstm->bindParam(8, $asignado);
                $pstm->bindParam(9, $resguardo);
                $pstm->bindParam(10,$observaciones);
                // Se utiliza bindValue debido a que se inserta el resultado
                // de la función md5() y no la variable directamente
                // $pstm->bindValue(5, md5($password));
                // Se actualiza al algortimo de hash SHA-256 que es mucho más seguro
                //$pstm->bindValue(5, hash('sha256', $password));
                $pstm->bindParam(11, $id);
                $pstm->execute();
            } catch(PDOException $e) {
                Config::getLogger()->error($e->getMessage());
            }
            header('Location: index.php');
        }
    }

}

require Config::getView('editar.view.php');

?>