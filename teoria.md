# Creación de temas en Wordpress IV
## 1. Planificación del tema

### Estructura básica de nuestra plantilla

Iniciamos nuestro proyecto de tema. Para ello creamos nuestra carpeta (nombredeltema) y se va a llamar __EDTheme__.
Para comenzar cualquier proyecto theme necesitamos 4 archivos básicos:

+ index.php (plantilla principal)
+ style.css 
+ functions.php
+ screenshot.png 

En __index.php__ podemos "pegar" una plantilla HTML para hacernos una idea de la maquetación definitiva. Esta puede ir en HTML para identificar los elementos que va a  manejar nuestra plantilla.


### Volviendo dinámica la plantilla con PHP

Ahora vamos a "volver dinámica" nuestra plantilla principal __index.php__ e ir troceandola en diferentes módulos.

Empezamos a usar las funciones de WP dentro de nuestra plantilla html

+ language_attributes();
+ bloginfo( 'charset' ); 
+ NombreDelTema_custom_meta_description();
+ wp_head(); WP inserta código HTML y JS por ello antes de cerrar la cabecera debemos incluir la función __wp_head()__ y antes de cerrar el body __wp_footer();__

````html
    <!DOCTYPE html>
    <html <?php language_attributes(); ?> >
    <head>
      <meta charset="<?php bloginfo( 'charset' ); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="description" content="<?php mawt_custom_meta_description(); ?>">
      <?php wp_head(); ?>
    </head>
````

Dependiendo de la sección que estemos usando, WP suele asignarle ciertas clases al elemento body. Si usamos `body_class()` nos muestra todos los bodys que se estan usando.
Podemos usar esas clases o incluir las nuestras mediante un arreglo que le pasamos a la función; `body_class(array)`

````html
<body <?php body_class(); ?> >
````

En el __footer__ `<?php echo date('Y') . __(' Derechos Reservados', 'mawt'); ?>` Fecha dínamica que la coge de nuestro servidor.

### Estructura de carpetas y archivos

Estructura de carpertas:

+ css; hojas de estilo
+ img; imágenes
+ inc; módulos por cada función que creemos
+ languages; carpetas de lenguaje
+ template-part; cabeceras, footer, content...partes de cada plantilla
+ page-template; diferentes alternativas a las páginas estáticas.
+ js; archivos javascript

Archivos básicos:

+ 404.php 
+ single.php es el que se abre cuando abrimos las información de una entrada
+ page.php páginas estáticas
+ search.php páginas de búsquedas
+ author.php autor
+ archive.php carga para elementos multimedia, autores, resultados de etiquetas y categorias
+ comments.php comentarios
+ script.js similar al style.css pero para códigos javascript
+ header.php, footer.php, sidebar.php y el no oficial content.php, todos ellos para mostrar el contenido de las diferentes partes de nuestra site

### Definiendo zonas comunes

__index.php__

````php
<?
    get_header();
    get_template_part( 'template-parts/content' );
    get_footer();
````


__header.php__

````html
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="<?php mawt_custom_meta_description(); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="Header">
      <section class="Header-container">
        <?php
        get_template_part( 'template-parts/header-logo' );
        get_template_part( 'template-parts/header-menu' );
        ?>
      </section>
    </header>
    <?php
    if ( is_home() || is_front_page() ):
      get_template_part( 'template-parts/header-custom' );
    else:
      get_template_part( 'template-parts/hero-image' );
    endif;
  ?>
    <section class="Content">
````

__footer.php__

````html
</section>
    <footer class="Footer">
      <section class="Footer-container">
        <div>
          <?php
          if ( has_nav_menu( 'social_menu' ) ):
            wp_nav_menu(array(
              'theme_location' => 'social_menu',
              'container' => 'nav',
              'container_class' => 'SocialMedia',
              'link_before' => '<span class="sr-text">',
              'link_after' => '</span>'
            ));
          endif;
        ?>
        </div>
        <div>
          <p>
            &copy; <?php echo date('Y') . __(' Derechos Reservados', 'mawt'); ?>
            <a href="https://jonmircha.com" target="_blank">@jonmircha</a>.
          </p>
        </div>
      </section>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>
````

__content.php__

Desde content.php vamos a invocar el sidebar `get_sidebar()`

