<?php

namespace SmartPasswordManager\Core\Handlers;

class ShortCodeHandler
{
    public function __construct()
    {
        add_shortcode('user_page_container', [$this, 'shortCodeInitialization']);
    }

    public function shortCodeInitialization()
    {
        ob_start();

        ?>
            <div id="user-platform"></div>
        <?php

        wp_enqueue_script('frontendJquery', 'https://code.jquery.com/jquery-3.6.4.min.js');
        wp_enqueue_style('frontendStyles', plugins_url('../../../public/css/frontend.css', __FILE__ ));
        wp_enqueue_script('frontendScripts', plugins_url('../../../public/frontend/main.js', __FILE__ ), [], false, true);
        wp_localize_script( 'frontendScripts', 'ajax_object', [
            'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234,
            'is_logged_in' => is_user_logged_in()
        ] );

        echo ob_get_clean();
    }
}