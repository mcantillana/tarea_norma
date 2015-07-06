<?php
# @author. Norma Soto
# @versión. Junio-Julio 2015
require_once '../core/DBAbstractModel.php';
class Tipo_producto extends DBAbstractModel{
    
    # Traer datos de un tipo producto
    public function get($id='' ) {        
        if($id != '') {
            $this->query = "SELECT id_tipoProducto, 
                                    descripcion_tipo
                            FROM tipo_producto
                            WHERE id_tipoProducto = '$id'";
            $this->get_results_from_query();            
        }        
        if(count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {                                
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Tipo Producto encontrado' ;
            return true;
        } else {
            $this->mensaje = 'Tipo Producto no encontrado' ;            
            return false;
        }
        return false;
    }

    # Crear una nuevo tipo producto
    public function set($tproducto_data=array()) {
        if(array_key_exists('id' , $tproducto_data)) {
            $resultado = $this->get($tproducto_data['id']);            
            if(!$resultado) {
                foreach ($tproducto_data as $campo=>$valor) {
                    $$campo = $valor;
                }
                $this->query = "INSERT INTO tipo_producto
                                SET descripcion_tipo = '$descripcion'";
                $this->execute_single_query();
                $this->mensaje = 'Tipo Producto agregado exitosamente' ;
            } else {
                $this->mensaje = 'Tipo Producto ya existe' ;
            }
        } else {
            $this->mensaje = 'No se ha agregado el tipo producto' ;
        }
    }
    
    # Modificar un tipo de producto
    public function edit($tproducto_data=array()) {
        foreach ($tproducto_data as $campo=>$valor) {
            $$campo = $valor;
        }
        $this->query = "UPDATE tipo_producto
                        SET descripcion_tipo = '$descripcion'
                        WHERE id_tipoProducto='$id'";
        $this->execute_single_query();
        $this->mensaje = ($this->execute_single_query()?'Tipo Producto modificado': 'Tipo producto NO existe. Imposible eliminar');
    }    
 
    # Eliminar una película
     public function delete($id='' ) {
        $this->query = "DELETE FROM tipo_producto WHERE id_tipoProducto = '$id'";               
        $this->mensaje = ($this->execute_single_query()?'Tipo Producto eliminado': 'Tipo Producto NO eliminada');
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