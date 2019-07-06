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
    $pstm->setFetchMode(PDO::FETCH_CLASS, Coche::class);
    $vehiculo = $pstm->fetch();
}
else if($_SERVER['REQUEST_METHOD']=='POST') {
    $id = $_POST['id'];
    $opcion = $_POST['opcion'];
    $dbcon = DataSource::getConnection();
    if(($opcion=='ok') and $dbcon) {
        try {
            $pstm = $dbcon->prepare(Coche::SQL_DELETE_COCHE);
            $pstm->bindParam(1, $id);
            $pstm->execute();
        } catch(PDOException $e) {
            Config::getLogger()->error($e->getMessage());
        }
    }
    header('Location: index.php');

} else {
    # EN CASO DE QUE EL USUARIO ACCEDIERA A ESTA PAGINA ESCRIBIENDO LA URL, LO REGRESAMOS AL INICIO
    header('Location: index.php');
}

require Config::getView('eliminar.view.php');
?>