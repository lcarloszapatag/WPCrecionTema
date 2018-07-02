# Creación de temas en Wordpress IV
## 1. Planificación del tema

### 1.1 Estructura básica de nuestra plantilla

Iniciamos nuestro proyecto de tema. Para ello creamos nuestra carpeta (nombredeltema) y se va a llamar __EDTheme__.
Para comenzar cualquier proyecto theme necesitamos 4 archivos básicos:

+ index.php (plantilla principal)
+ style.css 
+ functions.php
+ screenshot.png 

En __index.php__ podemos "pegar" una plantilla HTML para hacernos una idea de la maquetación definitiva. Esta puede ir en HTML para identificar los elementos que va a  manejar nuestra plantilla.

### 1.2 Volviendo dinámica la plantilla con PHP

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

### 1.3 Estructura de carpetas y archivos

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

### 1.4 Definiendo zonas comunes

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

### 1.5 Automatizar las tareas de desarrollo

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

### 1.6 Archivo gulpfile.babel.js

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

### 2.1 Variable global google fonts

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

### 2.2 Creación e invocación de menus y widgets

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

### 2.3 Creación e invocación de widgets

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

### 2.4 Configuración de soporte

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

### 2.5 Imprimiendo contenido básico

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

### 2.6 Soporte a plantillas para páginas

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

### 2.7 Plantilla de entrada

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

### 2.8 Plantilla de busqueda

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

### 2.9 Plantilla autor y error404

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

## 3. Integración de funciones avanzadas

### 3.1 Cabecera personalizable y logo

Todas las funcionalidades van a ir en nuestra carpeta __inc__.

+ __custom-admin.php__, este archivo nos va a servir para las modificaciones que vamos a realizar en el dashboard.
+ __custom-descrition.php__, meta información sobre el site.
+ __custom-excerpt.php__, para gestionar el texto del extracto de cada post.
+ __custom-login.php__, acceso al admin de nuestro WP.
+ __custom-header.php__, cabecera personalizable.
+ __customizer.php__, personalización del theme.

Ahora los damos de alta en nuestro __functions.php__

````php

require_once get_template_directory() . '/inc/custom-header.php';

require_once get_template_directory() . '/inc/customizer.php';

require_once get_template_directory() . '/inc/custom-excerpt.php';

require_once get_template_directory() . '/inc/custom-description.php';

require_once get_template_directory() . '/inc/custom-login.php';

require_once get_template_directory() . '/inc/custom-admin.php';

````

### 3.2 Cabecera personalizable y logo

__custom-header.php__

Esta función se va a ejecutar en el `after_setup_theme` 

Vamos a configurar el logo. Para ello podemos activar la capacidad para que el usuario cambie el logo.

+ `'add_theme_support( 'custom-logo', array (...)'`, Para activar la customización
+ 'height' => 100, 'width' => 100, Alto y ancho del logo
+ 'flex-height' => true ...etc Para que el usuario lo pueda adaptar en el dashboard.

```php
function mawt_custom_header () {
    //Activar logo configurable
  add_theme_support( 'custom-logo', array (
    'height' => 100,
    'width' => 100,
    'flex-height' => true,
    'flex-width' => true
  ) );
```

```php
<?php
function mawt_custom_header () {
    //Activar logo configurable
  add_theme_support( 'custom-logo', array (
    'height' => 100,
    'width' => 100,
    'flex-height' => true,
    'flex-width' => true
  ) );

  //Activar fondo configurable
  add_theme_support( 'custom-background', array (
    'default-color' => 'FFF',
    'default-image' => get_template_directory_uri() . '/img/background-image.png',
    'default-repeat' => 'repeat',
    'default-position-x' => '',
    'default-position-y' => '',
    'default-size' => '',
    'default-attachment' => 'fixed'
  ) );

  //Activa la actualización selectiva de widgets en el personalizador
  add_theme_support( 'customize-selective-refresh-widgets' );

  //Activar cabecera configurable
  //https://developer.wordpress.org/themes/functionality/custom-headers/
  add_theme_support( 'custom-header', apply_filters( 'mawt_custom_header_args', array (
    'default-image' => get_template_directory_uri() . '/img/header-image.jpg',
    'default-text-color' => '0096D9',
    'width' => 1200,
    'height' => 720,
    'flex-width' => true,
    'flex-height' => true,
    'video' => true,
    'wp-head-callback' => 'mawt_custom_header'
  )) );
}

add_action( 'after_setup_theme', 'mawt_custom_header' );

function mawt_wp_header_style () {
  $header_text_color = get_header_textcolor();
?>
  <style>
    .WP-Header-branding { color: #<?php echo esc_attr( $header_text_color ); ?>; }
  </style>
<?php } ?>

```

Para que los cambios surtan efecto debemos darle un destino a nuestros cambios. Como estamos modularizando todas las partes de nuestro código vamos a crear dos archivos template; __header-logo.php__ y __header-menu.php__

