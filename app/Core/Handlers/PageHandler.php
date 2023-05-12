<?php

namespace SmartPasswordManager\Core\Handlers;

class PageHandler
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'addMenus']);
    }

    public function mainMenus()
    {
        return [
            'smart_password_manager' => [
                'page_title' => 'Smart Password Manager',
                'menu_title' => 'SPM',
                'capability' => 'manage_options',
                'function'   => [$this, 'pluginIndex'],
                'icon_url'   => 'dashicons-vault',
                'priority'   => 10
            ]
        ];
    }

    public function subMenus()
    {
        return [
            'smart_password_manager#/folders' => [
                'parent_slug' => 'smart_password_manager',
                'page_title' => 'Folder',
                'menu_title' => 'Folder',
                'capability' => 'manage_options',
                'function'   => [$this, 'pluginIndex'],
            ],
            'smart_password_manager#/credentials' => [
                'parent_slug' => 'smart_password_manager',
                'page_title' => 'Credential',
                'menu_title' => 'Credential',
                'capability' => 'manage_options',
                'function'   => [$this, 'pluginIndex'],
            ],
            'smart_password_manager#/password' => [
                'parent_slug' => 'smart_password_manager',
                'page_title' => 'Password Generator',
                'menu_title' => 'Password',
                'capability' => 'manage_options',
                'function'   => [$this, 'pluginIndex'],
            ]
        ];
    }

    public function pluginIndex()
    {
        echo "<div id='app'></div>";
        wp_enqueue_style('customStyle', plugins_url('../../../public/css/custom.css', __FILE__ ));
        wp_enqueue_script('mainScript', plugins_url('../../../public/js/main.js', __FILE__ ));
        wp_localize_script( 'mainScript', 'ajax_object', ['ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ] );
    }

    public function addMenus()
    {
        foreach ($this->mainMenus() as $menuSlug => $menu) {
            add_menu_page(
                $menu['page_title'],
                $menu['menu_title'],
                $menu['capability'],
                $menuSlug,
                $menu['function'],
                $menu['icon_url'],
                $menu['priority']
            );
        }

        foreach ($this->subMenus() as $subMenuSlug => $subMenu) {
            add_submenu_page(
                $subMenu['parent_slug'],
                $subMenu['page_title'],
                $subMenu['menu_title'],
                'manage_options',
                $subMenuSlug,
                $subMenu['function'],
            );
        }
    }

}