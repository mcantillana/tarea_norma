<?php
    # @author. Norma Soto
    # @versión. Julio 2015
    
    $diccionario = array(

    );
    function get_template($form='get', $tipo='.html' ) {
        $file = '../site_media/html/tipo_producto_' . $form. $tipo ;
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
        if(array_key_exists('mensaje', $data)) {
            $mensaje = $data['mensaje'];
        } else {
            $mensaje = '' ;
        }        
        $html = str_replace('{mensaje}' , $mensaje, $html);       
        print $html;      
    }  
    
    function vista_login($vista, $data=array()) {
        $html = get_template($vista, '.php' );   
        $html = render_dinamic_data($html, $data);        
        print $html;    
    }

    function get_parte_template($vista='',$modulo='',$ext='.html' ) {        
        $file = '../site_media/html/'.$modulo.'_' . $vista. $ext ;        
        $template = file_get_contents($file);
        return $template;
    }

    function vista_sidebar($items) {

        $html = '';

        foreach ($items as $item) {
            $html .= '<h5><i class="'.$item['icon'].'"></i>
                <small><b>'.$item['nombre'].'</b></small>
            </h5>';
            $html .= '<ul class="nav nav-pills nav-stacked">';
            foreach ($item['items'] as $elem) {
                $html .= '<li><a href="'.$elem['link'].'">'.$elem['nombre'].'</a></li>';
            }
            $html .= '</ul>';

        }

        return $html;
    }

    function render_table($items) {
        
        $html = '<table class="table table-condensed">';
        $html .= '<thead>
        <tr>
          <th>#</th>
          <th>Descripción Tipo Producto</th>
          <th>Acción</th>
        </tr>
        </thead>';

        foreach ($items as $item) {
            
            $accion_eliminar = "onclick=\"if(confirm('¿Estas Seguro de Eliminar')){window.location.href = ''}\"";
            $html .='<tr>
              <th scope="row">'.$item['id_tipoProducto'].'</th>
              <td>'.$item['descripcion_tipo'].'</td>
              <td><a href="">Editar</a> / <a href="#" '.$accion_eliminar.'>Eliminar</a></td>
            </tr>';

        }
        $html .= '</table>';
        return $html;
    }    
    

    function botones_rapidos($items) {

        $html = '';
        foreach ($items as $item) {
            $html .= '<a href="'.$item['link'].'" class="btn '.$item['color'].' btn-lg btn-lg2" role="button"><span class="'.$item['icon'].'"></span> <br/>'.$item['nombre'].'</a> ';
        }

        return $html;
    }

    function retornar_vista_dinamica($vista='', $data=array()) {
        
        $header  = get_parte_template('header',$modulo='',$ext='.php' );
        $footer  = get_parte_template('footer');

        $html  = get_template($vista, '.html');
        $html  = render_dinamic_data($html, $data);        

        print $header.$html.$footer;
    }




 ?>  