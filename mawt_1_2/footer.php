</main>

<footer class="footer">

    <?php
        wp_nav_menu(array(
            'theme_location' => 'social_menu',
            'container' => 'nav', //Etiqueta que va contenida por defecto 'div'
            'container_class' => 'socialmedia' //Clase CSS. Varias clases container_class => 'Menu OtraClase OtraMas'
        ));
    ?>

    <div>
        <!-- Vamos a imprimer la fecha con código php y convertila en dinámica -->
        <small> &copy;<?php echo date('Y');?> por @manu</small>
    </div>
</footer>

<!-- Esta función es obligatoria -->
<!-- Tenemos que incluir esta función tambíen para el correcto funcinamiento -->
<?php wp_footer(); ?>

</body>
</html>