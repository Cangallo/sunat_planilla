<?php

class DiaSubsidiadoDao extends AbstractDao {

//put your code here

    public function registrar($obj) {
        $model = new DiaSubsidiado();
        $model = $obj;
        $query = "
        INSERT INTO dias_subsidiados
                    (
                     id_trabajador_pdeclaracion,
                     cantidad_dia,
                     cod_tipo_suspen_relacion_laboral)
        VALUES (
                ?,
                ?,
                ?);            
        ";

        $stm = $this->pdo->prepare($query);
        $stm->bindValue(1, $model->getId_trabajador_pdeclaracion());
        $stm->bindValue(2, $model->getCantidad_dia());
        $stm->bindValue(3, $model->getCod_tipo_suspen_relacion_laboral());

        $stm->execute();
        //$lista = $stm->fetchAll();
        $stm = null;
        return true;
    }

    public function actualizar($obj) {

        $model = new DiaSubsidiado();
        $model = $obj;
        $query = "
        UPDATE dias_subsidiados
        SET         
          cantidad_dia = ?,
          cod_tipo_suspen_relacion_laboral = ?
        WHERE id_dia_subsidiado = ?;           
        ";

        $stm = $this->pdo->prepare($query);
        $stm->bindValue(1, $model->getCantidad_dia());
        $stm->bindValue(2, $model->getCod_tipo_suspen_relacion_laboral());
        $stm->bindValue(3, $model->getId_dia_subsidiado());

        $stm->execute();
        //$lista = $stm->fetchAll();
        $stm = null;
        return true;
    }

    public function eliminar($id) {

        $query = "
        DELETE
        FROM dias_subsidiados
        WHERE id_dia_subsidiado = ?;       
        ";

        $stm = $this->pdo->prepare($query);
        $stm->bindValue(1, $id);

        $stm->execute();
        //$lista = $stm->fetchAll();
        $stm = null;
        return true;
    }

    public function buscar_IdTrabajadorPdeclaracion($id, $SUM=null) {

        $query1 = "
        SELECT
          id_dia_subsidiado,
          id_trabajador_pdeclaracion,
          cantidad_dia,
          cod_tipo_suspen_relacion_laboral
        FROM dias_subsidiados
        WHERE id_trabajador_pdeclaracion = ?         
        ";
        $query2 = "
        SELECT        
        SUM(cantidad_dia) AS cantidad_dia
        FROM dias_subsidiados
        WHERE id_trabajador_pdeclaracion = ?          
        ";
        if ($SUM == "SUMA") {
            $query = $query2;
        } else {
            $query = $query1;
        }


        $stm = $this->pdo->prepare($query);
        $stm->bindValue(1, $id);
        $stm->execute();
        $lista = $stm->fetchAll();
        $stm = null;
        
        if ($SUM == "SUMA") {
            return $lista[0]['cantidad_dia'];
        } else {
            return $lista;
        }
        
    }

}

?>