````html
<div class="Content-container">
  <main class="Main">
  <?php
    if (have_posts()): while (have_posts()): the_post();
      get_template_part( 'template-parts/content-main' );
    endwhile; else:
      get_template_part( 'template-parts/content-none' );
    endif;
  ?>
  </main>
  <?php
  get_template_part( 'template-parts/pagination' );
  get_sidebar();
  ?>
</div>
````

__sidebar.php__

````html
<aside class="Sidebar">
  <?php
    if (is_active_sidebar( 'main_sidebar' )):
      dynamic_sidebar( 'main_sidebar' );
    else:
  ?>
    <article class="Widget">
      <h3><?php _e('Buscar', 'mawt'); ?></h3>
      <?php get_search_form( ); ?>
    </article>
  <?php
    endif;
  ?>
</aside>
````

### Automatizar las tareas de desarrollo

+ babel.rc módulos de script 6
+ gulpfile.js automatizador de tareas

Y procedemos a instalar gulp y todas las dependencias

Creamos el archivo en la carpeta css __style.scss__ Con el comentario especial `/*!....etc */ `

`````css
/*!
 Theme Name: My Awesome WP Theme
Theme URI: https://jonmircha.com/mawt/
Author: Jonathan MirCha
Author URI: https://jonmircha.com/
Description: Una breve descripción de las características que tu tema ofrece a nivel de diseño, programación y personalización. Escríbela en inglés.
Version: 1.0.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: one-column, two-columns, right-sidebar, left-sidebar, full-width, flexible-header, accessibility-ready, custom-colors, custom-header, custom-menu, custom-logo, editor-style, featured-images, footer-widgets, post-formats, theme-options, translation-ready
Text Domain: mawt
*/
`````

+ JavaScript esta orientado a módulos para compilarlos en el archivo __script.js__.
+ Estos módulos van primero a __index.js__ dentro de la carpeta __js__.
+ Las imagenes se organizan primero en la carpeta __raw__ dentro de __img__ para luego optimizarlas en la raiz de img.
+ Traducción para dar soporte al inglés.


__funtions.php__

Es buena práctica comenzar functions.php con este comentario inicial.

+ `My Awesome WordPress Theme functions and definitions` Título del tema.
+ ` * @link https://developer.wordpress.org/themes/basics/theme-functions/` El paquete es para wordpress
+ ` * @package WordPress` Paquete es para WP
+ ` * @subpackage mawt` Es el nombre de nuestro tema
+ ` * @since 1.0.0` Si estas modificando una versión y desde donde
+ ` * @version 1.0.0` Versión actual


````php
<?
/**
 * My Awesome WordPress Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage mawt
 * @since 1.0.0
 * @version 1.0.0
 */
````

Establecer el ancho máximo de nuestro tema;

Con este código __normalizamos el tema__ es decir, si incrustamos un video de youtube, una imagen o un mapa __no sobrepasará__ el ancho que indicamos `$content_width = 800;`

````php
<?
//https://codex.wordpress.org/Content_Width
//Establecer el ancho máximo permitido para cualquier contenido en el tema, como oEmbeds e imágenes
//Si no está definida $content_width, definela a 800px
if ( !isset( $content_width ) ) {
  $content_width = 800;
}
````

El siguiente paso es inyectar nuestras __hojas de estilo y javascript__. Recordemos que todas las funciones que creamos para nuestro tema deben empezar por el nombre del tema.

````php
<?
//Si no existe la función mawt_scripts
if ( !function_exists('mawt_scripts') ):
  function mawt_scripts () {
    global $google_fonts;
    global $font_awesome;
    global $hamburgers;

    wp_enqueue_style( 'google-fonts', $google_fonts, array(), '1.0.0', 'all' );
    wp_enqueue_style( 'font-awesome', $font_awesome, array(), '5.0.13', 'all' );
    wp_enqueue_style( 'hamburgers', $hamburgers, array(), '0.9.3', 'all' );
    wp_enqueue_style( 'custom-properties', get_template_directory_uri() . '/css/custom_properties.css', array('google-fonts'), '1.0.0', 'all' );
    //Nombre de hoja de estilo, luego vamos a ver si tiene dependencias, versión y para que medios
    wp_enqueue_style( 'style', get_stylesheet_uri(), array('google-fonts', 'font-awesome', 'hamburgers', 'custom-properties'), '1.0.0', 'all' );

    //Inyectamos jquery y nuestro archivo script
    wp_enqueue_script( 'jquery' );
    //script tiene como dependencia jquery, queremos que se inyecte en el footer ponemos un true
    wp_enqueue_script( 'script', get_template_directory_uri() . '/script.js', array('jquery'), '1.0.0', true );
  }
