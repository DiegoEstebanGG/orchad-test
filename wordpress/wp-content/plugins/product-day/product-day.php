<?php
/*
Plugin Name: Product Of The Day
Description: Create products to put them in the home
Version: 1.0
Author: Diego Gutierrez
*/

function create_product_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'products';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        summary text NOT NULL,
        image_url text NOT NULL,
        is_product_of_the_day boolean DEFAULT 0,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

register_activation_hook(__FILE__, 'create_product_table');

function product_menu() {
    add_menu_page(
        'Products', 
        'Products', 
        'manage_options', 
        'product-management', 
        'product_management_page',
        'dashicons-products', 
        20
    );
}
add_action('admin_menu', 'product_menu');

function product_management_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'products';

    // Verificar si el formulario fue enviado para agregar/editar un producto
    if (isset($_POST['action'])) {
        $name = sanitize_text_field($_POST['product_name']);
        $summary = sanitize_textarea_field($_POST['product_summary']);
        $image_url = esc_url_raw($_POST['product_image']);

        if ($_POST['action'] == 'add') {
            $wpdb->insert($table_name, array(
                'name' => $name,
                'summary' => $summary,
                'image_url' => $image_url, // por defecto no es destacado
            ));
        } elseif ($_POST['action'] == 'edit') {
            $wpdb->update($table_name, array(
                'name' => $name,
                'summary' => $summary,
                'image_url' => $image_url,
            ), array('id' => intval($_POST['product_id'])));
        }
    }

    // Verificar si se quiere eliminar un producto
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['product_id'])) {
        $product_id = intval($_GET['product_id']);
        $deleted = $wpdb->delete($table_name, array('id' => $product_id));
        echo $deleted;
    }

    // Verificar si se quiere destacar un producto
    if (isset($_GET['action']) && $_GET['action'] == 'feature' && isset($_GET['product_id'])) {
        // Verificar si ya hay 5 productos destacados
        $featured_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE is_featured = 1");

        if ($featured_count < 5) {
            $wpdb->update($table_name, array('is_featured' => 1), array('id' => intval($_GET['product_id'])));
        } else {
            echo "<div class='notice notice-error is-dismissible'><p>No puedes destacar más de 5 productos.</p></div>";
        }
    }

    // Obtener todos los productos
    $products = $wpdb->get_results("SELECT * FROM $table_name");

    // Pantalla de administración
    ?>
    <div class="wrap">
        <h1>Gestión de Productos</h1>

        <h2>Agregar/Editar Producto</h2>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th><label for="product_name">Nombre del Producto</label></th>
                    <td><input type="text" name="product_name" id="product_name" class="regular-text" required></td>
                </tr>
                <tr>
                    <th><label for="product_summary">Resumen del Producto</label></th>
                    <td><textarea name="product_summary" id="product_summary" class="large-text" rows="3" required></textarea></td>
                </tr>
                <tr>
                    <th><label for="product_image">URL de la Imagen del Producto</label></th>
                    <td><input type="url" name="product_image" id="product_image" class="regular-text" required></td>
                </tr>
            </table>
            <input type="hidden" name="action" value="add">
            <?php submit_button('Agregar Producto'); ?>
        </form>

        <h2>Lista de Productos</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Resumen</th>
                    <th>Imagen</th>
                    <th>Destacado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo esc_html($product->id); ?></td>
                        <td><?php echo esc_html($product->name); ?></td>
                        <td><?php echo esc_html($product->summary); ?></td>
                        <td><img src="<?php echo esc_url($product->image_url); ?>" width="50"></td>
                        <td><?php echo $product->is_featured ? 'Sí' : 'No'; ?></td>
                        <td>
                            <a href="?page=product_management&action=edit&product_id=<?php echo $product->id; ?>">Editar</a> | 
                            <a href="?page=product_management&action=delete&product_id=<?php echo $product->id; ?>" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a> | 
                            <a href="?page=product_management&action=feature&product_id=<?php echo $product->id; ?>">Destacar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

function mark_as_product_of_the_day($product_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'products';

    // Verificar cuántos productos están marcados como "Producto del día"
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE is_product_of_the_day = 1");

    if ($count < 5) {
        $wpdb->update(
            $table_name,
            array('is_product_of_the_day' => 1),
            array('id' => $product_id)
        );
    } else {
        // Mostrar un mensaje de error si ya hay 5 productos marcados
        echo 'No puedes marcar más de 5 productos como "Producto del día".';
    }
}

function display_product_of_the_day() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'products';

    // Seleccionar un producto aleatorio marcado como "Producto del día"
    $product = $wpdb->get_row("SELECT * FROM $table_name WHERE is_product_of_the_day = 1 ORDER BY RAND() LIMIT 1");

    if ($product) {
        echo '<div class="product-of-the-day">';
        echo '<h2>' . esc_html($product->name) . '</h2>';
        echo '<p>' . esc_html($product->summary) . '</p>';
        echo '<img src="' . esc_url($product->image_url) . '" alt="' . esc_attr($product->name) . '">';
        echo '<a href="#" class="cta">Ver más detalles</a>'; // Link opcional a la página de detalles del producto
        echo '</div>';
    }
}

add_shortcode('product_of_the_day', 'display_product_of_the_day');

function product_of_the_day_settings_menu() {
    add_options_page(
        'Producto del día', 
        'Producto del día', 
        'manage_options', 
        'product-of-the-day-settings', 
        'product_of_the_day_settings_page'
    );
}
add_action('admin_menu', 'product_of_the_day_settings_menu');

function product_of_the_day_settings_page() {
    ?>
    <div class="wrap">
        <h1>Configuración del Producto del Día</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('product_of_the_day_settings');
            do_settings_sections('product_of_the_day_settings');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Título del bloque</th>
                    <td><input type="text" name="product_of_the_day_title" value="<?php echo esc_attr(get_option('product_of_the_day_title')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function product_of_the_day_register_settings() {
    register_setting('product_of_the_day_settings', 'product_of_the_day_title');
}
add_action('admin_init', 'product_of_the_day_register_settings');

