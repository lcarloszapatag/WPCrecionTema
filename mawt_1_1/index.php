<?php
get_header();

if(is_home()){ //Nos muestra si estamos en el home
    echo '<mark>Estoy en el home</mark>';

} else if(is_category('css')){ //Solo para categorias del tipo 'css'
    echo '<mark> Estoy mostrando resultados de categoria css </mark>';
} else if(is_category()){ //Solo para todas las categorias
    echo '<mark> Estoy mostrando resultados de categoria </mark>';
} else if(is_tag()){ //Solo para todas las etiquetas
    echo '<mark> Estoy mostrando resultados de etiquetas </mark>';
} else if(is_page()){ //Solo para una página
    echo '<mark> Estoy mostrando resultados para una página </mark>';
} else if(is_single()){ //Solo para una entrada
    echo '<mark> Estoy mostrando resultados para una entrada</mark>';
}else if(is_author()){ //Solo para autor
    echo '<mark> Estoy mostrando resultados para autores</mark>';
}else if(is_search()){ //Solo para busquedas
    echo '<mark> Estoy mostrando resultados para busqueda</mark>';
}else if(is_404()){ //Solo para error 404
    echo '<mark> Estoy mostrando resultados para error 404</mark>';
}
//Como content.php no es una convención de WP usaremos la función get_template_part()
get_template_part('content');
get_sidebar();
get_footer();




