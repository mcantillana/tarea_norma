<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GenericBL
 *
 * @author Jazna
 */
class GenericBL {
    private $data = array();
                  /*12*/                    
    public function __construct() {
        
    }
    
    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }        
    }
    
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
}