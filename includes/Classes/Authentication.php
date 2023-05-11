<?php

namespace Classes;

class Authentication
{
    public function logout () {
        return wp_logout();
    }
}