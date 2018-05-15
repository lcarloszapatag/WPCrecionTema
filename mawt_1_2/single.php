<!-- Cuando WP detecta que el front-end muestra una entrada usa
el archivo single.php -->
<?php get_header();?>
<?php
    //Ejecutamos el loop sin el if, solo mostramos la entrada no todas las entradas
    while(have_posts()):the_post();
?>
    <section>
        <h1><?php the_title() ?></h1>
        <p><?php the_content();?></p>
    </section>

    <!-- Función de comentarios para llamar a la plantilla que contenie los comentarios -->
    <?php comments_template();?>


<?php endwhile;?>


<?php get_sidebar();?>
<?php get_footer();?>
