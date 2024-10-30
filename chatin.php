<?php

/**
 * Plugin Name: Chat-In Inc.
 * Description: Dale vida a tu empresa
 * Version: 1.0.0
 * Author: Chat-In Inc.
 * Author URI: http://chat-in.net
 * Requires at least: 4.0
 * Tested up to: 4.3
 *
 */

add_action('admin_menu', function() {
    add_options_page( 'Chat-In Opciones', 'Chat-In', 'manage_options', 'chat-in-opciones', 'cin_options');
});

// add_action('wp_footer', 'chatin',50);
add_action ( 'wp_enqueue_scripts', 'cin_js_code');

add_action( 'admin_init', function() {
    register_setting( 'chat-in-settings', 'idEmpresa' );
    register_setting( 'chat-in-settings', 'idFormNumber' );
});
add_shortcode( 'chatin-contact-form', 'cin_contact_form' );

function cin_js_code() {
  wp_enqueue_script( 'C-chat', 'https://cincosi.com/uploads/js/C-chat.js', array(), null, true );
  wp_enqueue_script( 'C-Chat-Tickets', 'https://cincosi.com/tickets/js/tickets.js', array(), null, true );
}

add_filter( 'script_loader_tag', 'cin_attr', 10, 3);

function cin_attr( $tag, $handle, $src ){
    if ( 'C-chat' === $handle ) {
        // add attributes
        $tag = '<script id="C-Chat" data-name="'.get_option('idEmpresa').'" src="' . esc_url( $src ) . '"></script>';
    }
    if ( 'C-Chat-Tickets' === $handle ) {
        // add attributes
        $tag = '<script id="C-Chat-Tickets" data-name="'.get_option('idEmpresa').'" data-number="'.get_option('idFormNumber').'" src="'.esc_url( $src ).'"></script>';
    }
    return $tag;
}

function cin_contact_form() {
  echo '<div id="'.get_option('idEmpresa').'"></div>';
}

function cin_options(){
  ?>
    <div class="wrap">
      <h1> Chat-In Opciones generales </h1>
      <form action="options.php" method="post">
        <?php
          settings_fields( 'chat-in-settings' );
          do_settings_sections( 'chat-in-settings' );
        ?>
        <table>
            <tr>
                <th>Numero de empresa</th>
                <td><input type="text" placeholder="Numero de empresa" name="idEmpresa" value="<?php echo esc_attr( get_option('idEmpresa') ); ?>" size="50" /></td>
            </tr>
            <tr>
              <td colspan="2"><hr></td>
            </tr>
            <tr>
                <th>Numero de formulario</th>
                <td><input type="text" placeholder="Numero de formulario" name="idFormNumber" value="<?php echo esc_attr( get_option('idFormNumber') ); ?>" size="50" /></td>
            </tr>
            <tr>
                <td><?php submit_button(); ?></td>
            </tr>
        </table>
      </form>
    </div>
  <?php
}

?>