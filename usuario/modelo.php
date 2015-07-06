<?php
# @author. Jazna
# @versión. Junio 2015
require_once  '../core/DBAbstractModel.php';

class Usuario extends DBAbstractModel{   
	# Traer datos de un usuario
    public function get($id='' ) {        
        if($id != '') {
            $this->query = "SELECT id_usuario, 
                                    Perfil_id_usuario,
                                    login_usuario,
                                    pass_usuario,
                                    nombre_usuario,
                                    apellido_usuario,
                                    correo_usuario,
                                    edad_usuario,
                                    fechaNacimiento_usuario
                            FROM usuario
                            WHERE id_usuario = '$id'";
            $this->get_results_from_query();            
        }        
        if(count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {                                
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Usuario encontrado' ;
            return true;
        } else {
            $this->mensaje = 'Usuario no encontrada' ;            
            return false;
        }
        return false;
    }

    # Crear un nuevo usuario
    public function set($usuario_data=array()) {
        if(array_key_exists('id' , $usuario_data)) {
            $resultado = $this->get($usuario_data['id']);            
            if(!$resultado) {
                foreach ($usuario_data as $campo=>$valor) {
                    $$campo = $valor;
                }
                $this->query = "INSERT INTO usuario
                                SET id_usuario='$id', 
                                    Perfil_id_usuario='$id_pf',
                                    login_usuario='$login',
                                    pass_usuario='$pass',
                                    nombre_usuario'$nombre',
                                    apellido_usuario='$apellido',
                                    correo_usuario='$correo',
                                    edad_usuario='$edad',
                                    fechaNacimiento_usuario='$nacimiento'";
                $this->execute_single_query();
                $this->mensaje = 'Usuario agregado exitosamente' ;
            } else {
                $this->mensaje = 'Usuario ya existe' ;
            }
        } else {
            $this->mensaje = 'No se ha agregado el Usuario' ;
        }
    }
    
    # Modificar un usuario
    public function edit($usuario_data=array()) {
        foreach ($usuario_data as $campo=>$valor) {
            $$campo = $valor;
        }
        $this->query = "INSERT INTO usuario
                                SET Perfil_id_usuario='$id_pf',
                                    login_usuario='$login',
                                    pass_usuario='SHA1('$password')',
                                    nombre_usuario'$nombre',
                                    apellido_usuario='$apellido',
                                    correo_usuario='$correo',
                                    edad_usuario='$edad',
                                    fechaNacimiento_usuario='$nacimiento'
                                WHERE id_usuario='$id'";
        $this->execute_single_query();
        $this->mensaje = ($this->execute_single_query()?'Usuario modificada': 'Usuario NO existe. Imposible eliminar');
    }    
 
    # Eliminar un usuario
     public function delete($id='' ) {
        $this->query = "DELETE FROM usuario WHERE id_usuario = '$id'";               
        $this->mensaje = ($this->execute_single_query()?'Usuario eliminada': 'Usuario NO eliminada');
    }
	# Método constructor
	function __construct() {
		$this->db_name = 'examenfinal' ;
	}
	# Método destructor del objeto
	function __destruct() {
		unset($this);
	}    
	
    function getNombrePerfil($perfil_id) {

        if ($perfil_id) {            
            $this->query = "SELECT descripcion_perfil FROM `perfil` WHERE id_perfil = ".$perfil_id;
            $this->get_results_from_query();
            if (count($this->rows)>0) {
                return $this->rows[0]['descripcion_perfil'] ;
            }

        }

        return false ;

    }
	# Verifica usuario 
	public function chequeaLogin($login='', $password='') {
		
		if($login != '') {
			$this->query = "SELECT *
							FROM usuario, perfil
							WHERE Perfil_id_perfil = id_perfil AND login_usuario = '$login' AND pass_usuario = SHA1('$password');" ;                                       
			$this->get_results_from_query();            
		}
		       
		if(count($this->rows) == 1) {
			foreach ($this->rows[0] as $propiedad=>$valor) {                                
				$this->$propiedad = $valor;
			}
			$this->mensaje = 'Usuario encontrado' ;
			return true;
		} else {
			$this->mensaje = 'Usuario no encontrado' ;            
			return false;
		}
		return false;        
	}          
}
?>