<?php
    # @author. Jazna
    # @versión. Junio 2015
    
    require_once('../core/Controles.php' );
    require_once('constant.php' );
    require_once('modelo.php' );
    require_once('view.php' );
    require_once('../core/General.php' );
    
    function handler() {
        $event = VIEW_LOGIN;
        $uri = $_SERVER['REQUEST_URI' ];
        $peticiones = array(LOGIN, VIEW_LOGIN);
        foreach ($peticiones as $peticion) {
            $uri_peticion = MODULO. $peticion.'/' ;            
            if( strpos($uri, $uri_peticion) == true ) {
                $event = $peticion;
            }
        }
        //var_dump($event);
        $usuario_data = helper_usuario_data();
        $usuario = set_obj();          
        switch ($event) {
            case LOGIN:
                //print_r($usuario_data);die();
                if (array_key_exists("login", $usuario_data)){
                    $data = array();
                    if ($usuario->chequeaLogin($usuario_data['login'], $usuario_data['password'] )){
                        session_start();        

                        $_SESSION['username'] = $usuario->nombre_usuario;
                        $_SESSION['perfil'] = $usuario->Perfil_id_perfil;                                                
                        
                        $data = array('username' =>$usuario->nombre_usuario, 'perfil' =>$usuario->Perfil_id_perfil);
                        
                        /* Acá dependiendo del tipo de perfil se deriva a una vista o a otra */                                
                        
                        // vista_login('panel', $data);    

                        global $quickbutton;
                        global $sidebar;

                        $data['menu_rapido'] = botones_rapidos($quickbutton);
                        $data['menu_lateral'] = vista_sidebar($sidebar);
                        $data['perfil'] = $usuario->getNombrePerfil($_SESSION['perfil']);

                        retornar_vista_dinamica('panel', $data);    


                    }
                    else{                        
                        $data['mensaje'] = '<div class="alert alert-danger" role="alert">Usuario o Contraseña incorrectos.</div>';
                        
                        retornar_vista(VIEW_LOGIN, $data);
                    }                    
                }
                else{
                    retornar_vista(VIEW_LOGIN);    
                }                
                break;                
            case VIEW_LOGIN:
                retornar_vista(VIEW_LOGIN);
                break;
            default:                
                cambiar_vista($event);
        }
    }
    function set_obj() {
        $obj = new Usuario();
        return $obj;
    }
    function helper_usuario_data() {
        $usuario_data = array();
        if($_POST) {
            if(array_key_exists('login' , $_POST)) {
                $usuario_data['login'] = $_POST['login' ];
            }            
            if(array_key_exists('password' , $_POST)) {
                $usuario_data['password' ] = $_POST['password' ];
            }
        } 
        return $usuario_data;
    }
    handler();
?>    