endif;

//La función se carga en el evento wp_enqueue_scripts y cargamos mawt_scripts
add_action('wp_enqueue_scripts', 'mawt_scripts');
````

### Archivo gulpfile.babel.js

Gulp

````javascript
import gulp from 'gulp'
import browserSync from 'browser-sync'
import plumber from 'gulp-plumber'
import sass from 'gulp-sass'
import sourcemaps from 'gulp-sourcemaps'
import autoprefixer from 'gulp-autoprefixer'
import cleanCSS from 'gulp-clean-css'
import browserify from 'browserify'
import babelify from 'babelify'
import source from 'vinyl-source-stream'
import buffer from 'vinyl-buffer'
import jsmin from 'gulp-jsmin'
import imagemin from 'gulp-imagemin'
import wpPot from 'gulp-wp-pot'
import sort from 'gulp-sort'

const reload = browserSync.reload,
  reloadFiles = [
    './script.js',
    './style.css',
    './**/*.php'
  ],
  proxyOptions = {
    proxy: 'localhost:8080/perros/',
    notify: false
  },
  imageminOptions = {
    progressive: true,
    optimizationLevel: 3, // 0-7 low-high
    interlaced: true,
    svgoPlugins: [{ removeViewBox: false }]
  },
  wpPotOptions = {
    domain: 'kenai',
    package: 'kenai',
    lastTranslator: 'Jonathan MirCha <jonmircha@gmail.com>'
  },
  potFile = './languages/en_US.pot'

gulp.task('server', () => browserSync.init(reloadFiles, proxyOptions))

gulp.task('css', () => {
  gulp.src('./css/style.scss')
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(plumber())
    .pipe(sass())
    .pipe(autoprefixer({ browsers: ['last 2 versions'] }))
    .pipe(cleanCSS())
    .pipe(sourcemaps.write('./css/'))
    .pipe(gulp.dest('./'))
    .pipe(reload({ stream: true }))
})

gulp.task('js', () => {
  browserify('./js/index.js')
    .transform(babelify)
    .bundle()
    .on('error', err => console.log(err.message))
    .pipe(source('script.js'))
    .pipe(buffer())
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(sourcemaps.write('./js/'))
    .pipe(jsmin())
    .pipe(gulp.dest('./'))
    .pipe(reload({ stream: true }))
})

gulp.task('img', () => {
  gulp.src('./img/raw/**/*.{png,jpg,jpeg,gif,svg}')
    .pipe(imagemin(imageminOptions))
    .pipe(gulp.dest('./img'))
})

gulp.task('translate', () => {
  gulp.src('./**/*.php')
    .pipe(sort())
    .pipe(wpPot(wpPotOptions))
    .pipe(gulp.dest(potFile))
})

gulp.task('default', ['server', 'css', 'js'], () => {
  gulp.watch('./css/**/*.+(scss|css)', ['css'])
  gulp.watch('./js/**/*.js', ['js'])
})
````
## 2. Integración de funciones

### Variable global google fonts

Vamos a dar de alta otra hoja de estilos que va a ser la de __google fonts__ Para ello en __funtions.php__ vamos a declarar __variables globales__ `global $google_fonts;`.

````php
<?
/**
 * My Awesome WordPress Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage mawt
 * @since 1.0.0
 * @version 1.0.0
 */

global $google_fonts;
````

En la función para inyectar la hoja de estilos tambien tenemos que invocar google_fonts para que la función la reconozca

````php
<?
  function mawt_scripts () {
    //Invcamos $google_fonts de nuevo para que la función la reconozoca
    global $google_fonts;
 
    wp_enqueue_style( 'google-fonts', $google_fonts, array(), '1.0.0', 'all' );
    }
````

