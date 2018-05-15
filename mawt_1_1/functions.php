<?php
/**
 * @link
 * @package
 * @subpackage
 * @since
 * @version
 */


/*1-Invocar los archivos css y js por medio de nuestra funcion*/

if (!function_exists('mawt_scripts')):

//Siempre es buena práctica comprobar si la funcion existe, sino la cargará por primera vez. Es una buena práctica
//Cuando la vuelva a llamar no la llamará porque la tiene en memoria

    //Vamos a usar para nuestras funciones el nombre de nuestro tema con guion bajo mas breve funcionalidad

    function mawt_scripts(){
        //Esta función de WP sirve para registrar una hoja de estilos
        //Le damos un nombre de alias que lo va a reconcer WP
        //get_stylesheet_uri() nos da la hoja de estilos principal
        //null si no tienen dependencias
        //pero si por ejemplo tenemos dependencias como a lo mejor la des google font lo podnria asi
        //wp_register_style('style',get_stylesheet_uri(),array('google-fonts',otrahoja, y otra hoja..etc);

        wp_register_style(
            'google-fonts',
            'https://fonts.googleapis.com/css?family=Roboto',
             array(),
            '1.0.0',
            'all');

        wp_register_style(
            'style',
            get_stylesheet_uri(),
            array('google-fonts'),
            '1.0.0',
            'all');

        // wp_enqueue_style() esta función es necesaria para terminar de registrar nuestro archivo css
        // en ella indicamos el nombre de nuestro archivo css

        wp_enqueue_style('google-fonts');
        wp_enqueue_style('style');

        //Llamamos a los JS

        wp_register_script(
            'scripts',
            get_template_directory_uri().'/script.js',
            array('jquery'),
            '1.0.0',
            true
            );

        wp_enqueue_script('jquery');
        wp_enqueue_script('scripts');




    }

endif;

//Registramos las hojas de estilo con la llamada a la acción
//El segundo parámetro es el nombre de la función que tiene que invocar que es la que acabamos de definir

add_action('wp_enqueue_scripts','mawt_scripts');

/*2-Configuraciones del tema*/

//Todas nuestras funciones deben de empezar por el nombre de nuestro tema mawt_xxx y seguido de un pequeño nombre descriptivo

if(!function_exists('mawt_setup')):
    function mawt_setup(){
        //Mostramos la imagen destacada en el editor del post
        add_theme_support('post-thumbnails');

        //Punto 3 Activación HTML soporte
        //Indicamos dónde queremos activar HTML5
        add_theme_support('html5',array(
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption'
        ));
    }
endif;

//after_setup_theme cuando nuestro tema ha cargado ejecuta mawt_setup
add_action('after_setup_theme','mawt_setup');

/*3.- Interactividad */

//Inicializamos nuestros menus que tenemos que invocar desde function

if(!function_exists('mawt_menus')):
    function mawt_menus(){
        //register_nav_menu(); Solo para un menú
        register_nav_menus(array(
            'main_menu' => __('Menú Principal','mawt'), //__('') Función para traducciónes (Se vé más adelante)
            'social_menu' => __('Menú Redes Sociales','mawt')
        ));
    }
endif;
//Init es como el document.ready
add_action('init','mawt_menus');

//Activación de Widgets

if(!function_exists('mawt_register_sidebars')):
    function mawt_register_sidebars(){
        //register_sidebars() si registramos varios
        register_sidebar(array(
            'name'=> __('Sidebar Principal','mawt'),
            'id'=>'main_sidebar',
            'description'=>__('Este es el sidebar principal','mawt'),
            //Ahora describimos la etiqueta para encerrar el widgets
            //Tambien podemos definir clases
            //%1$s y %2$s son máscaras qeu WP va a detectar
            'before_widget'=>'<article id="%1$s" class="Widget %2$s">',
            'after_widget'=>'</article>',
            'before_title'=>'<h3>',
            'after_title'=>'</h3>',
        ));
    }
endif;
//la acción se va a realizar en la inicialización de widgets
add_action('widgets_init','mawt_register_sidebars');

//Activación de HTML - Funcionalidades - en theme_support arriba en mawt_setup






