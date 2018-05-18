# Internacionalización
## Implementación soporte de traducción.

Las funciones del tipo;

```php
<?
//'main_menu' => __('Menú Principal', 'mawt')(...)

register_sidebar(array(
      'name' => __('Sidebar principal', 'mawt') ,
      'id' => 'main_sidebar',
      'description' => __('Este es el sidebar principal', 'mawt'),
      'before_widget' => '<article id="%1$s" class="Widget  %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
    ));

```
El primer parámentro 'Menú Principal' es el texto que va a ser sensible a traducir.
El segundo parámentro es el dominio.El dominio lo establecemos en style.css

``` css
/* Archivo style.css*/
/* Text Domain: mawt */
```
Para llevar a cabo las traducciones; 

1. Usamos la herramienta [icanlocalize](http://www.icanlocalize.com/tools/php_scanner) subiendo todo el contenido del tema, en formato zip.
2. Esta herramienta generará un archivo.po
3. Con poedit lo editaremos para llevar a cabo la traducción.

Para traducir el contenido - Existe un plugin llamado Locotranslate bastante indicado.

## Temas hijos

¿Qué ocurre si queremos mantener un tema base y otro tema "relacionado" en donde apliquemos las modificaciones pertinentes que en ese momento estemos desarrollando?

Para eso pueden servir los temas hijos.
¿Cómo se crean?
Creamos una carpeta con el mismo nombre del tema pero precedido de la palabra child por ejemplo child_mawt

Los archivos mínimos que necesita un tema hijo son
1. La hoja de estilos
2. functions.php

Para que WP detecte que se trata de un tema hijo tenemos que poner unos ciertos metadatos en la hoja de estilos del tema hijo

``/*!
  Theme Name: My Awesome WP Child Theme
  Theme URI: https://jonmircha.com/mawt-child/
  Description: Child Theme. Parent Theme: My Awesome WP Theme
  Author: Jonathan MirCha
  Author URI: https://jonmircha.com/
  Template: mawt
  Version: 1.0.0
  License:      GNU General Public License v2 or later
  License URI:  http://www.gnu.org/licenses/gpl-2.0.html
  Tags: one-column, two-columns, right-sidebar, flexible-header, accessibility-ready, custom-colors, custom-header, custom-menu, custom-logo, editor-style, featured-images, footer-widgets, post-formats, rtl-language-support, sticky-post, theme-options, threaded-comments, translation-ready
  Text Domain: child_mawt
  */
``

Es lo mismo pero hay un campo nuevo llamado template:nombreDelPadre
En la hoja de estilos del hijo debemos de llamar a la hoja de estilos del padre
`import url('../mawt/style.css');*/ Pero esto es una mala practica es mejor llamarla desde functions.php`
De esta manera obtenmos la misma estructura de maquetación

## Archivos del tema hijo

Nuestro tema hijo no es necesario que tenga todos los archivos del padre, solo aquellos que vayamos a modificar

La cabecera de nuestro functions.php

```css
/**
  * My Awesome WordPress Child Theme functions and definitions
  *
  * @link https://developer.wordpress.org/themes/basics/theme-functions/
  *
  * @package mawt
  * @subpackage child_mawt
  * @since 1.0.0
  * @version 1.0.0
  */
```
Para llamar a nuestros CSS o JS desde el tema hijo es buena practica hacerlo desde functions.php

```php
<?
    wp_register_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Raleway:400,700', array(), '1.0.0', 'all' );
    wp_register_style( 'parent-style', get_template_directory_uri() . '/style.css', array('google-fonts'), '1.0.0', 'all' );
    wp_register_style( 'style', get_stylesheet_uri(), array('google-fonts', 'parent-style'), '1.0.0', 'all' );

    wp_enqueue_style( 'google-fonts' );
    wp_enqueue_style( 'parent-style' );
    wp_enqueue_style( 'style' );

```

- El archivo __function.php__ del tema hijo. Todas las funciones que se encuentran en el tema padre se cargan tambien en el tema hijo. La única diferencia es que a nivel de jerarquia, las funciones del tema hijo tienen más peso
- Si escribimos el mismo nombre de función tanto en el padre como en el hijo, __la del padre se descarta y se queda la del hijo__
_ ` wp_register_style( 'parent-style', get_template_directory_uri() . '/style.css', array('google-fonts'), '1.0.0', 'all' );` Cargará la hoja de estilo del padre pues estamos usando `get_template_directory_uri()`
- Para cargar la hoja de estilos del hijo debemos usar `get_template_directory_uri()` de tal manera que quedaría `    wp_register_style( 'style', get_template_directory_uri(), array('google-fonts', 'parent-style'), '1.0.0', 'all' );
`
- Lo mismo ocurre para registrar los archivos JS;

```php
<?
//JS del Padre
  wp_register_script( 'parent-scripts', get_template_directory_uri() . '/scripts.js', array('jquery'), '1.0.0', true );
//JS del Hijo
  wp_register_script( 'scripts', get_stylesheet_directory_uri() . '/scripts.js', array('jquery', 'parent-scripts'), '1.0.0', true );
```

```php
<?
if ( !function_exists( 'mawt_scripts' ) ):
  function mawt_scripts () {
    wp_register_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Raleway:400,700', array(), '1.0.0', 'all' );
    wp_register_style( 'parent-style', get_template_directory_uri() . '/style.css', array('google-fonts'), '1.0.0', 'all' );
    wp_register_style( 'style', get_template_directory_uri(), array('google-fonts', 'parent-style'), '1.0.0', 'all' );

//Cola de archivos para CSS
    wp_enqueue_style( 'google-fonts' );
    wp_enqueue_style( 'parent-style' );
    wp_enqueue_style( 'style' );
          
    wp_register_script( 'parent-scripts', get_template_directory_uri() . '/scripts.js', array('jquery'), '1.0.0', true );
    wp_register_script( 'scripts', get_stylesheet_directory_uri() . '/scripts.js', array('jquery', 'parent-scripts'), '1.0.0', true );

//Cola de archivos para JS
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'parent-scripts' );
    wp_enqueue_script( 'scripts' );
  }
endif;
```

## Soporte para intercionalización

- WP va a detectar que la función de traducción se va a llamar igual en ambos functions.php por lo tanto descarta la del padre.
- Una manera de proceder seria mantener la función en functions.php del padre y la del hijo.
- En el padre, la traducción se encuentra en la función `function child_setup ()` Pero en el hijo llamamos a esa función `function child_mawt_setup () ` y con ello conseguimos varias cosas
    1. Mantemos la funcionalidad del functions.php del padre y las hereda el hijo. Funcionalidades tales como; 
        - El textdomain del Padre
        - Soporte para HTML5 
        - post-thumbnails
    2. Podemos crear funcionalidades específicas del hijo (que el padre no tiene) así nos centramos en las características del hijo.
    3. Podemos crear un textdomain propio del hijo.
```php

if ( !function_exists( 'child_mawt_setup' ) ):
  function child_mawt_setup () {
    load_child_theme_textdomain( 'child_mawt', get_stylesheet_directory_uri() . '/languages' );
  }
endif;

add_action( 'after_setup_theme', 'child_mawt_setup' );

```

## Query
- La clase WPQuery es una funcionalidad que nos da más características al proceso __the_loop()__
- Vamos a hacer que aparezcan 4 publicaciones al azar en alguna parte de nuestra página web
- `wp_reset_postdata();` Despues de un Loop limpia las variables. __Si no limpiamos las variables después de un Loop__ estas se quedan y podemos ver como se repite la información.

```php
<?php
    //https://developer.wordpress.org/reference/classes/wp_query/
    //https://codex.wordpress.org/Class_Reference/WP_Query
    
    //Declaramos la variable $wp_query
    //Nuevo objeto WP_Query que es un array asociativo que recibe una serie de páramentros
    $wp_query = new WP_Query( array(
        'posts_per_page' => 4, //4 Post 
        'orderby' => 'rand' //Randomize por carga
    ) );

    if( $wp_query->have_posts() ):
        while ($wp_query->have_posts()):
            $wp_query->the_post();
            ?>
            <figure>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail( 'thumbnail' ); ?>
                    <?php the_title('<figcaption>', '</figcaption>'); ?>
                </a>
            </figure>
        <?php
        endwhile;
    endif;
    wp_reset_postdata();
    ?>
```
- Si quieramos pasar parámetros al loop principal podriamos usar la función ``query_post(query)`` [query_post](https://developer.wordpress.org/reference/functions/query_posts/
)

````php
<?
query_posts(null);
````

- Query post recibe una lista de argumentos por ejemplo solo queremos dos publicaciones y en un orden ascendentes.
- Query post recibe los mismos parámentros que WP-Query.
- [query_post](https://developer.wordpress.org/reference/functions/query_posts/
)
````php
<?
query_posts(array( 
    'post_per_page' => 3, //Solo tres entradas
    'orderby' => 'desc' //Orden descendentes cronologicamente
));
````
