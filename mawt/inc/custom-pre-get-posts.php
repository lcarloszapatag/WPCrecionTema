<?php
//Nombre de nuestra función mawt_show_post_types_in_loop
if ( !function_exists( 'mawt_show_post_types_in_loop' ) ):
  function mawt_show_post_types_in_loop ( $query ) {
    // que no sea el admin y sea el query principal
    if ( !is_admin() && $query->is_main_query() ):
      //Por defecto vamos a mostrar 'post','page' y 'cuidados' que es el slug de nuestro tipo de post (custom post type que hemos dado de alta)
      $query->set( 'post_type', array( 'post', 'page', 'cuidados' ) );
    endif;
  }
endif;

add_action( 'pre_get_posts', 'mawt_show_post_types_in_loop' );
?>
