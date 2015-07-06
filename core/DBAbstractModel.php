<?php
# @author. Jazna
# @versión. Mayo 2015

require_once 'GenericBL.php';
abstract class DBAbstractModel extends GenericBL{
    private static $db_host = 'localhost' ;
    private static $db_user = 'root' ;
    private static $db_pass = '' ;
    protected $db_name = 'examenfinal' ;
    protected $query;
    protected $rows = array();
    private $conexion;
    public $mensaje = 'Hecho' ;
    # métodos abstractos para que las clases que hereden los puedan implementar
    abstract protected function get();
    abstract protected function set();
    abstract protected function edit();
    abstract protected function delete();
    
    # Métodos concretos de la clase
    # Conectar a la base de datos
    private function open_connection() {
        $this->conexion = new mysqli(self:: $db_host, self:: $db_user,
        self:: $db_pass, $this->db_name);
    }
    # Desconectar la base de datos
    private function close_connection() {
        $this->conexion->close();
    }
    # Ejecutar un query simple del tipo INSERT, DELETE, UPDATE
    protected function execute_single_query() {
        $resultado = false;
        if($_POST) {
            $this->open_connection();
            $result = $this->conexion->query($this->query);
            $resultado = ($this->conexion->affected_rows>=1);
            $this->close_connection();
        } else {
            $this->mensaje = 'Metodo no permitido' ;
        }        
        return $resultado;
    }
    # Traer resultados de una consulta en un Array
    protected function get_results_from_query() {
        $this->open_connection();
        $result = $this->conexion->query($this->query);        

        while ($this->rows[] = $result->fetch_assoc());
            $result->close();
            $this->close_connection();
            array_pop($this->rows);
        }    
    }
?>