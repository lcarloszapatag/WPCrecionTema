# Creación de temas en Wordpress IV
## Planificación del tema
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





