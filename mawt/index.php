<?php
get_header();
//Llamamos a loop-wp-query nuestro ejercicio de wp-query
get_template_part( 'loop-wp-query' );
get_template_part( 'content' );
get_sidebar();
get_footer();
?>
