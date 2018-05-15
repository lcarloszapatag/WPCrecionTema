<?php
get_header();
//Como content.php no es una convención de WP usaremos la función get_template_part()
get_template_part('content');
get_sidebar();
get_footer();




