<?php
# @author. Norma Soto
# @versión. Junio-Julio 2015
require_once '../core/DBAbstractModel.php';
class Detalle_oc extends DBAbstractModel{
    
    # Traer datos de un detalle
    public function get($id='' ) {        
        if($id != '') {
            $this->query = "SELECT Productos_id_producto, 
                                    Orden_compra_id_oc, 
                                    cantidad, 
                                    sub_total 
                            FROM detalle_oc
                            WHERE Productos_id_producto = '$id'";
            $this->get_results_from_query();            
        }        
        if(count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {                                
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Detalle encontrado' ;
            return true;
        } else {
            $this->mensaje = 'Detalle no encontrado' ;            
            return false;
        }
        return false;
    }

    # Crear un nuevo detalle
    public function set($detalle_data=array()) {
        if(array_key_exists('id' , $detalle_data)) {
            $resultado = $this->get($detalle_data['id']);            
            if(!$resultado) {
                foreach ($detalle_data as $campo=>$valor) {
                    $$campo = $valor;
                }
                $this->query = "INSERT INTO orden_oc
                                SET Productos_id_producto='$id_prod',
                                    Orden_compra_id_oc='$orden',
                                    cantidad='$cantidad,
                                    sub_total='$total'";

                $this->execute_single_query();  
                $this->mensaje = 'Detalle agregado exitosamente' ;
            } else {
                $this->mensaje = 'El detalle ya existe' ;
            }
        } else {
            $this->mensaje = 'No se ha agregado el detalle' ;
        }
    }
    
    # Modificar un detalle
    public function edit($detalle_data=array()) {
        foreach ($detalle_data as $campo=>$valor) {
            $$campo = $valor;
        }
        $this->query = "INSERT INTO orden_oc
                                SET Productos_id_producto='$id_prod',
                                    Orden_compra_id_oc='$orden',
                                    cantidad='$cantidad,
                                    sub_total='$total'
                                WHERE Productos_id_producto='$id_prod'";
        $this->execute_single_query();
        $this->mensaje = ($this->execute_single_query()?'Detalle modificada': 'Detalle NO existe. Imposible eliminar');
    }    
 
    # Eliminar un detalle
     public function delete($id='' ) {
        $this->query = "DELETE FROM orden_oc WHERE Productos_id_producto = '$id'";               
        $this->mensaje = ($this->execute_single_query()?'Detalle eliminado': 'Detalle NO eliminado');
    }
    # Método constructor
    function __construct() {
        $this->db_name = 'examenFinal' ;
    }
    # Método destructor del objeto
    function __destruct() {
        unset($this);
    }    
    
      
}
?>