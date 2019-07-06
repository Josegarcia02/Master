<?php
require __DIR__ . '/../vendor/autoload.php';
use Utel\Util\Config;
use Utel\Util\Mantenimiento;
use Utel\Util\DataSource;


if(($_SERVER['REQUEST_METHOD'] == 'GET') and isset($_GET['id'])){
    $dbcon = DataSource::getConnection();
    $pstm = $dbcon->prepare(Mantenimiento::SQL_SELECT_MANTENIMIENTO_BY_ID);
    $pstm->bindValue(1, $_GET['id']);
    $pstm->execute();
    $pstm->setFetchMode(PDO::FETCH_CLASS, Mantenimiento::class);
    $mantenimiento = $pstm->fetch();
}
else if($_SERVER['REQUEST_METHOD']=='POST') {
    $id = $_POST['id'];
    $opcion = $_POST['opcion'];
    $dbcon = DataSource::getConnection();
    if(($opcion=='ok') and $dbcon) {
        try {
            $pstm = $dbcon->prepare(Mantenimiento::SQL_DELETE_MANTENIMIENTO);
            $pstm->bindParam(1, $id);
            $pstm->execute();
        } catch(PDOException $e) {
            Config::getLogger()->error($e->getMessage());
        }
    }
    header('Location: mantenimiento.php');

} else {
    # EN CASO DE QUE EL USUARIO ACCEDIERA A ESTA PAGINA ESCRIBIENDO LA URL, LO REGRESAMOS AL INICIO
    header('Location: mantenimiento.php');
}

require Config::getView('eliminar.mant.view.php');
?>