<?php
    # @author. Norma Soto
    # @versión. Julio 2015
    
    require_once('../core/Controles.php' );
    require_once('constant.php' );
    require_once('modelo.php' );
    require_once('view.php' );
    require_once('../usuario/modelo.php' );
    require_once('../core/General.php' );
    
    
    function handler() {
        $event = GET_PERFIL_LISTAR;
        $uri = $_SERVER['REQUEST_URI' ];
        $peticiones = array(GET_PERFIL_LISTAR);
        foreach ($peticiones as $peticion) {
            $uri_peticion = MODULO. $peticion.'/' ;            
            if( strpos($uri, $uri_peticion) == true ) {
                $event = $peticion;
            }
        }
        // $movie_data = helper_movie_data();
        $perfil = set_obj();   
        $usuario = new Usuario();

        switch ($event) {
            case GET_PERFIL_LISTAR:
                session_start();   
                if(isset($_SESSION['username'])) {
                    
                    global $quickbutton;
                    global $sidebar ;

                    $data = array();

                    $data['menu_rapido'] = botones_rapidos($quickbutton);
                    $data['menu_lateral'] = vista_sidebar($sidebar);
                    $data['perfil'] = $usuario->getNombrePerfil($_SESSION['perfil']);

                    $data['listar_perfiles'] = render_table($perfil->gets());

                    retornar_vista_dinamica(VIEW_PERFIL_LISTAR,$data);

                } else {
                    header("Location: http://localhost/examenfinal/usuario/ ");
                }
                            
            break;
                                                                                      
            default:                
                retornar_vista($event);
        }
    }
    function set_obj() {
        $obj = new Perfil();
        return $obj;
    }

    // function helper_movie_data() {
    //     $movie_data = array();
    //     if($_POST) {
    //         if(array_key_exists('id' , $_POST)) {
    //             $movie_data['id'] = $_POST['id' ];
    //         }            
    //         if(array_key_exists('nombre' , $_POST)) {
    //             $movie_data['nombre' ] = $_POST['nombre' ];
    //         }
    //         if(array_key_exists('tipo' , $_POST)) {
    //             $movie_data['tipo' ] = $_POST['tipo' ];
    //         }
    //         if(array_key_exists('duracion' , $_POST)) {
    //             $movie_data['duracion' ] = $_POST['duracion' ];
    //         }
    //     } else if($_GET) {
    //         if(array_key_exists('id' , $_GET)) {
    //             $movie_data['id'] = $_GET['id'];
    //         }
    //         if(array_key_exists('tipo' , $_GET)) {
    //             $movie_data['tipo'] = $_GET['tipo'];
    //         }    
            
    //         # Considera los parámetros de búsqueda por rango de duración
    //         if(array_key_exists('minimo' , $_GET)) {
    //             $movie_data['minimo'] = $_GET['minimo'];
    //         }    
    //         if(array_key_exists('maximo' , $_GET)) {
    //             $movie_data['maximo'] = $_GET['maximo'];
    //         }            
    //     }
    //     return $movie_data;
    // }
    handler();
?>                            