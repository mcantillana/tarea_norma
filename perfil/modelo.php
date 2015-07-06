<?php
# @author. Norma Soto
# @versión. Junio-Julio 2015
require_once '../core/DBAbstractModel.php';

class Perfil extends DBAbstractModel{
    
    # Traer datos de un perfil
    public function get($id='' ) {        
        if($id != '') {
            $this->query = "SELECT id_perfil, descripcion_perfil
                            FROM perfil
                            WHERE id_perfil = '$id'";
            $this->get_results_from_query();            
        }        
        if(count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {                                
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Perfil Encontrado' ;
            return true;
        } else {
            $this->mensaje = 'Perfil no Encontrado' ;            
            return false;
        }
        return false;
    }

    # Crear un nuevo perfil
    public function set($perfil_data=array()) {
        if(array_key_exists('id' , $perfil_data)) {
            $resultado = $this->get($perfil_data['id']);            
            if(!$resultado) {
                foreach ($perfil_data as $campo=>$valor) {
                    $$campo = $valor;
                }

                $this->query = "INSERT INTO perfil 
                                SET id_perfil='$id', 
                                    descripcion_perfil='$nombre'";

                $this->execute_single_query();

                $this->mensaje = 'Pefil agregado exitosamente' ;
            } else {
                $this->mensaje = 'Perfil ya existe' ;
            }
        } else {
            $this->mensaje = 'No se ha agregado el perfil' ;
        }
    }
    
    # Modificar un perfil
    public function edit($perfil_data=array()) {
        foreach ($perfil_data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->query = "UPDATE perfil
                        SET id_perfil='$id', 
                            descripcion_perfil='$nombre'
                        WHERE id_perfil = '$id'";
        $this->execute_single_query();

        $this->mensaje = ($this->execute_single_query()?'Perfil modificado': 'Perfil NO existe. Imposible eliminar');
    }    
 
    # Eliminar un perfil
     public function delete($id='' ) {
        $this->query = "DELETE FROM perfil 
                        WHERE id_perfil = '$id'";               
        $this->mensaje = ($this->execute_single_query()?'Perfil eliminado': 'Perfil NO eliminado');
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