Por orden;

__header.php__

````html
    <header class="Header">
      <section class="Header-container">
        <?php
        get_template_part( 'template-parts/header-logo' );
        get_template_part( 'template-parts/header-menu' );
        ?>
      </section>
    </header>
````

Dentro de la carpeta template en  __header-logo.php__

```html
<div class="Logo">
<?php
  if ( has_custom_logo()  ):
    the_custom_logo( );
  else:
?>
    <a href="<?php echo esc_url( home_url( '/' )  );  ?>"><?php bloginfo( 'name' ); ?></a>
  <?php endif; ?>
</div>
```

### 3.3 Fondo configurable y actualización selectiva de widgets

__custom-header.php__ Podemos activar el fondo configurable

````php
  //Activar fondo configurable
  add_theme_support( 'custom-background', array (
    'default-color' => 'FFF',
    'default-image' => get_template_directory_uri() . '/img/background-image.png',
    'default-repeat' => 'repeat',
    'default-position-x' => '',
    'default-position-y' => '',
    'default-size' => '',
    'default-attachment' => 'fixed'
  ) );
````
La actualización selectiva de widgets consiste en activar los __lapicitos__ en especial para los __widgets__ que nos permiten modificar cada campo en donde se encuentre el _lapicito_

```php
//Activa la actualización selectiva de widgets en el personalizador
  add_theme_support( 'customize-selective-refresh-widgets' );

```

### 3.4 Cabecera multimedia

+ `'default-text-color' => '0096D9',` Color de texto
+ Dimensiones, 'width' => 1200 y 'height' => 720
+ flex para el recorte.
+ 'video' => true, WP permite introducir un pequeño video (mp4) o de youtube.
+ `'wp-head-callback' => 'mawt_custom_header'` Función callback 

Introducimos un estilo dinamico en nuestra cabecera

````html
function mawt_wp_header_style () {
  $header_text_color = get_header_textcolor();
?>
  <style>
    .WP-Header-branding { color: #<?php echo esc_attr( $header_text_color ); ?>; }
  </style>
<?php } ?>
````

Nos creamos un archivo __header-custom.php__

````html
<header class="WP-Header">
  <?php
    if ( has_custom_header()  ):
      the_custom_header_markup();
    endif;
  ?>
  <div class="WP-Header-branding">
    <h1 class="WP-Header-title">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <?php bloginfo( 'name' ); ?>
      </a>
    </h1>
    <p  class="WP-Header-description">
      <?php bloginfo( 'description' ); ?>
    </p>
  </div>
</header>
````

Este archivo lo vamos a invocar en nuestra cabecera __header.php__ al final

````php
 <?php
    if ( is_home() || is_front_page() ):
      get_template_part( 'template-parts/header-custom' );
    else:
      get_template_part( 'template-parts/hero-image' );
    endif;
  ?>
    <section class="Content">
````



````php
  //Activar cabecera configurable
  //https://developer.wordpress.org/themes/functionality/custom-headers/
  add_theme_support( 'custom-header', apply_filters( 'mawt_custom_header_args', array (
    'default-image' => get_template_directory_uri() . '/img/header-image.jpg',
    'default-text-color' => '0096D9',
    'width' => 1200,
    'height' => 720,
    'flex-width' => true,
    'flex-height' => true,
    'video' => true,
    'wp-head-callback' => 'mawt_custom_header'
  )) );
}

add_action( 'after_setup_theme', 'mawt_custom_header' );
````

### 3.5 Customizer, títulos y descripción
Vamos a activar el archivo __customizer.php__ Vamos a agregar este código en customizer.php para modificar en la vista previa los títulos y la descripción

__customizer.php__

+ el hook se llama `add_action( 'customize_register', 'mawt_customize_register' );`
+ la función es `mawt_customize_register($wp_customize)`
+ __$wp_customize__ es una variable de WP
+ `$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';` Aqui le decimos que obtenga el nombre del blog
+ `$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';` La descrición
+ `if ( isset( $wp_customize->selective_refresh ) ) {` Si el __selective_refresh__ está activo 
    + Activamos el __selecte_refresh__ en __custom-header.php__
    ````php
      //Activa la actualización selectiva de widgets en el personalizador
      add_theme_support( 'customize-selective-refresh-widgets' );
    ````
+ Si está activo __selective_refresh__ recibe un __arreglo__

````php
 $wp_customize->selective_refresh->add_partial( 'blogname', array(
      'selector' => '.WP-Header-title',
      'render_callback' => 'mawt_customize_blogname'
    ) );
