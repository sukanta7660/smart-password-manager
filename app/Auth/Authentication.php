<?php

namespace SmartPasswordManager\Auth;

use SmartPasswordManager\Modules\Concern\Module;

class Authentication implements Module
{

    public function register()
    {
        add_action( 'wp_ajax_nopriv_login', [$this, 'login']);
        add_action( 'wp_ajax_nopriv_register', [$this, 'signup']);
        add_action( 'wp_ajax_logout', [$this, 'logout']);
    }

    public function login()
    {
        $credentials = [
            'user_login' => sanitize_text_field($_POST['username']),
            'user_password' => sanitize_text_field($_POST['password']),
            'remember' => rest_sanitize_boolean($_POST['remember'])
        ];

        $response = wp_signon($credentials);

        if (is_wp_error($response)) {
            return wp_send_json(['message' => 'Invalid Credential'], 422);
        } else {
            return wp_send_json($response);
        }

    }

    // Register Functionality
    public function signup()
    {
        $username = sanitize_text_field($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);

        var_dump($_POST);
        die();

    }

    //Logout Functionality
    public function logout () {
        return wp_logout();
    }
}