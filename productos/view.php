<?php
    # @author. Jazna
    # @versión. Mayo 2015
    
    $diccionario = array(
        'subtitle' =>array(VIEW_SET_MOVIE=>'Crear una nueva película' ,
                            VIEW_GET_MOVIE=>'Buscar película' ,
                            VIEW_DELETE_MOVIE=>'Eliminar película' ,
                            VIEW_EDIT_MOVIE=>'Modificar película',
                            VIEW_MOVIES=>'Listar películas',
                            VIEW_FIND_MOVIES=>'Filtrar películas',
                            VIEW_FIND_RANGE=>'Filtrar por duración',
                            VIEW_COMBOBOX => 'Mostrar en combobox'
                            ),
        'links_menu' =>array('VIEW_SET_MOVIE' =>MODULO. VIEW_SET_MOVIE.'/' ,
                            'VIEW_GET_MOVIE' =>MODULO. VIEW_GET_MOVIE.'/' ,
                            'VIEW_EDIT_MOVIE' =>MODULO. VIEW_EDIT_MOVIE.'/' ,
                            'VIEW_DELETE_MOVIE' =>MODULO. VIEW_DELETE_MOVIE.'/',
                            'VIEW_MOVIE' => MODULO . VIEW_MOVIES . '/',
                            'VIEW_FIND_MOVIES' => MODULO . VIEW_FIND_MOVIES . '/',
                            'VIEW_FIND_RANGE' => MODULO . VIEW_FIND_RANGE . '/',
                            'VIEW_SELECTED' => MODULO . VIEW_SELECTED . '/'
                            ),
        'form_actions' =>array(
            'SET' =>'/DAI5501/MVC/' . MODULO. SET_MOVIE.'/' ,
            'GET' =>'/DAI5501/MVC/' . MODULO. GET_MOVIE.'/' ,
            'DELETE' =>'/DAI5501/MVC/' . MODULO. DELETE_MOVIE.'/' ,
            'EDIT' =>'/DAI5501/MVC/' . MODULO. EDIT_MOVIE.'/',
            'LIST' =>'/DAI5501/MVC/' . MODULO. VIEW_MOVIE.'/',
            'FIND' =>'/DAI5501/MVC/' . MODULO. FIND_MOVIE.'/',
            'FINDRANGE' =>'/DAI5501/MVC/' . MODULO. FIND_MOVIE_RANGE.'/',
            'VIEWxCOMBO' =>'/DAI5501/MVC/' . MODULO. VIEW_SELECTED.'/'
            ),
        'types_movies' => array('1' => 'TERROR', 
            '2' => 'ACCIÓN', 
            '3'=>'CIENCIA FICCIÓN', 
            '4'=>'DRAMA')            
    );
    function get_template($form='get' ) {
        
        $file = '../site_media/html/pelicula_' . $form.'.html' ;
        $template = file_get_contents($file);
        return $template;
    }
    
    function render_dinamic_data($html, $data) {
        foreach ($data as $clave=>$valor) {
            $html = str_replace('{' . $clave.'}' , $valor, $html);
        }
        return $html;
    }
    
    function cambiar_vista($vista, $data=array()) {
        global $diccionario;
        $html = get_template('template' );
        $html = str_replace('{subtitulo}' , $diccionario['subtitle'][$vista], $html);
        $html = str_replace('{formulario}' ,  get_template($vista), $html);
        $html = render_dinamic_data($html, $diccionario['form_actions']);
        $html = render_dinamic_data($html, $diccionario['links_menu']);
        $html = render_dinamic_data($html, $data);                             
        print $html;      
    } 
    
    function retornar_vista($vista, $data=array()) {
        global $diccionario;
        $html = get_template('template' );
        $html = str_replace('{subtitulo}' , $diccionario['subtitle'][$vista], $html);
        $html = str_replace('{formulario}' ,  get_template($vista), $html);
        $html = render_dinamic_data($html, $diccionario['form_actions']);
        $html = render_dinamic_data($html, $diccionario['links_menu']);
        $html = render_dinamic_data($html, $data);        
        if(array_key_exists('nombre' , $data) &&
            array_key_exists('id' , $data) && $vista==VIEW_EDIT_MOVIE) {
                $mensaje = 'Editar película ' . $data['nombre' ] .' ID : ' . $data['id' ];
        } else {
            if(array_key_exists('mensaje', $data)) {
                $mensaje = $data['mensaje'];
            } else {
                $mensaje = 'Datos de la película:' ;
            }
        }
        # Define los mensajes de las otras vistas
        switch ($vista) {
            case VIEW_FIND_MOVIES:
                $mensaje = 'Filtro de búsqueda' ;
                break;            
            case VIEW_FIND_RANGE:
                $mensaje = 'Rango de duración [mínimo, máximo]' ;
                break;
        }
        $html = str_replace('{mensaje}' , $mensaje, $html);       
        print $html;      
    }  

    function mostrar_registros($vista, $data=array(), $registros=array()){
        global $diccionario;
        $html = get_template('template' );
        $html = str_replace('{subtitulo}', $diccionario['subtitle'][ $vista], $html);
        $html = str_replace('{formulario}', get_template($vista), $html);
        $html = render_dinamic_data($html, $diccionario['form_actions']);
        $html = render_dinamic_data($html, $diccionario['links_menu']);        
        $mensaje = $data['mensaje'];
        
        # Arma el arreglo con los datos de acuerdo a lo que necesita el Grid
        $peliculas = array();
        foreach($registros as $movie){
            $tipo = $diccionario['types_movies'][$movie->pl_tipo];  
            $x_pelicula = array("id" => $movie->pl_id, 
                                "nombre" => $movie->pl_nombre, 
                                "tipo" => $tipo, "duracion" => $movie->pl_duracion);
            $peliculas[] = $x_pelicula;  
        }        
        # Arma la tabla para ser desplegada
        $grid = Grid::getInstancia($peliculas);
        $grid = $grid->setup(array(
                    'id' => array('header' => 'ID'),
                    'nombre' => array('header' => 'NOMBRE'),
                    'tipo' => array('header' => 'TIPO'),
                    'duracion' => array('header' => 'DURACION')
                )); 
        $grid = $grid->setTitulo($data['mensaje']);
         
        $data['tabla'] = $grid->getString();
        # Termina de armar la vista 
        $html = render_dinamic_data($html, $data);              
        print $html;              
    }  
 ?>    