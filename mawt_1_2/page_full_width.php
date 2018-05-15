<?php /*Template name: Página de ancho completo*/?>
<!-- Con el comentario en php Template name podemos establecer una plantilla en el dashboard que una página
por ejemplo sin sidebar -->
<?php get_header();?>
<?php
//Ejecutamos el loop sin el if, solo mostramos la entrada no todas las entradas
while(have_posts()):the_post();
    ?>
    <section>
        <h1><?php the_title() ?></h1>
        <p><?php the_content();?></p>
    </section>
<?php endwhile;?>

<?php get_footer();?>
