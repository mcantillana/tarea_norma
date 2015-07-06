<?php
# @author. Norma Soto
# @versión. Junio-Julio 2015
require_once '../core/DBAbstractModel.php';
class Orden_compra extends DBAbstractModel{
    
    # Traer datos de una orden de compra
    public function get($id='' ) {        
        if($id != '') {
            $this->query = "SELECT id_oc, 
                                    Usuario_id_usuario,
                                    total_oc,
                                    estado,
                                    fecha_emision
                            FROM orden_compra
                            WHERE id_oc = '$id'";
            $this->get_results_from_query();            
        }        
        if(count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {                                
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Orden de compra encontrado' ;
            return true;
        } else {
            $this->mensaje = 'Orden de compra no encontrado' ;            
            return false;
        }
        return false;
    }

    # Crear una nueva orden de compra
    public function set($orden_data=array()) {
        if(array_key_exists('id' , $orden_data)) {
            $resultado = $this->get($orden_data['id']);            
            if(!$resultado) {
                foreach ($orden_data as $campo=>$valor) {
                    $$campo = $valor;
                }
                $this->query = "INSERT INTO orden_compra
                                SET id_oc = '$id', 
                                    Usuario_id_usuario='$usuario',
                                    total_oc='$total',
                                    estado='estado',
                                    fecha_emision='fecha'";
                $this->execute_single_query();
                $this->mensaje = 'Orden agregada exitosamente' ;
            } else {
                $this->mensaje = 'La Orden ya existe' ;
            }
        } else {
            $this->mensaje = 'No se ha agregado la Orden' ;
        }
    }
    
    # Modificar una Orden
    public function edit($orden_data=array()) {
        foreach ($orden_data as $campo=>$valor) {
            $$campo = $valor;
        }
        $this->query = "INSERT INTO orden_compra
                                SET Usuario_id_usuario='$usuario',
                                    total_oc='$total',
                                    estado='estado',
                                    fecha_emision='fecha'
                                WHERE id_oc = '$id'";
        $this->execute_single_query();
        $this->mensaje = ($this->execute_single_query()?'Película modificada': 'Película NO existe. Imposible eliminar');
    }    
 
    # Eliminar una Orden de Compra
     public function delete($id='' ) {
        $this->query = "DELETE FROM orden_compra WHERE id_oc = '$id'";               
        $this->mensaje = ($this->execute_single_query()?'Orden eliminada': 'Orden NO eliminada');
    }
    # Método constructor
    function __construct() {
        $this->db_name = 'examenFinal' ;
    }
    # Método destructor del objeto
    function __destruct() {
        unset($this);
    }    
    
    # Métodos para retornar el nombre de todas las películas 
    public function getPeliculas(){
        $this->query = "SELECT pl_id, pl_nombre FROM pelicula ORDER BY pl_nombre";
        # Ejecuta la consulta
        $this->get_results_from_query();
        $registros = array();
        for($indice = 1; $indice <= count($this->rows); $indice++){
            $pelicula = new Pelicula;
            foreach ($this->rows[$indice-1] as $propiedad=>$valor) {
                $pelicula->$propiedad = $valor;
            }                
            $registros[$indice-1] = $pelicula;                
        }
        # Retorna el resultado
        return $registros;        
    }
    # Método paraa listar el contenido de la tabla
    public function listar($nombre=''){
        # Verifica si se trata de una búsqueda con filtro
        if (empty($nombre)){
            $this->query = "SELECT * FROM pelicula ORDER BY pl_nombre";           
        }
        else{
            $filtro = "'%" . $nombre . "%'";
            $this->query = "SELECT * FROM pelicula WHERE pl_nombre LIKE '$filtro'";
        }
        
        # Ejecuta la consulta
        $this->get_results_from_query();
        $this->mensaje = 'Películas listadas. Hay ' . count($this->rows) . ' registros' ;
        $registros = array();
        for($indice = 1; $indice <= count($this->rows); $indice++){
            $pelicula = new Pelicula;
            foreach ($this->rows[$indice-1] as $propiedad=>$valor) {              
                $pelicula->$propiedad = $valor;
            }                
            $registros[$indice-1] = $pelicula;                
        }
        # Retorna el resultado
        return $registros;
    }
    
    # Método paraa filtrar el contenido de la tabla por tipo
    public function filtrar($tipo=''){          
        $this->query = "SELECT * FROM pelicula WHERE pl_tipo = '$tipo'";       
        
        # Ejecuta la consulta
        $this->get_results_from_query();
        $this->mensaje = 'Películas por tipo. Hay ' . count($this->rows) . ' registros' ;
        $registros = array();
        for($indice = 1; $indice <= count($this->rows); $indice++){
            $pelicula = new Pelicula;
            foreach ($this->rows[$indice-1] as $propiedad=>$valor) {               
                $pelicula->$propiedad = $valor;
            }                
            $registros[$indice-1] = $pelicula;                
        }
        # Retorna el resultado
        return $registros;
    }   
    
    # Método paraa filtrar el contenido de la tabla por rango de duración
    public function filtrarRango($minimo='0', $maximo='0'){          
        $this->query = "SELECT * FROM pelicula WHERE pl_duracion >= '$minimo' AND pl_duracion <= '$maximo'";                    
        # Ejecuta la consulta
        $this->get_results_from_query();
        $this->mensaje = 'Películas por rango de duración [' . $minimo . ',' . $maximo . ']. Hay ' . count($this->rows) . ' registros' ;
        $registros = array();
        for($indice = 1; $indice <= count($this->rows); $indice++){
            $pelicula = new Pelicula;
            foreach ($this->rows[$indice-1] as $propiedad=>$valor) {              
                $pelicula->$propiedad = $valor;
            }                
            $registros[$indice-1] = $pelicula;                
        }
        # Retorna el resultado
        return $registros;
    }      
}
?>