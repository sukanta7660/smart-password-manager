<?php

function subscribe_link ($attrs, $title) :string {
    ob_start();

    $default = [
        'link' => '#',
        'title' => ''
    ];

    $attrs = shortcode_atts($default, $attrs);

    echo "Follow us on <a href='$attrs[link]'>$attrs[title]</a>";

    return ob_get_clean();
}

function page_header() {
    ob_start();

    ?>

    <section class="logo-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-12 text-center header-content">
                    <img src="../assets/img/logo.png" alt="">
                    <h1>Password Vault</h1>
                </div>
            </div>
        </div>
    </section>
    <?php

    return ob_get_clean();
}

function login_form() {
    ob_start();

    ?>

    <header>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    </header>
    <style>
        .back {
            background: #e2e2e2;
            width: 100%;
            position: absolute;
            top: 0;
            bottom: 0;
        }

        .div-center {
            width: 400px;
            height: 400px;
            background-color: #fff;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            max-width: 100%;
            max-height: 100%;
            overflow: auto;
            padding: 1em 2em;
            border-bottom: 2px solid #ccc;
            display: table;
        }

        div.content {
            display: table-cell;
            vertical-align: middle;
        }
    </style>

    <div class="back">


        <div class="div-center">


            <div class="content">


                <h3>Login</h3>
                <hr />
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <hr />
                    <button type="button" class="btn btn-link">Signup</button>
                    <button type="button" class="btn btn-link">Reset Password</button>

                </form>

            </div>


            </span>
        </div>

    <?php

    return ob_get_clean();
}

add_shortcode('subscribe', 'subscribe_link');
add_shortcode('page_header', 'page_header');
add_shortcode('login_form', 'login_form');