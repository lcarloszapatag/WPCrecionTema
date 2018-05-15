<!--Plantilla o código de nuestros comentarios-->
<aside class="comments other">
    <ol>
        <?php
            wp_list_comments();
        ?>
    </ol>
    <!-- formulario de comentarios -->
    <?php
        comment_form();
    ?>
</aside>