Ahora solo queda usarla en __wp_enqueue_style__ `wp_enqueue_style( 'google-fonts', $google_fonts, array(), '1.0.0', 'all' );`


## Creación e invocación de menus y widgets

#### Menus

Los menus se inicia en la acción `add_action( 'init', 'mawt_menus' );`.
Estamos dando de alta el `Menú principal` y el `Menú Redes Sociales`. Posteriormente en el dashboard lo ubicamos en el lugar correspondiente de nuestro tema.


````php
<?
function mawt_menus () {
  register_nav_menus(array(
    'main_menu' => __('Menú Principal', 'mawt'),
    'social_menu' => __('Menú Redes Sociales', 'mawt')
  ));
}

add_action( 'init', 'mawt_menus' );
````
Para activarlo y que se muestre de manera dinámica nos vamos a __header.php__.

```html
 <section class="Panel">
          <?php
            if ( has_nav_menu( 'main_menu' ) ):
              wp_nav_menu( array(
                'theme_location' => 'main_menu',
                'container' => 'nav',
                'container_class' => 'Menu'
              ) );
            else:
          ?>
              <nav class="Menu">
                <ul>
                  <?php wp_list_pages('title_li'); ?>
                </ul>
              </nav>
          <?php endif; ?>
        </section>
```
+ wp_nav_menu() función que usamos para mostrar el menú
+ 'theme_location' => 'main_menu', Es el menú principal.
+ La etiqueta contenedora del menu va a ser un __nav__ `'container' => 'nav',`
+ Y va a tener la clase __Menu__ `'container_class' => 'Menu'`


````php
<?
wp_nav_menu( array(
                'theme_location' => 'main_menu',
                'container' => 'nav',
                'container_class' => 'Menu'
              ) );

````

Si se da el caso contrario es decir, no menú, muestra una lista de las páginas disponibles.

````html
 <nav class="Menu">
                <ul>
                  <?php wp_list_pages('title_li'); ?>
                </ul>
              </nav>
````

Luego en __footer.php__ mostramos nuestro menu social.

+ 'link_before' => '<span class="sr-text">','link_after' => '</span>', Span que envuelve antes y despues del menú. __sr-text__ es la clase que nos va a permitir mostrar los iconos social media.

Este link before y after también está para hacer más accesible (a las personas ciegas) nuestra página. Con la clase sr-text vamos a permitir que este tipo de usuarios sepan en donde se encuentran dentro de nuestra página.


````php
<?
 if ( has_nav_menu( 'social_menu' ) ):
            wp_nav_menu(array(
              'theme_location' => 'social_menu',
              'container' => 'nav',
              'container_class' => 'SocialMedia',
              'link_before' => '<span class="sr-text">',
              'link_after' => '</span>'
            ));
          endif;
````



#### Widgets

Los widgets se inician en `add_action('widgets_init', 'mawt_register_sidebars');`.

