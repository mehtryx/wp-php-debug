<?php
/*
Plugin Name: WP PHP Debug
Plugin URI: http://github.com/mehtryx/wp-php-debug
Description: This plugin is used to test code out on wordpress as required.
Version: 0.1.0
Author: Keith Benedict (Mehtryx)
License: MIT
*/



if ( is_admin() ) {
	add_action( 'admin_menu', 'mehtryx_php_debug_create_menu' );
	add_action( 'admin_init', 'mehtryx_php_debug_register_settings' );
}

/**
 * Adds the menu item to the settings dashboard
 * 
 * @uses add_options_page
 *
 * @since 0.1.0
 * @author Keith Benedict
 */
function mehtryx_php_debug_create_menu(){
	$plugin_page = add_options_page( 'PHP Debugger', 'PHP Debugger', 'manage_options', 'mehtryx_php_debug', 'mehtryx_php_debug_options_page' );
}

/**
 * Register settings and create settings section
 *
 * @uses register_setting
 * @uses add_settings_section
 * @uses add_settings_field
 *
 * @since 0.1.0
 * @author Keith Benedict
 */
function mehtryx_php_debug_register_settings(){
	register_setting( 'mehtryx_php_debug_config', 'mehtryx_php_debug_config', 'mehtryx_php_debug_validate_options' );
	add_settings_section( 'mehtryx_php_debug_main', 'PHP Debugging Screen', 'mehtryx_php_debug_main_help', 'mehtryx_php_debug' );
}

/**
* Retrieve options, merge in defaults, avoids need to use isset in all option page functions
*
* @since 0.1.0
* @author Keith Benedict
*/
function mehtryx_php_debug_get_option(){
	// add options here...not used at this time.
	$defaults = array( 'first' => false, 'second' => '');
	$options = get_option( 'mehtryx_php_debug_config' );
	if ( is_array( $options ) ) 
		return array_merge( $defaults, $options );
	else
		return $defaults;
}

/**
* Render help text for options page
*
* @since 0.1.0
* @author Keith Benedict
*/
function mehtryx_php_debug_main_help() {
	?>
	<p>This is the screen that will output code used for debugging, in a future version I want to add an REPL interface for dynamic code testing.  For now, simply modify the code in the text-area field, click the execute button and the results will display below.</p>
	<p>NOTE: You must escape all backslashes in code, otherwise they will be stripped i.e. for the following regex: '/\/$/u' you would need '/\\/$/u' in this editor only.  If you copy any code from here to a php file, remove the extra backslashes.</p>
	<hr />
	<?php
}

/**
 * Render options page
 *
 *
 * @since 0.1.0
 * @author Keith Benedict
 */
function mehtryx_php_debug_options_page(){
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2>PHP Debug Settings</h2>
		<form action="#" method="post">
			<?php
			settings_fields( 'mehtryx_php_debug_config' );
			do_settings_sections( 'mehtryx_php_debug' );
			$exec_string = '';
			if( !empty( $_POST ) ) 
				$exec_string = stripslashes( $_POST['php_code'] );
			?>
			<div class="wrap">
				<textarea id="php_code" name="php_code" rows="10" cols="120"><?php echo ( !empty( $exec_string ) ) ? $exec_string : '//enter your code here...' ?></textarea>
				<input name="Submit" type="submit" value="Execute PHP" />
				<hr />
				<?php
				if( !empty( $exec_string ) ){
					echo eval_php( $exec_string );
				}
				?>
			</div>
			<br />
		</form>
	</div>

	<?php
}

/**
 * Execute php code
 *
 *
 * @since 0.1.0
 * @author Keith Benedict
 */
function eval_php($content)
{
    ob_start();
    eval($content);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}


// Utility Functions

/**
 * Fetches remote content from a URL
 *
 * Uses the VIP version of file_get_contents if available, otherwise defaults to standard version
 * Taken directly from Edward de Groot's function in wp-timbits, just renamed.
 *
 * @uses wpcom_file_get_contents()
 * @uses file_get_contents()
 * @uses esc_url_raw()
 *
 * @since 0.1.0
 * @author Edward de Groot
 */
function mehtryx_php_debug_file_get_contents( $url ) {
	if ( function_exists( 'wpcom_vip_file_get_contents' ) ) {
		return wpcom_vip_file_get_contents( esc_url_raw( $url, array ( 'http', 'https' ) ) , 1, 60 );
	} else {
		return file_get_contents( esc_url_raw( $url, array ( 'http', 'https' ) ) );
	}
}
