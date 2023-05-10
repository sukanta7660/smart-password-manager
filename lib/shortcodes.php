<?php

function getPageContainer () {
    ob_start();

    ?>
        <style>
            .wp-site-blocks {
                padding: 0 !important;
            }
            #user-platform {
                margin-block-start: 0 !important;
            }
        </style>
        <div id="user-platform"></div>
    <?php

    return ob_get_clean();
}

add_shortcode('platform_container', 'getPageContainer');