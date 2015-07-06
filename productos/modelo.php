<?php
# @author. Norma Soto
# @versión. Junio-Julio 2015
require_once '../core/DBAbstractModel.php';
class Productos extends DBAbstractModel{
    
    # Traer datos de un producto
    public function gets() {        
        
        $this->query = "SELECT productos.id_producto, 
                               tipo_producto.descripcion_tipo AS nomnre_tipo,
                               productos.descripcion,
                               productos.precio,
                               productos.unidad
                        FROM tipo_producto
                        INNER JOIN productos
                        ON productos.tipo_producto_id_tipoProducto = tipo_producto.id_tipoProducto
                        ORDER BY productos.id_producto ASC";
        $this->get_results_from_query();            
    
        return $this->rows;
    }

    # Traer datos de un producto
    public function get($id='' ) {        
        if($id != '') {
            $this->query = "SELECT id_producto, 
                                tipo_producto_id_tipoProducto, 
                                descripcion, 
                                precio, 
                                unidad
                            FROM productos
                            WHERE id_producto = '$id'";
            $this->get_results_from_query();            
        }        
        if(count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {                                
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Producto encontrado' ;
            return true;
        } else {
            $this->mensaje = 'Producto no encontrado' ;            
            return false;
        }
        return false;
    }

    # Crear un nuevo producto
    public function set($producto_data=array()) {
        if(array_key_exists('id' , $producto_data)) {
            $resultado = $this->get($producto_data['id']);            
            if(!$resultado) {
                foreach ($producto_data as $campo=>$valor) {
                    $$campo = $valor;
                }
                $this->query = "INSERT INTO productos
                                SET id_producto='$id', 
                                    tipo_producto_id_tipoProducto='$id_tp', 
                                    descripcion='$descripcion', 
                                    precio='$precio', 
                                    unidad='$unidad'";
                $this->execute_single_query();
                
                $this->mensaje = 'Producto agregado exitosamente' ;
            } else {
                $this->mensaje = 'El producto ya existe' ;
            }
        } else {
            $this->mensaje = 'No se ha agregado el producto' ;
        }
    }
    
    # Modificar un producto
    public function edit($producto_data=array()) {
        foreach ($producto_data as $campo=>$valor) {
            $$campo = $valor;
        }
        $this->query = "INSERT INTO productos
                                SET id_producto='$id', 
                                    tipo_producto_id_tipoProducto='$id_tp', 
                                    descripcion='$descripcion', 
                                    precio='$precio', 
                                    unidad='$unidad'
                                WHERE id_producto='$id'";
        $this->execute_single_query();
        $this->mensaje = ($this->execute_single_query()?'Producto modificado': 'Producto NO existe. Imposible eliminar');
    }    
 
    # Eliminar un producto
     public function delete($id='' ) {
        $this->query = "DELETE FROM productos WHERE id_producto = '$id'";               
        $this->mensaje = ($this->execute_single_query()?'Producto eliminado': 'Producto NO eliminado');
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