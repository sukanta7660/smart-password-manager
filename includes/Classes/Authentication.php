<?php

namespace Classes;

class Authentication
{
    public function checkLogin () {
        return wp_send_json(is_user_logged_in());
    }
}