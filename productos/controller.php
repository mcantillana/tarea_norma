<?php
    # @author. Jazna
    # @versión. Mayo 2015
    
    require_once('../core/Controles.php' );
    require_once('constant.php' );
    require_once('modelo.php' );
    require_once('view.php' );
    
    function handler() {
        $event = VIEW_GET_MOVIE;
        $uri = $_SERVER['REQUEST_URI' ];
        $peticiones = array(SET_MOVIE,  GET_MOVIE,  DELETE_MOVIE,  EDIT_MOVIE,
                            VIEW_SET_MOVIE,  VIEW_GET_MOVIE,  VIEW_DELETE_MOVIE,
                            VIEW_EDIT_MOVIE, VIEW_MOVIE, VIEW_MOVIES, 
                            VIEW_FIND_MOVIES, FIND_MOVIE, VIEW_FIND_RANGE, FIND_MOVIE_RANGE,
                            VIEW_COMBOBOX, VIEW_COMBO, VIEW_SELECTED);
        foreach ($peticiones as $peticion) {
            $uri_peticion = MODULO. $peticion.'/' ;            
            if( strpos($uri, $uri_peticion) == true ) {
                $event = $peticion;
            }
        }
        $movie_data = helper_movie_data();
        $movie = set_obj();   
        echo $event;       
        switch ($event) {
            case SET_MOVIE:
                $movie->set($movie_data);
                $data = array('mensaje' =>$movie->mensaje);
                retornar_vista(VIEW_SET_MOVIE, $data);
                break;
            case GET_MOVIE:
                if ($movie->get($movie_data['id'])){
                    $data = array(
                        'nombre' =>$movie->pl_nombre,
                        'tipo' =>$movie->pl_tipo,
                        'id' =>$movie->pl_id,
                        'duracion' =>$movie->pl_duracion
                    );
                    retornar_vista(VIEW_EDIT_MOVIE, $data);                    
                }
                else{
                    $data = array('mensaje' =>$movie->mensaje);                    
                    retornar_vista(VIEW_GET_MOVIE, $data);
                }
                break;
            case DELETE_MOVIE:
                $movie->delete($movie_data['id']);
                $data = array('mensaje' =>$movie->mensaje);
                retornar_vista(VIEW_DELETE_MOVIE, $data);
                break;
            case EDIT_MOVIE:
                $movie->edit($movie_data);
                $data = array('mensaje' =>$movie->mensaje);
                retornar_vista(VIEW_GET_MOVIE, $data);
                break;
            case VIEW_MOVIES:
                $data = array('mensaje' => 'Listado de películas', 'tabla'=>'');                
                # Obtiene los registros
                $registros = $movie->listar();                                
                mostrar_registros(VIEW_MOVIES, $data, $registros);
                break;   
            case FIND_MOVIE:
                # Obtiene los registros
                $registros = $movie->filtrar($movie_data['tipo']);    
                $data = array('mensaje'=> $movie->mensaje, 'tabla'=>'');                            
                mostrar_registros(VIEW_FIND_MOVIES, $data, $registros);
                break;   
            case FIND_MOVIE_RANGE:
                # Obtiene los registros
                $registros = $movie->filtrarRango($movie_data['minimo'], $movie_data['maximo']);    
                $data = array('mensaje'=> $movie->mensaje,'tabla'=>'');                             
                mostrar_registros(VIEW_FIND_RANGE, $data, $registros);              
                break;      
            case VIEW_SELECTED:
                # Obtiene los registros
                $registros = $movie->getPeliculas();
                $peliculas = array();
                foreach($registros as $movie){                                                           
                    $peliculas[$movie->pl_id] = $movie->pl_nombre;   
                }                  
                if (isset($movie_data['id'])){                    
                    if ($movie->get($movie_data['id'])){ 
                        $data = array('mensaje' => 'ID : ' . $movie->pl_id . ", DURACIÓN : " . 
                                    $movie->pl_duracion . "-TIPO : " . $movie->pl_tipo);
                        # Crea el combobox con el contenido de la tabla     
                        $control = new ControlComboBox($peliculas,'id', $movie_data['id']); 
                        $data['combo'] = $control->getString();                                                  
                        cambiar_vista(VIEW_COMBO, $data);
                    }                  
                }
                else {              
                    # Crea el combobox con el contenido de la tabla     
                    $control = new ControlComboBox($peliculas,'id');
                    # Prepara los datos para entregarlos a la vista
                    $data = array('combo' => $control->getString(), 'mensaje'=>'Carga ' . count($registros) . ' de películas en el combo');                
                    cambiar_vista(VIEW_COMBO, $data);                    
                }
                break;                                                                             
            default:                
                retornar_vista($event);
        }
    }
    function set_obj() {
        $obj = new Pelicula();
        return $obj;
    }
    function helper_movie_data() {
        $movie_data = array();
        if($_POST) {
            if(array_key_exists('id' , $_POST)) {
                $movie_data['id'] = $_POST['id' ];
            }            
            if(array_key_exists('nombre' , $_POST)) {
                $movie_data['nombre' ] = $_POST['nombre' ];
            }
            if(array_key_exists('tipo' , $_POST)) {
                $movie_data['tipo' ] = $_POST['tipo' ];
            }
            if(array_key_exists('duracion' , $_POST)) {
                $movie_data['duracion' ] = $_POST['duracion' ];
            }
        } else if($_GET) {
            if(array_key_exists('id' , $_GET)) {
                $movie_data['id'] = $_GET['id'];
            }
            if(array_key_exists('tipo' , $_GET)) {
                $movie_data['tipo'] = $_GET['tipo'];
            }    
            
            # Considera los parámetros de búsqueda por rango de duración
            if(array_key_exists('minimo' , $_GET)) {
                $movie_data['minimo'] = $_GET['minimo'];
            }    
            if(array_key_exists('maximo' , $_GET)) {
                $movie_data['maximo'] = $_GET['maximo'];
            }            
        }
        return $movie_data;
    }
    handler();
?>                            