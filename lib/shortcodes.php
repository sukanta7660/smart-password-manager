<?php

function subscribe_link ($attrs, $content = '') :string {
    global $wpdb;
    $attrs = shortcode_atts([
        'title' => 'Facebook',
        'number_of_posts' => 10,
        'post_type' => 'post'
    ], $attrs);

    ob_start();

    $args = [
        'post_type' => $attrs['post_type'],
        'posts_per_page' => $attrs['number_of_posts']
    ];

    $folderTable = $wpdb->prefix . 'folders';

    $folderSql = "SELECT * FROM $folderTable";

    $folders = $wpdb->get_results($folderSql);

    $posts = get_posts($args);

    foreach ($posts as $post) {
        echo '<h2>Post Title: ' . $post->post_title . '</h2>';
        echo '<h5>Post Type: ' . $post->post_type . '</h5>';
        echo '<h5>Category: ' . $post->post_category[0] . '</h5>';
        echo '<p>Content: ' . $post->post_content . '</p> <br>';
        echo get_the_post_thumbnail($post->ID);
    }

    echo "<br> <hr>";

    foreach ($folders as $folder) {
        echo '<h4>Name: ' . $folder->name . '</h4>';
    }

    echo 'Title:' . $attrs['title'];
    echo 'No of Post:' . $attrs['number_of_posts'];

    return ob_get_clean();
}

function page_header() {
    ob_start();

    ?>
    <header>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </header>
    <style>

    </style>

    <section class="logo-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-12 text-center header-content">
                    <img src="" alt="">
                    <h1>Password Vault</h1>
                </div>
            </div>
        </div>
    </section>
    <?php

    return ob_get_clean();
}

add_shortcode('subscribe', 'subscribe_link');
add_shortcode('page_header', 'page_header');