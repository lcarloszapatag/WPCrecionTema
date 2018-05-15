<!doctype html>
<!-- Recuperamos de WP las funciones que vamos a ir necesitando para nuestra página web -->
<html <?php language_attributes();?>>
<head>

    <!-- Recuperamos valores generales en este caso 'charset' para que nos traiga el juego de caracteres necesario -->

    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Título recuperado de WP -->

    <title><?php wp_title('|',true,'right');?></title>

    <!-- Esta función es obligatoria -->
    <!-- Tenemos que invocar esta función. Esta función nos permite inyectar todo lo que hagamos en nuestro function.php -->

    <?php wp_head();?>

</head>
<body>
<header class="header">
    <div class="logo"><a href='<?php echo esc_url(home_url('/'));
                                    //Nos devuelve el path desde el dominio principal hasta la ruta que nosotros queramos
                                    //usamos esc_url() para evitar inyección HTML
                                    ?>'>Logo</a></div>
    <!-- Vamos a cargar el menu, si no existe cargará el esquema de página -->
    <?php

        if(has_nav_menu('main_menu')):
            wp_nav_menu(array(
                'theme_location' => 'main_menu',
                'container' => 'nav', //Etiqueta que va contenida por defecto 'div'
                'container_class' => 'Menu' //Clase CSS. Varias clases container_class => 'Menu OtraClase OtraMas'
            ));
        else:
    ?>
        <nav class="menu">
            <ul>
                <!-- Vamos a mostrar un menu con todas las páginas disponibles que tenemos dadas de alta en wordpress -->
                <!-- Le pasamos el argumento 'title_li' para eliminar la palabra "Páginas" -->
                <?php
                    wp_list_pages('title_li');
                ?>
            </ul>
        </nav>
    <?php endif; ?>

</header>
<!-- Para no duplicar la etiqueta main de apertura -->
<main class="main">