````
+ __'selector' => '.WP-Header-title'__, Primero le tenemos que decir en que nombre del selector le podemos cambiar el título. 
    + En este caso solo en `.WP-Header-title` Que lo tenemos en __header-custom.php__
    ````html
      <header class="WP-Header">
        <?php
          if ( has_custom_header()  ):
            the_custom_header_markup();
          endif;
        ?>
        <div class="WP-Header-branding">
          <h1 class="WP-Header-title">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
              <?php bloginfo( 'name' ); ?>
            </a>
          </h1>
          <p  class="WP-Header-description">
            <?php bloginfo( 'description' ); ?>
          </p>
        </div>
      </header>
    ````
+ __'render_callback' => 'mawt_customize_blogname'__ función callback que se va a ejecutar
+ Lo mismo para la descripción
+ Ambas funciones devuelven título y descripción

````php
add_action( 'customize_register', 'mawt_customize_register' );

function mawt_customize_blogname () {
  bloginfo( 'name' );
}

function mawt_customize_blogdescription () {
  bloginfo( 'description' );
}
````    


````php
<?php
function mawt_customize_register( $wp_customize ) {
  $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

  if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'blogname', array(
      'selector' => '.WP-Header-title',
      'render_callback' => 'mawt_customize_blogname'
    ) );
    $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
      'selector' => '.WP-Header-description',
      'render_callback' => 'mawt_customize_blogdescription',
    ) );
  }
}

add_action( 'customize_register', 'mawt_customize_register' );

function mawt_customize_blogname () {
  bloginfo( 'name' );
}

function mawt_customize_blogdescription () {
  bloginfo( 'description' );
}
?>
````
### 3.6 Extracto de texto y carga de librerias CSS

__custom-excerpt.php__ módulo __inc__ que vamos a usar para modificar el extracto de texto de nuestro tema

Vamos a cargar dos librerias externas CSS para gestionar el texto de la descripción. 

En __funtions.php__ vamos a definir dos variables globales 



