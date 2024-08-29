<?php
/*
Plugin Name: Dynamic Banner Menu
Description: Change banner background in function of the menu
Version: 1.0
Author: Diego Gutierrez
*/
function dynamic_banner_get_root() {
    if (is_page()) {
        // Obtener el objeto del menú asociado a la página actual
        $menu_items = wp_get_nav_menu_items('principal');

        if ($menu_items) {
            $current_page_id = get_the_ID();
            $ancestor_id = null;

            // Buscar en los elementos del menú
            foreach ($menu_items as $menu_item) {
                if ($menu_item->object_id == $current_page_id) {
                    // Si la página actual es un subelemento, encontrar el elemento raíz
                    $ancestor_id = $menu_item->menu_item_parent;
                    break;
                }
            }

            // Si se encuentra un ancestro, buscar el título de la raíz
            if ($ancestor_id) {
                foreach ($menu_items as $menu_item) {
                    if ($menu_item->ID == $ancestor_id) {
                        return $menu_item->title;
                    }
                }
            } else {
                // Si no hay ancestro, la página actual es raíz
                foreach ($menu_items as $menu_item) {
                    if ($menu_item->object_id == $current_page_id) {
                        return $menu_item->title;
                    }
                }
            }
        }
    }
    return '';
}

function dynamic_banner_display() {
    $root_title = dynamic_banner_get_root();

    if ($root_title === 'Root A') {
        echo '<div class="banner" style="background-image: url(\'' . plugin_dir_url(__FILE__) . 'images/Batman.jpg\'); height: 800px;"></div>';
    } elseif ($root_title === 'Root B') {
        echo '<div class="banner" style="background-image: url(\'' . plugin_dir_url(__FILE__) . 'images/Superman.jpg\'); height: 800px;"></div>';
    } else {
        echo '<div class="banner" style="background-image: url(\'' . plugin_dir_url(__FILE__) . 'images/default.jpg\'); height: 800px;"></div>';
    }
}

add_action('wp_head', 'dynamic_banner_display');
