<! -- Este archivo no es convención de WP y hace referencia al contenido que cambia en cada sección -->
<article class="content">
    <h1>Creación de Temas</h1>
    <h2>Posts</h2>
    <!-- Si hay publicaciones quiero que me las muestres -->
    <!-- Miestras haya publicaciones ejecuta el post -->

    <?php if(have_posts()):while(have_posts()):the_post();?>

        <!-- Las funciones que comienzan por "get" devuelve un valor pero no imprimen -->
        <!-- Las que comienzan por "the_" imprimen contenido HTML -->

        <!-- TITULO -->
        <h2><?php the_title()?></h2>
        <?php //the_title('<h3>','</h3>') //Otra forma de mostrar el titulo?>
        <?php //echo get_the_title() //Y esta forma de mostrar el título requiere de echo ya que se está usando get?>
        <?php
            //Podemos expresar así el título pues nos devuelve solo el valor, no lo van a imprimir
            //$titulo = 'Titulo:'.get_the_title();
            //echo $titulo;
        ?>
        
        <!-- IMG destacada del POST -->
        <?php the_post_thumbnail();?>
        <!-- También podemos mostrar la imagen por medio de HTML con la función get -->
        <img src="<?php echo get_the_post_thumbnail_url();?>" alt="<?php the_title()?>">

        <!-- TITULO con ENLACE -->
        <!-- el formato the_permalink esta definido en los ajustes generales de WP -->
        <a href='<?php the_permalink();?>'><?php the_title();?></a>

        <!-- EXTRACTO DEL POST con las primeras palabras de las publicaciones -->
        <!-- Por defecto the_excerpt(); imprime el contenido en un párrafo por eso no hace falta cerrarlo entre etiquetas <p> -->
        <?php the_excerpt(); ?>

        <!-- CATEGORIAS -->
        <p><?php the_category(' &#8226; ');?></p>

        <!-- ETIQUETAS -->
        <p><?php the_tags();?></p>

        <!-- TIEMPO -->
        <small><?php the_time('d-M-Y');?></small>

        <!-- Podemos coger el formato de fecha desde las opciones generales
             Esta manera es la más optima -->

        <small><?php the_time(get_option('date_format'));?></small>

        <!-- AUTOR -->
           <?php //the_author() ?>
        <!-- Esta función imprime el autor y lo encierra a un enlace que nos lleva a la página del autor -->
        <p><?php the_author_posts_link();?></p>

        <!-- CONTENIDO DEL POST - La comentamos porque ya se muestra en el archivo single.php
        <article class="the-content">
            <?php //the_content();?>
        </article>
        <hr>
        -->
    <!-- Si no hay publicaciones ... -->
    <?php endwhile;else:?>
        <p>NO existe publicación</p>
    <?php endif;?>
</article>

<!-- PAGINACION -->
<section class="Pagination">
    <?php previous_post_link();?>
    <!-- No se imprime directamente hace falta un echo -->
    <?php echo paginate_links();?>
    <?php next_post_link();?>
    <br>
    <!-- Arreglo en paginate_links -->
    <?php echo paginate_links(array(
            'prev_text' => '<span>Anterior</span>',
            'next_text' => '<span>Previo</span>'
    ));?>
</section>