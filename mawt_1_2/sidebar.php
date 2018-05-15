<aside class="sidebar">
    <?php
        if(is_active_sidebar('main_sidebar')):
            dynamic_sidebar('main_sidebar');
        else:
    ?>
        <article class="widget">
            <h3>
                <?php
                //_e() es una función de traducción como __()
                //__() es get_loquesea
                //_e() es echo lo que sea
                    _e('Buscar','mawt');
                ?>
            </h3>
            <!-- Mostramos el formulario de busqueda si no tenemos activo ningún widgets-->
            <?php get_search_form(); ?>
        </article>
    <?php endif;?>
</aside>