````php
global $font_awesome;
global $hamburgers;
````
+ __hamburgers CSS__ es una pequeña libreria que nos permite tener botones de hamburgesa animados. [Tasty CSS-animated hamburgers](https://jonsuh.com/hamburgers/)

Si queremos invocar CSS concretos para diferetnes partes de nuestra web lo ideal es declararlas en __variables globales__ y luego invocarlas en las diferentes partes que vayamos a necesitar.
Inicializamos nuestras variables con las rutas __cdnjs__. Si hubiera cambios solo tendriamos que realizarlos en un único punto de nuestro código.

````php
$font_awesome = 'https://use.fontawesome.com/releases/v5.0.13/css/all.css';
$hamburgers = 'https://cdnjs.cloudflare.com/ajax/libs/hamburgers/0.9.3/hamburgers.min.css';
````

Como lo vamos a usar en nuestro frontend las invocamos dentro de nuestra función;

````php
function mawt_scripts () {
    global $google_fonts;
    global $font_awesome;
    global $hamburgers;
````

Y ahora llamamos ambas librerias

````php
    wp_enqueue_style( 'font-awesome', $font_awesome, array(), '5.0.13', 'all' );
    wp_enqueue_style( 'hamburgers', $hamburgers, array(), '0.9.3', 'all' );
````

Y la agregamos como dependencia en nuestra hoja de estilos principal __style.css__

````php
    wp_enqueue_style( 'style', get_stylesheet_uri(), array('google-fonts', 'font-awesome', 'hamburgers', 'custom-properties'), '1.0.0', 'all' );
````

__custom-excerpt.php__ Solo imprime 55 palabras por defectos. Vamos a modificar dos cosas:

+ Las 55 palabras
+ Los puntos suspensivos del final

__Para modificar los puntos suspensivos del final__

+ function mawt_excerpt_more () 
+ Esta función va a retornar un enlace `return '<a href="'. get_permalink() .'">'. __(' leer más...', 'mawt') .'<i class="fab fa-readme"></i></a>';` 
    + `<a href="'. get_permalink() .'">` permalik que nos lleva al texto
    +  texto de dominio _leer más__ `__(' leer más...', 'mawt')` 
    + Luego imprimimos un icono de fontawesonme `'<i class="fab fa-readme"></i>`

__Modificar la longitud del extracto__

+ Función `function mawt_excerpt_length ()`
+ El filtro se llama `'excerpt_length'`
+ Solo tenemos que devolver el número de palabras que queremos. 

```php
function mawt_excerpt_length () {
  return 40;
}
```
 
````php
function mawt_excerpt_more () {
  return '<a href="'. get_permalink() .'">'. __(' leer más...', 'mawt') .'<i class="fab fa-readme"></i></a>';
}
````



````php
<?php
function mawt_excerpt_more () {
  return '<a href="'. get_permalink() .'">'. __(' leer más...', 'mawt') .'<i class="fab fa-readme"></i></a>';
}

add_filter('excerpt_more', 'mawt_excerpt_more');

function mawt_excerpt_length () {
  return 40;
}

add_filter('excerpt_length', 'mawt_excerpt_length');
?>
````

### 3.7 Descripción personalizada

Archivo __custom-description.php__ dentro de los módulos __inc__ Los __títulos de página__ cambian dinamicamente gracias a la función de WP;

````php
//Permite que los themes y plugins administren el título, si se activa, no debe usarse wp_title()
  add_theme_support( 'title-tag' );
````

Pero la descripción __no__ si no queremos instalar algún plugin de SEO debemos de definir esta funcionalidad como la que vamos a ver a continuación.

__custom-description.php__

+ `function mawt_custom_meta_description () ` Esta función no se va añadir a ningún hook o filtro. Solo contiene __conditional-tags__
    + Si estamos en home o es front_page inicializamos la variable `$description` a la descripción de nuestro blog
    ````php
       if ( is_home () || is_front_page() ) {
            $description = get_bloginfo('description');
          }
    ````
+ Cuando sea una busqueda de categorias o etiquetas `else if ( is_category() || is_tag() )` y devuelva `strip_tags( term_description() )` __strip_tags__ devuelve la descripción de las categorias sin código HTML.
+ Cuando se trate de una entrada o una página `( is_single() || is_page() )` obtengo el `htmlentities( get_the_excerpt(), ENT_HTML5, 'UTF-8' );` que es el extracto en formato UTF-8
+ Si estoy en la página del autor `( is_author() )` entonces `$description = get_the_author_meta('description');` la biografía de el. En el dashboard->usuarios-> el cambio biografía.
+ Si estoy en una busqueda `( is_search() )` imprimo el texto `__('Resultados de la búsqueda: ', 'mawt') . get_search_query();` con soporte para idioma y concateno a los terminos de busqueda.
+ Error 404 `( is_404() )` imprimimos `__('Error 404: No Encontrado. ', 'mawt') . get_bloginfo('description');` con soporte para idiomas y concateno con descripción del sitio.
+ Y para el resto imprimimos la descripción del blog `get_bloginfo('description');`

````php
<?php

  function mawt_custom_meta_description () {
    if ( is_home () || is_front_page() ) {
      $description = get_bloginfo('description');
    } else if ( is_category() || is_tag() ) {
      $description = strip_tags( term_description() );
    } else if ( is_single() || is_page() ) {
      the_post();
      $description = htmlentities( get_the_excerpt(), ENT_HTML5, 'UTF-8' );
      rewind_posts();
    } else if ( is_author() ) {
      $description = get_the_author_meta('description');
    } else if ( is_search() ) {
      $description = __('Resultados de la búsqueda: ', 'mawt') . get_search_query();
    } else if ( is_404() ) {
      $description = __('Error 404: No Encontrado. ', 'mawt') . get_bloginfo('description');
    } else {
      $description = get_bloginfo('description');
    }

    echo $description;
  }

?>
````

Ahora tenemos que hacer que nuestra función `mawt_custom_meta_description ()` Se ejecute en nuestra etiqueta meta dentro de la cabecera maestra __header.php__
`<meta name="description" content="<?php mawt_custom_meta_description(); ?>">`

__header.php__

````html
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="<?php mawt_custom_meta_description(); ?>">
````

### 3.8 Configurando página de inicio (Página de login)

Para configurar nuestra página de login lo primero que tenemos que hacer es crear una función que cargue los __scripts__ que van a actuar en nuestro _login_
En __functions.php__ definimos nuestro módulo llamado __custom-login.php__

__custom-login.php__ [Customizing the Login Form](https://codex.wordpress.org/Customizing_the_Login_Form)

Registramos nuestros script CSS y JS en `function mawt_login_scripts ()`

+ custom_properties.css __no lo vamos a trabajar con SASS__ sass solo lo dejamos para style.css que es nuestro punto de entrada en el front-end
+ login_page.css lo mismo que custom_properties.css __no se trabaja con sass__

Y los JS

+ jquery
+ login-page-js

Con esta función le decimos que el logo del sitio redireccione a la página inicial de nuestro sitio.
````php
function mawt_login_logo_url () {
  return home_url();
}
````

Con esta función al poner el ratón sobre el logo nos muestra la descripción de nuestro sitio web

````php
function mawt_login_logo_url_title() {
  return get_bloginfo( 'title' ) . ' | ' .  get_bloginfo( 'description' );
}
````


````php
<?php
//https://codex.wordpress.org/Customizing_the_Login_Form
function mawt_login_scripts () {
  wp_enqueue_style( 'custom-properties', get_stylesheet_directory_uri() . '/css/custom_properties.css', array(), '1.0.0', 'all' );
  wp_enqueue_style( 'login-page-css', get_template_directory_uri() . '/css/login_page.css', array('custom-properties'), '1.0.0', 'all' );

  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'login-page-js', get_template_directory_uri() . '/js/login_page.js', array('jquery'), '1.0.0', true );
}

add_action( 'login_enqueue_scripts', 'mawt_login_scripts' );

function mawt_login_logo_url () {
  return home_url();
}

add_filter( 'login_headerurl', 'mawt_login_logo_url' );

function mawt_login_logo_url_title() {
  return get_bloginfo( 'title' ) . ' | ' .  get_bloginfo( 'description' );
}

add_filter( 'login_headertitle', 'mawt_login_logo_url_title' );
?>
````

Las hojas de estilo CSS las tenemos que cargar tambien como dependencias de nuestra hoja de estilos principal.

__functions.php__

Dentro de `function mawt_scripts ()`

````php
    wp_enqueue_style( 'custom-properties', get_template_directory_uri() . '/css/custom_properties.css', array('google-fonts'), '1.0.0', 'all' );
    wp_enqueue_style( 'style', get_stylesheet_uri(), array('google-fonts', 'font-awesome', 'hamburgers', 'custom-properties'), '1.0.0', 'all' );
````

### 3.9 Custom admin

__custom-admin.php__ como __inc__ de _functions.php_ Vamos a customizar la fuente que vemos en las entradas de nuestro blog y que sea la misma en el editor del visual del dashboard.

+ `global $google_fonts;` Llamamos a nuestra variable global y este es un ejemplo muy bueno de porqué usamos variables globales. Si quisieramos cambiar de fuente solo lo tendriamos que hacer en un punto del código.
+  `add_editor_style( $google_fonts );`, Para el administrador.
+  `add_editor_style( 'css/custom_properties.css' );`, Variables CSS.
+  `add_editor_style( 'css/custom_editor_style.css' );`, Hoja de estilo definitiva.

````php
<?php
//https://codex.wordpress.org/Dashboard_Widgets_API
//https://codex.wordpress.org/Plugin_API/Admin_Screen_Reference
//https://codex.wordpress.org/Administration_Screens
//https://codex.wordpress.org/Adding_Administration_Menus

function mawt_add_editor_styles () {
  global $google_fonts;
  add_editor_style( $google_fonts );
  add_editor_style( 'css/custom_properties.css' );
  add_editor_style( 'css/custom_editor_style.css' );
}

add_action( 'admin_init', 'mawt_add_editor_styles' );

function mawt_user_contactmethods ($data_user) {
  $data_user['facebook']=__('Facebook', 'mawt');
  $data_user['twitter']=__('Twitter', 'mawt');

  return $data_user;
}

add_filter( 'user_contactmethods', 'mawt_user_contactmethods' );
?>
````

## 4. Maquetación y programación

## 4.1 Creando archivos finales

__SASS__

La ventaja que nos brinda sass es que podemos modularizar nuestra maquetación y luego ser compiladas en un único archivo principal de estilos. En este caso __style.scss__.
Los módulos que vamos a crear son;

+ _author.scss
+ _footer.scss
+ _grid_layout.scss
+ _header.scss.scss
+ ...etc es decir, todas aquellas partes que sean supceptibles de ser modulares.

Cuando usamos selectores recomendados por WP usamos una hoja __de estilo normal__, no scss.

__JS__

+ index.js
+ login_page.js, para controlar el login
+ toogle_nav.js, menu de navegación como módulo de js6


## 4.2 Preparando nuestro template

Lo primero que vamos a revisar nuestro contenido de plantillas.

La primera plantilla que llamamos es __content.php__ y vamos comprobando las plantillas que llama a su vez __content.php__.
En este proceso de desarrollo vamos a ir _empaquetando_ y comprobando las plantillas y los partes que encapsulamos en plantillas.

Una vez comprobado. Vamos a __importar los estilos dentro de style.scss__.

Es muy importante que las importanciones __guarden el orden en le que se las va a invocar__

````scss
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

@import 'reset';
@import 'header';
@import 'menu';
@import 'grid_layout';
@import 'footer';
@import 'widgets';
@import 'search_form';
@import 'social_menu';
@import 'post';
@import 'pagination';
@import 'comments.css';
@import 'not_found';
@import 'author';
@import 'wp_custom_header';
@import 'hero_image';

````

__variables en el custom_properties.css__

Las custom_properties esta definida como una hoja que carga WP y por eso no tiene sentido invocarla en le archivo sass. Tiene que ser así para que WP la reconozca nada más cargue WP.

````css
/* ********** Custom Properties ********** */
:root {
  --main-font: 'Raleway';
  --alternate-font: sans-serif;
  --font-size: 16px;
  --line-height: 1.6;

  --main-color: #0096D9;
  --main-modal-color: rgba(0, 150, 217, .75);
  --second-color: #171226;
  --second-modal-color: rgba(23, 18, 38, .75);

  --bg-color: #FFF;
  --bg-modal-color: rgba(0, 0, 0, .5);
  --bg-alternate-color: #F3F3F3;
  --border-color: #DDD;

  --text-color: #333;
  --title-color: var(--second-color);

  --link-color: var(--main-color);
  --link-hover-color: var(--second-color);

  --container-width: 1200px;
  --header-height: 4rem;
}
````

### 4.4 Definiendo contenidos finales I

__content-single.php__

+ `<?php _e('Formato de Entrada: ', 'mawt'); echo ( get_post_format( $post ) ) ? get_post_format( $post ) : 'standard'; ?>` Obtenemos el formato de la entrada, evaluamos si el postformat parte verdadera imprimo el tipo de formato y si no imprimimos la palabra _standard_.
Es decir, dependiendo del tipo de formato de entrada, este lo va a imprimir en la entrada, video, galeria de imagenes...etc.
+ `get_post_format( $post )` devuelve _cadena vacia_ cuando es un formato __estandar__
+ Por medio de la función __get_post_format( $post )__ podemos definir el formato según el tipo de post

````html
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

### 4.5 Definiendo contenidos finales II

__content-search.php__

+ Entre etiquetas _figure_ pues vamos a mostrar una busqueda con la imagen destacada del post.

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

__archive.php__

Para busqueda de categorias y/o etiquetas.

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

+ template-part que va a cargar una _hero image_ del post. Para ello tenemos que hacer una validación en __header.php__

Hacemos una validación en __header.php__

+ si es home o front page carga header-custom `get_template_part( 'template-parts/header-custom' );
+ Para todo lo demás `get_template_part( 'template-parts/hero-image' );`

````php
<?php
    if ( is_home() || is_front_page() ):
      get_template_part( 'template-parts/header-custom' );
    else:
      get_template_part( 'template-parts/hero-image' );
    endif;
  ?>
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

__hero-image.php__

Vamos a tener una cabecera html. 
Las __variables CSS se pueden pasar por medio del atributo html style__. Le vamos a pasar:
+ `--bg-url: url(<?php echo $hero_image; ?>);` Con el valor de la imagen destacada.
+ `--bg-attach: fixed;` propiedad CSS
+ ` --bg-size: cover; --bg-x: center; --bg-y: center;` conver y centrado X e Y.

````html
<header class="HeroImage" style="
      --bg-url: url(<?php echo $hero_image; ?>);
      --bg-attach: fixed;
      --bg-size: cover;
      --bg-x: center;
      --bg-y: center;
    ">
````
+ Luego imprimimos la variable __$título__ y __$subtítulo__.

````html
  <div>
    <h1><?php echo $title; ?></h1>
    <p><?php echo $subtitle; ?></p>
  </div>
````

¿De dónde sacamos las variables __$titulo $subtitulo y $hero_image__?

+ `is_single()` Si es una entrada
+ `is_page()` Si es una página
+ ...etc

Luego imprimimos las variables según cada caso.

````php

<?php
if ( is_single() ):
  $title = get_the_title();
  $subtitle = get_avatar( get_the_author_id(), 100) . get_the_author();
  $hero_image = get_the_post_thumbnail_url();
elseif ( is_page() ):
  $title = get_the_title();
  $subtitle = null;
  $hero_image = get_the_post_thumbnail_url();
elseif ( is_category() ):
  /* var_dump(get_the_category()); */
  $current_cat = get_the_category();
  $title =  single_cat_title('', false);
  $subtitle = category_description( $current_cat[0] );
  $hero_image = get_header_image();
elseif ( is_tag() ):
  $current_tag = get_the_tags();
  $title =  single_cat_title('', false);
  $subtitle = tag_description( $current_tag[0] );
  $hero_image = get_header_image();
elseif ( is_author() ):
  $title =  get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name');
  $subtitle = get_the_author_posts() . ' publicaciones';
  $hero_image = get_avatar_url( get_the_author_id() );
elseif ( is_search() ):
  $title = get_search_query();
  $subtitle = __('Resultados de búsqueda', 'mawt');
  $hero_image = get_header_image();
elseif ( is_404() ):
  $title = __('Contenido No Encontrado', 'mawt');
  $subtitle = __('Error 404', 'mawt');
  $hero_image = get_header_image();
else:
  $title = get_bloginfo('name');
  $subtitle = get_bloginfo('description');
  $hero_image = get_header_image();
endif;
?>


<header class="HeroImage" style="
      --bg-url: url(<?php echo $hero_image; ?>);
      --bg-attach: fixed;
      --bg-size: cover;
      --bg-x: center;
      --bg-y: center;
    ">
  <div>
    <h1><?php echo $title; ?></h1>
    <p><?php echo $subtitle; ?></p>
  </div>
</header>

````

### 4.6 Definiendo contenidos finales III

Para modificar el formulario de busqueda por defecto de WP. Buscamos el archivo, que tiene que estar en la raiz. Creamos el archivo __searchform.php__

__searchform.php__

[Referencia SearchForm](https://developer.wordpress.org/reference/functions/get_search_form/)

````html
<?php //https://developer.wordpress.org/reference/functions/get_search_form/ ?>
<form role="search" method="get" class="Search" action="<?php echo home_url( '/' ); ?>">
  <input type="search" id="s" placeholder="<?php echo esc_attr_x( 'Buscar …', 'mawt' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Buscar:', 'mawt' ) ?>">
  <label for="s">
    <i class="fas fa-search"></i>
    <span class="screen-reader-text"><?php echo _x( 'Buscar:', 'mawt' ) ?></span>
  </label>
  <input type="submit" value="<?php echo esc_attr_x( 'Buscar', 'mawt' ) ?>">
</form>
````

__search.php__

````html
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
### 4.7 Estilos de cabecera

__header.scss__

+ contenedor del header

````scss
.Header {
  //Cabecera fija
  position: fixed;
  top: 0;
  left: 0;
  //z-index alto para que quede arriba
  z-index: 999;
  //Anchura 100%
  width: 100%;
  height: var(--header-height);
  line-height: var(--header-height);
  //color de fondo
  background-color: var(--second-color);

  //Contenedor Header-container
  &-container {
    //Posición relativa
    //La posición es relativa porque el LOGO y el Panel van a ir posicionados de manera absoluta
    position: relative;
    //Centrado
    margin: 0 auto;
    //Variable de máxima anchura
    max-width: var(--container-width);
  }
}
````

+ logo 

Nos encontramos la clase _.Logo_ en __header-logo.php__

````scss
.Logo {
  position: absolute;
  z-index: 999;

  & a {
    font-size: 2rem;
    //Quitamos la decoración del texto
    text-decoration: none;
    color: var(--main-color);
    transition: all .3s ease;

    &:hover { opacity: .75; }
  }
  //Si el logo es una imagen
  & img {
    //margen para que no se pegue a la cabecera
    padding: .25rem;
    //Le damos un ancho automático
    width: auto;
    //Altura igual que la cabecera
    height: var(--header-height);
  }
}
````

+ El menú principal lo vamos a cambiar por un boton de _hamburguesa_

__header-menu.php__

````html
<span class="hamburger-box">
            <span class="hamburger-inner"></span>
</span>
````

__header-menu.php__

Clase _.is-active_ Cuando Panel posee esa clase el panel vuelve a su lugar de origen. 
__¿Como la añadimos y la quitamos?__ Mediante un código JS

````javascript
const toggleNav = () => {
  //Guardamos el documento en D
  const d = document,
    //buscamos el elemento .Panel
    panel = d.querySelector('.Panel'),
    //y el elemento .Panel-btn
    panelBtn = d.querySelector('.Panel-btn')
  //Al click del boton
  panelBtn.addEventListener('click', e => {
    e.preventDefault()
    //Le añadimos/quitamos (es lo que hace toggle) la clase .is-active
    //Tanto a panelBtn como a Panel
    panelBtn.classList.toggle('is-active')
    panel.classList.toggle('is-active')
  })
}

// Exportamos la función toggleNav
export default toggleNav
````

Por último en __index.js__

```javascript
import toggleNav from './toggle_nav'
toggleNav()
```

La clase _.is-active_ también le sirve al menu de la hamburguesa para crear la animación.

`````scss
.Panel {
  position: fixed;
  //z-index menor a la cabecera
  z-index: 998;
  //Le ponemos los cuatro lados a 0 para que se estire
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  width: 100%;
  overflow-y: auto;
  background-color: var(--second-modal-color);
  
  //Estas transformaciones sirve para las versiones móviles. Ver desde que lado se visualiza el menu
  // Estas transformaciones son ejemplos ahora solo se ejecuta la última
  transition: transform .3s ease;
  /* De arriba */
  transform: translate(0, -100%);
  /* De abajo */
  transform: translate(0, 100%);
  /* De la izquierda */
  transform: translate(-100%, 0);
  /* De la derecha */
  transform: translate(100%, 0);

  // Cuando el Panel tenga una clase que se llame .is-active devolvemos el panel al origen a 0,0
  // Pero ¿Cómo agregamos y quitamos esa clase?
  &.is-active { transform: translate(0, 0); }

  &-btn {
    position: absolute;
    z-index: 999;
    top: -.5rem;
    right: 0;
  }
}

//Quitamos el focus de la hamburguesa
.hamburger {
  &:focus {
    outline: 0;
    border: 0;
  }
//Elementos de la hamburguesa como el color
  &-inner,
  &-inner:after,
  &-inner:before { background-color: var(--main-color);  }
}
`````

Esto ha sido la versión movil (mobil firts) Ahora vamos a la versión de escritorio.

`````scss
@media screen and (min-width: 64em) {
  //Flex -- ambos estarán en fila
  .Header-container { display: flex; }

  .Logo {
    position: static;
    width: 10%;
  }

  .Panel {
    position: static;
    width: 90%;
    display: flex;
    overflow-y: visible;
    background-color: transparent;
    //No necesitamos que se salga en la version desktoc
    transform: translate(0, 0);

    &-btn { display: none; }
  }
}

`````

## 4.8 Estilos al menu y footer

Primero version movil

````scss
.Menu {
  margin: 0  auto;
  //Igual al tamaño de la cabecera. En esta version el primer elemento del menu esta a la altura del logo. Por eso le damos ese padding-top con la misma altura que la cabecera. 
  padding-top: var(--header-height);
  //Centramos todos los elementos
  text-align: center;
  //Ul es flex pero en columna y le quitamos el estilo de lista
  & ul {
    display: flex;
    flex-direction: column;
    list-style: none;
  }

  & li { margin-left: 0; }

  & a {
    display: block;
    font-size: 1.5rem;
    text-decoration: none;
    color: var(--main-color);
    transition: all .3s ease;

    & a:hover {
      font-weight: bold;
      color: var(--bg-color);
      background-color: var(--main-color);
    }
  }
  
  
  //Version Desktoc

  @media screen and (min-width: 64em) {
    padding-top: 0;
    width: 100%;
    
    
    //Ahora le damos orientaion en fila y se repartan en space-evenly los list-items
    & ul:not(.sub-menu) {
      flex-direction: row;
      justify-content: space-evenly;
    }

    & a {
      padding: 0 .5rem;
      font-size: 1.5rem;
      border-top: medium solid transparent;

      &:hover {
        border-top: medium solid var(--bg-color);
        color: var(--bg-color);
        background-color: transparent;
      }
    }
  }
}
````

__submenu__

En versión movil le damos un tamaño a los enlaces que se encuentren en el submenu

````scss
/* WordPress Submenu Classes */
.sub-menu a { font-size: .85rem; }
````

En la versión extendida. Para que este inmediatamente debajo de su padre le aplicamos un posicionamiento __absoluto__

`````scss
@media screen and (min-width: 64em) {
  .sub-menu {
    position: absolute;
    top: var(--header-height);
    transition: all .3s ease-out;
    background-color: var(--second-modal-color);
    //Jugamos con la opacidad. Por defecto es 0 y no se puede ver pero...
    opacity: 0;
    visibility: hidden;

    & a {
      padding: 0 1rem;
      font-size: .85rem;
      text-align: left;
      border-top: medium solid transparent;
    }
  }

  .menu-item-has-children {
    position: relative;

    //... cuando hacemos hover de un elemento que sea sub-menu opacidad a 1 y se pueda ver.
    &:hover > .sub-menu {
      opacity: 1;
      visibility: visible;
    }
  }
}
`````

__footer.scss__

`````scss
.Footer {
  //Color de fondo
  background-color: var(--bg-alternate-color);

  //Mismas características que el contendor de header
  &-container {
    margin: 0 auto;
    padding: 1rem;
    //Dimensiones
    max-width: var(--container-width);
    min-height: var(--header-height);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;

    & > div { width: 100%; }
    //Versión Desktoc
    @media screen and (min-width: 64em) {
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
      text-align: left;
      
      & > div {
        width: 50%;
        //Ultimo div en el footer es el copy lo invierte y lo deja a la izquierda (flex)
        &:last-child { order: -1; }
      }
    }
  }
}
`````

## 4.9 Grid layout y widgets

El contenido principal y el contenido que tenemos en el lado.
Mobil Firts primero.

__grid_layout.scss__

````scss
.Content-container {
  margin: 0 auto;
  max-width: var(--container-width);
  display: grid;
  grid-template-columns: 100%;
  grid-template-rows: repeat(3, auto);
  //Tres areas main-para el contenido principal, features-para los comentarios y sidebar para el contenido lateral. 
  grid-template-areas: 'main'
                                    'features'
                                    'sidebar';
  grid-gap: 1rem;
}

//Definición de las áreas que hemos definido en Content-container
//Grid area - main
.Main { grid-area: main; }
//Grid area - sidebar
.Sidebar { grid-area: sidebar; }
//Paginacion y comentarios - features
.Pagination,
.Comments {
  grid-area: features;
  padding: 1rem;
  border: thin solid var(--border-color);
  background-color: var(--bg-alternate-color);
}


````

Versión extendida

`````scss
@media screen and (min-width: 64em) {
  .Content-container {
    margin: 1rem auto;
    grid-template-columns: 2fr 1fr;
    grid-template-rows: repeat(2, auto);
    //Le vamos a decir que sidebar ocupe la segunda columna y el main la primera celda de la primera columna y features (paginacion y comentarios) la segunda.  
    grid-template-areas: 'main sidebar'
                                      'features sidebar';
  }
}
`````