+ 'name' => __('Sidebar principal', 'mawt') , Nombre del __sidebar__ `Sidebar principal` con las funciones para las traducciónes `'mawt'.
+ 'id' => 'main_sidebar', El __id__ del sidebar.
+ 'description' => __('Este es el sidebar principal', 'mawt'), La descripción con soporte para traducción.
+ 'before_widget' => '<article id="%1$s" class="Widget  %2$s">', Lo que va antes del Widgets __con el id y la clase widget__.
+ 'after_widget' => '</article>', Que va a ir despues.
+ 'before_title' => '<h3>', va antes del título.
+ 'after_title' => '</h3>', y lo que va despues.


````php
<?
function mawt_register_sidebars () {
  register_sidebar(array(
    'name' => __('Sidebar principal', 'mawt') ,
    'id' => 'main_sidebar',
    'description' => __('Este es el sidebar principal', 'mawt'),
    'before_widget' => '<article id="%1$s" class="Widget  %2$s">',
    'after_widget' => '</article>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
}

add_action('widgets_init', 'mawt_register_sidebars');

````

Los cambios los vamos a ver en nuestro __dashboard__. Podemos obsevar que aparece el menu __widgets__ y el __Sidebar Principal__ en donde podemos poner todos los widgets como por ejemplo calendario, busqueda...etc.


## Creación e invocación de widgets

En nuestro __sidebar.php__ vamos a invocar los widget y vamos a hacerlo mediante una comprobación. Si está activo nuestro sidebar mostramos los widgets correspondientes dentro de nuestro sidebar, sino __mostramos un formulario de busqueda__ `get_search_form( );`

````html
<aside class="Sidebar">
    <?php
    if (is_active_sidebar( 'main_sidebar' )):
        dynamic_sidebar( 'main_sidebar' );
    else:
        ?>
        <article class="Widget">
            <h3><?php _e('Buscar', 'mawt'); ?></h3>
            <?php get_search_form( ); ?>
        </article>
    <?php
    endif;
    ?>
</aside>
````

## Configuración de soporte

En __functions.php__ damos soporte a nuestro tema mediante la función __function mawt_setup ()__

+ __load_theme_textdomain( 'mawt', get_template_directory() . '/languages' );__ Soporte para los idiomas.
+ __add_theme_support( 'post-thumbnails' );__ Para os thumbnails
+ __add_theme_support('html5',array(...))__ Soporte para html5
    + comment-list
    + comment-form
    + search-form
    + gallery
    + caption
    
El archivo php que da soporte a las entradas es el __single.php__ WP nos ofrece unos 9 tipos de formatos, entrada estandar, galeria de imágenes...etc. Nosotros podemos validar en nuestro __single.php__ que tipo de entrada se trata y según el tipo podemos cambiar la maquetación.
Al añadir en nuestro __funtions.php__ el sorpote para entradas `add_theme_support('post-formats'...` veremos los formatos disponibles para cada entrada.

+ __add_theme_support( 'title-tag' );__ WP tiene una función que dependiendo en donde nos encontremos podemos poner diferentes títulos. Ya no usaremos wp_title y eliminamos la etiqueta __title__ de nuestro header

+ __add_theme_support( 'automatic-feed-links' );__ los feed de RSS
+ __remove_action('wp_head', 'wp_generator');__ eliminamos etiquetas meta que mete WP. wp_generator muestra en el código HTML la versión de WP, no es buena idea mostrar

Y el resto ya es a consideración;

````php
//Imprime sugerencias de recursos para los navegadores para precargar, pre-renderizar y pre-conectarse a sitios web
  remove_action('wp_head', 'wp_resource_hints', 2);
  //Muestre el enlace al punto final del servicio Really Simple Discovery
  remove_action('wp_head', 'rsd_link');
  //Muestre el enlace al archivo de manifiesto de Windows Live Writer
  remove_action('wp_head', 'wlwmanifest_link');
  //Inyecta rel = shortlink en el encabezado si se define un shortlink para la página actual.
  remove_action('wp_head', 'wp_shortlink_wp_head');

  //Quitar scripts para soporte a emojis
  //remove_action('wp_print_styles', 'print_emoji_styles');
  //remove_action('wp_head', 'print_emoji_detection_script', 7);

  //Quitar la barra de administración en el Frontend
  add_filter('show_admin_bar', '__return_false');
````

````php
<?
function mawt_setup () {
  load_theme_textdomain( 'mawt', get_template_directory() . '/languages' );

  add_theme_support( 'post-thumbnails' );

    add_theme_support('html5', array(
    'comment-list',
    'comment-form',
    'search-form',
    'gallery',
    'caption'
  ));

  //https://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats',  array (
    'aside',
    'gallery',
    'link',
    'image',
    'quote',
    'status',
    'video',
    'audio',
    'chat'
  ) );

  //Permite que los themes y plugins administren el título, si se activa, no debe usarse wp_title()
  add_theme_support( 'title-tag' );

  //Activar Feeds RSS
  add_theme_support( 'automatic-feed-links' );

  //Ocultar Tags innecesarios del head
  //Versión de WordPress
  remove_action('wp_head', 'wp_generator');

  //Imprime sugerencias de recursos para los navegadores para precargar, pre-renderizar y pre-conectarse a sitios web
  remove_action('wp_head', 'wp_resource_hints', 2);
  //Muestre el enlace al punto final del servicio Really Simple Discovery
  remove_action('wp_head', 'rsd_link');
  //Muestre el enlace al archivo de manifiesto de Windows Live Writer
  remove_action('wp_head', 'wlwmanifest_link');
  //Inyecta rel = shortlink en el encabezado si se define un shortlink para la página actual.
  remove_action('wp_head', 'wp_shortlink_wp_head');

  //Quitar scripts para soporte a emojis
  //remove_action('wp_print_styles', 'print_emoji_styles');
  //remove_action('wp_head', 'print_emoji_detection_script', 7);

  //Quitar la barra de administración en el Frontend
  add_filter('show_admin_bar', '__return_false');
}

add_action('after_setup_theme', 'mawt_setup');
````

## Imprimiendo contenido básico

El loop `if (have_posts()): while (have_posts()): the_post();` Si hay post mientras haya post imprime post.
En este punto podemos empezar a plantear el diseño. Para ello modularizamos y creamos las plantillas que encapsulen el contenido.

__content.php__

Creamos las plantillas relacionadas:

+ get_template_part( 'template-parts/content-main' )
+ get_template_part( 'template-parts/content-none' )
+ get_template_part( 'template-parts/pagination' );
+ get_sidebar();

````html
<div class="Content-container">
  <main class="Main">
  <?php
    if (have_posts()): while (have_posts()): the_post();
      get_template_part( 'template-parts/content-main' );
    endwhile; else:
      get_template_part( 'template-parts/content-none' );
    endif;
  ?>
  </main>
  <?php
  get_template_part( 'template-parts/pagination' );
  get_sidebar();
  ?>
</div>
````
__content-main.php__

```php
<figure class="PostCard">
  <?php the_post_thumbnail(); ?>
  <figcaption>
    <h2>
      <a href="<?php the_permalink(); ?>"><?php the_title( ); ?></a>
    </h2>
    <?php the_excerpt(); ?>
    <?php get_template_part( 'template-parts/content-single' ); ?>
  </figcaption>
</figure>
```

__content-none.php__

````php
<article class="NotFound">
  <h2><?php _e('Contenido inexistente', 'mawt'); ?></h2>
  <p>
    <?php _e('Realiza una búsqueda para encontrar lo que deseas.', 'mawt'); ?>
  </p>
  <?php get_search_form(); ?>
</article>
````

Archivo de paginación. Vamos a crear una comprobación de que si existen páginas anteriores o posteriores ejecute el código.

+ __get_next_post_link() || get_preview_post_link( )__ Si existen link para páginas siguientes o previas nos muestre la paginación.

__pagination.php__

````php
<?php if ( get_next_post_link() || get_preview_post_link( ) ): ?>
  <div class="Pagination">
    <nav>
      <?php
        //https://codex.wordpress.org/Pagination
        echo paginate_links( array(
          'prev_text' => __('<span>&laquo; Anteriores</span>', 'mawt'),
          'next_text' => __('<span>Siguientes &raquo;</span>', 'mawt')
        ) );
      ?>
    </nav>
  </div>
<?php endif; ?>
````

## Soporte a plantillas para páginas

__page.php__

````php
<?php get_header(); ?>
<div class="Content-container Page">
  <main class="Main">
    <?php while ( have_posts() ) : the_post(); ?>
      <section class="PostContent">
        <article><?php the_content(); ?></article>
      </section>
    <?php endwhile; ?>
  </main>
  <?php  get_sidebar(); ?>
</div>
<?php  get_footer(); ?>
````

Vamos a crear plantillas para las páginas __page-full-width.php__ y __page-sidebar-left.php__
Para que WP las reconozca como plantillas de páginas tenemos que poner un comentario especial al principio del archivo 

+ __/*Template name: Nombre de la plantilla*/__  El nombre que le demos aparecerá en nuestro dashboard a la hora de crear páginas.


__page-full-width.php__

```php
<?php
/* Template name: Página sin sidebar */
get_header(); ?>
<div class="Content-container Page FullWidth">
  <main class="Main">
    <?php while ( have_posts() ) : the_post(); ?>
      <section class="PostContent">
        <article><?php the_content(); ?></article>
      </section>
    <?php endwhile; ?>
  </main>
</div>
<?php  get_footer(); ?>
```

__page-sidebar-left.php__

````php
<?php
/* Template name: Página con sidebar a la izquierda */
get_header(); ?>
<div class="Content-container Page Sidebar-left">
  <?php  get_sidebar(); ?>
  <main class="Main">
    <?php while ( have_posts() ) : the_post(); ?>
      <section class="PostContent">
        <article><?php the_content(); ?></article>
      </section>
    <?php endwhile; ?>
  </main>
</div>
<?php  get_footer(); ?>
````

## Plantilla de entrada

__single.php__

Como en __content.php__ vamos a modularizar el contenido para crear la maqueta

````php
<?php get_header(); ?>
<div class="Content-container">
  <main class="Main">
    <?php while ( have_posts() ) : the_post(); ?>
      <section class="PostContent">
        <article><?php the_content(); ?></article>
        <h3><?php _e('Información de la Pubicación', 'mawt'); ?></h3>
        <?php get_template_part( 'template-parts/content-single' ); ?>
      </section>
    <?php endwhile; ?>
  </main>
  <?php
    comments_template();
    get_sidebar();
  ?>
</div>
<?php get_footer(); ?>
````

__content-single.php__

````php
<p>
  <small>
    <i class="fas fa-calendar"></i>
    <?php the_time( get_option('date_format') ); ?>
    &bull;
    <i class="fas fa-user-circle"></i>
    <?php the_author_posts_link(); ?>
  </small>
</p>
<p>
  <i class="fas fa-tags"></i>
  <?php _e('Categorías: ', 'mawt'); the_category(', '); ?>
</p>
<p>
  <i class="fas fa-hashtag"></i>
  <?php the_tags(); ?>
</p>
<p>
  <i class="fab fa-wpforms"></i>
  <?php _e('Formato de Entrada: ', 'mawt'); echo ( get_post_format( $post ) ) ? get_post_format( $post ) : 'standard'; ?>
</p>
````

__comments_template();__ 

Hace referencia a __comments.php__ Vamos a realizar una validación. Si no hay comentarios solo muestra un mensaje con soporte para traducción. Pero según el número de comentarios mostramos mensajes diferentes

 + Si solo hay un comentario o si hay __%__ comentarios (% -> Número de comentarios)
 
 ````php
 <?
     comments_number(
          __('No hay comentarios aún', 'mawt'),
          __('Hay un comentario publicado', 'mawt'),
          __('Hay % comentarios', 'mawt')
        );
````

Luego en una __<ol>__ imprimimos los comentarios

````html
 <ol class="commentlist">
      <?php wp_list_comments(); ?>
    </ol>
````

````php
<aside class="Comments">
  <?php if ( have_comments() ): ?>
    <h3>
      <?php
        comments_number(
          __('No hay comentarios aún', 'mawt'),
          __('Hay un comentario publicado', 'mawt'),
          __('Hay % comentarios', 'mawt')
        );
      ?>
    </h3>
    <ol class="commentlist">
      <?php wp_list_comments(); ?>
    </ol>
  <?php endif; ?>
  <?php comment_form(); ?>
</aside>
````

## Plantilla de busqueda

__search.php__

````php
<?php get_header(); ?>
<div class="Content-container">
  <main class="Main">
    <div class="Search-results">
      <h3><?php  _e( 'Resultados para la búsqueda:', 'mawt' ); ?></h3>
      <mark><?php echo get_search_query(); ?></mark>
    </div>
    <?php
      if ( have_posts() ): while ( have_posts() ): the_post();
        get_template_part( 'template-parts/content-search' );
      endwhile; else:
        get_template_part( 'template-parts/content-none' );
      endif;
    ?>
  </main>
  <?php
    get_template_part( 'template-parts/pagination' );
    get_sidebar();
  ?>
</div>
<?php get_footer(); ?>
````

__content-search.php__

````html
<figure class="PostCard">
  <?php the_post_thumbnail(); ?>
  <figcaption>
    <h2>
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
    <?php the_excerpt(); ?>
  </figcaption>
</figure>
````

Pero que ocurre cuando el usuario __busca por categorias, autor, etiquetas...__ Para ello tenemos la plantilla del sistema __archive.php__

__archive.php__

Aqui preguntamos si es categoria, si es etiqueta;

+ is_category();
+ is_tag();

__single_term_title();__ nos devuelve el termino de busqueda independientemente si es categoria o etiqueta.


Y por último mostramos los resultados

````html
<?php
      if ( have_posts() ): while ( have_posts() ): the_post();
        get_template_part( 'template-parts/content-main' );
      endwhile; else:
        get_template_part( 'template-parts/content-none' );
      endif;
    ?>
  </main>
  <?php
    get_template_part( 'template-parts/pagination' );
    get_sidebar();
  ?>
````

Si no hay resultado mostramos `get_template_part( 'template-parts/content-none' );`

````html
<?php get_header(); ?>
<div class="Content-container">
  <main class="Main">
    <?php
      if ( is_category() ):
        $term_title = __('Resultados para la categoría:', 'mawt');
      endif;

      if ( is_tag() ):
        $term_title = __('Resultados para la etiqueta:', 'mawt');
      endif;
    ?>
    <div class="TermsResults">
      <h3><?php echo $term_title; ?></h3>
      <mark><?php single_term_title(); ?></mark>
    <div>
    <?php
      if ( have_posts() ): while ( have_posts() ): the_post();
        get_template_part( 'template-parts/content-main' );
      endwhile; else:
        get_template_part( 'template-parts/content-none' );
      endif;
    ?>
  </main>
  <?php
    get_template_part( 'template-parts/pagination' );
    get_sidebar();
  ?>
</div>
<?php get_footer(); ?>
````

## Plantilla autor y error404

__404.php__

__<div class="Content-container Page FullWidth">__ mostramos la página a tamaño completo.

````html
<?php get_header(); ?>
<div class="Content-container Page FullWidth">
  <main class="Main">
    <?php get_template_part( 'template-parts/content-none' ); ?>
  </main>
</div>
<?php get_footer(); ?>
````


__author.php__

LLamamos a __get_template_part( 'template-parts/content-author' );__

````html
<?php get_header(); ?>
<div class="Content-container">
  <main class="Main">
    <?php
      get_template_part( 'template-parts/content-author' );
      if ( have_posts() ): while ( have_posts() ): the_post();
        get_template_part( 'template-parts/content-search' );
      endwhile; else:
        get_template_part( 'template-parts/content-none' );
      endif;
    ?>
  </main>
  <?php
    get_template_part( 'template-parts/pagination' );
    get_sidebar();
  ?>
</div>
<?php get_footer(); ?>
````

__get_template_part( 'template-parts/pagination' );__ ¿Porqué llamamos a la paginación? Por que vamos a mostrar las entradas del autor.

Plantilla del autor

__content-author.php__

````html
<aside class="Author">
  <h3><?php _e('Información del Autor:', 'mawt'); ?></h3>
  <div class="Author-info">
    <figure>
      <?php echo get_avatar( get_the_author_id(), 500 ); ?>
    </figure>
    <ul>
      <li>
        <i class="fas fa-user-circle"></i>
        <?php the_author(); ?>
      </li>
      <li>
        <i class="fas fa-male"></i>
        <?php echo get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name'); ?>
      </li>
      <li>
        <i class="fas fa-envelope"></i>
        <?php echo get_the_author_meta('user_email'); ?>
      </li>
      <li>
        <i class="fas fa-sitemap"></i>
        <a href="<?php echo get_the_author_meta('user_url'); ?>" target="_blank">
          <?php echo get_the_author_meta('user_url'); ?>
        </a>
      </li>
      <li>
        <i class="fas fa-calendar"></i>
        <?php echo get_the_author_meta('user_registered'); ?>
      </li>
      <li>
        <i class="fas fa-key"></i>
        <?php echo get_the_author_meta('roles')[0]; ?>
      </li>
      <li>
        <i class="fas fa-address-book"></i>
        <?php echo get_the_author_meta('description'); ?>
      </li>
      <li>
        <?php echo get_the_author_posts(); ?>
        <i class="fas fa-newspaper"></i>
      </li>
      <li>
        <a href="<?php echo get_the_author_meta('facebook'); ?>" target="_blank">
          <i class="fab fa-facebook"></i>
        </a>
      </li>
      <li>
        <a href="<?php echo get_the_author_meta('twitter'); ?>" target="_blank">
          <i class="fab fa-twitter"></i>
        </a>
      </li>
    </ul>
  </div>
</aside>
````