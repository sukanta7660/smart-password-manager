<?php

function getPageContainer () {
    ob_start();

    ?>
        <div id="user-platform">
        </div>
    <?php
    wp_enqueue_script('frontendJquery', 'https://code.jquery.com/jquery-3.6.4.min.js');
    wp_enqueue_style('frontendStyles', plugins_url('../public/css/frontend.css', __FILE__ ));
    wp_enqueue_script('frontendScripts', plugins_url('../public/frontend/main.js', __FILE__ ), [], false, true);
    wp_localize_script( 'frontendScripts', 'ajax_object', ['ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ] );


    echo ob_get_clean();
}

add_shortcode('platform_container', 'getPageContainer');