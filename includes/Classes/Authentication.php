<?php

namespace Classes;

class Authentication
{
    // Login Functionality
    public function login()
    {
        $credentials = [
            'user_login' => $_POST['username'],
            'user_password' => $_POST['password'],
            'remember' => $_POST['remember']
        ];

        $response = wp_signon($credentials);

        if (is_wp_error($response)) {
            return wp_send_json(['message' => 'Invalid Credential'], 422);
        } else {
            return wp_send_json($response);
        }

    }

    //Logout Functionality
    public function logout () {
        return wp_logout();
    }
}