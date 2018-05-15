<! -- Este archivo no es convención de WP y hace referencia al contenido que cambia en cada sección -->
<article class="content">
    <!-- Si hay publicaciones quiero que me las muestres -->
    <!-- Miestras haya publicaciones ejecuta el post -->

    <?php if(have_posts()):while(have_posts()):the_post();?>

        <h2><a href='<?php the_permalink();?>'><?php the_title();?></a></h2>
        <img src="<?php echo get_the_post_thumbnail_url();?>" alt="<?php the_title()?>">
        <?php the_excerpt(); ?>

        <p><?php the_category(' &#8226; ');?></p>

        <p><?php the_tags();?></p>

        <small><?php the_time(get_option('date_format'));?></small>
        <p><?php the_author_posts_link();?></p>
        <hr>
    <?php endwhile;else:?>
        <p>NO existe publicación</p>
    <?php endif;?>
</article>

<!-- PAGINACION -->
<section class="pagination other">
    <!-- Arreglo en paginate_links -->
    <?php echo paginate_links(array(
            'prev_text' => '<span>Anterior</span>',
            'next_text' => '<span>Previo</span>'
    ));?>
</section>