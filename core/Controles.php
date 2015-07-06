<?php
# @author. Jazna
# @versión. Mayo 2015
class Grid{
    # Definición de atributos
    private $_columnas = array();
    private $_headers  = array();
    private $_titulo   = "REGISTROS";
    private $_datarows = array();
    
    /*
        * @param array $datarows
        * @return DataGrid_ViewControl
    */
    public static function getInstancia($datarows = array()){
        return new self($datarows);
    }

    public function __construct($datarows = array()){
        $this->_datarows = $datarows;
        if (isset($datarows[0])) {
            foreach ($datarows[0] as $field => $value){
                $this->_columnas[] = $field;                        
            }
        }
    }     
    
    # Setea el título de la tabla
    public function setTitulo($titulo){
        $this->_titulo = $titulo;
        return $this;
    }
    
    public function binding($contenido=array()){
        $this->_datarows = $contenido;
    }

    /*
        * @param array $settings
        * @return DataGrid_ViewControl
    */
    public function setup($settings){
        foreach ($settings as $field => $setting){
            if (isset($setting['header'])) {
                $this->_headers[$field] = $setting['header'];
            }
        }
        return $this;
    }    
    
    # Retorna el objeto como una cadena de caracteres
    public function getString(){
        $salida = "<table class=\"table table-condensed\"><caption align='top'><h3>" . $this->_titulo . "</h3></caption><thead><tr>";
        # Arma el los encabezados considerando las columnas
        foreach($this->_headers as $columna => $valor){
            $salida .= "<th>" . $valor . "</th>"; 
        } 
        $salida .= "</tr></thead><tbody>";
        
        # Agrega los datos
        for($indice = 0; $indice < count($this->_datarows); $indice++){
            $fila = "<tr>";
            foreach ($this->_datarows[$indice] as $field => $value){
                $fila .= "<td>" . $value . "</td>";
            }
            $fila .= "</tr>";
            $salida .= $fila;
        }
        //var_dump($salida);
        return $salida;
    }            
}

class ControlComboBox{
    private $_valores = array();
    private $_nombre = 'combo';
    private $_selected = 0;
    
    public function __construct($valores = array(), $nombre='combo', $selected=0){
        $this->_valores = $valores;
        $this->_nombre = $nombre;
        $this->_selected = $selected;
    }  
       
    public function getString(){        
        $control = "<select name='" . $this->_nombre . "'>";
        # Agrega los elementos al control
        foreach ($this->_valores as $valor => $etiqueta) {
            $control .= "<option value='" . $valor . "'";
            $control .= ($valor == $this->_selected?"selected":"");
            $control .= ">" . $etiqueta . "</option>";                        
        }
        # Termina de armar el control
        $control .= "</select>";
        return $control;
    }
}
?>
