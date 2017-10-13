<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/** ---------------------------------------------------------------------------
 * Server Status
 * @version 1.0
 * ---------------------------------------------------------------------------- */
class mfnServerStatus {

	public $error	= '';
	
	
	/** ---------------------------------------------------------------------------
	 * Constructor
	 * ---------------------------------------------------------------------------- */
	function __construct() {
		add_action( 'admin_menu', array( &$this, 'init' ) );
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Add theme Page
	 * ---------------------------------------------------------------------------- */
	function init() {
		
		$title = __( 'System Status','mfn-opts' );
		
		if( WHITE_LABEL ){
			
			// White Label | Hide 'Server Status' Page
			add_theme_page(
				$title,
				$title,
				'edit_theme_options',
				'mfn_status',
				array( &$this, 'server_white' )
			);
			
		} else {
			
			add_theme_page(
				$title,
				$title,
				'edit_theme_options',
				'mfn_status',
				array( &$this, 'server' )
			);
			
		}

	}
	
	
	/** ---------------------------------------------------------------------------
	 * White Label | Hide 'Server Status' Page
	 * ---------------------------------------------------------------------------- */
	function server_white() {
		?>
			<div id="mfn-wrapper" class="mfn-server wrap">
				<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
				<p><?php _e( 'This feature is disabled in White Label mode', 'mfn-opts' );?></p>
			</div>
		<?php 
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Transforms the php.ini notation for numbers (like '2M') to an integer
	 * ---------------------------------------------------------------------------- */
	function let_to_num( $size ) {
		$l		= substr( $size, -1 );
		$ret	= substr( $size, 0, -1 );
		switch( strtoupper( $l ) ) {
			case 'P':
				$ret *= 1024;
			case 'T':
				$ret *= 1024;
			case 'G':
				$ret *= 1024;
			case 'M':
				$ret *= 1024;
			case 'K':
				$ret *= 1024;
		}
		return $ret;
	}
	
	
	/** ---------------------------------------------------------------------------
	 * Server Status
	 * ---------------------------------------------------------------------------- */
	function server(){
	?>
	
		<div id="mfn-wrapper" class="mfn-server wrap">
		
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			
			
			<table class="widefat" cellspacing="0">
			
				<thead>
					<tr>
						<th colspan="3" data-export-label="WordPress Environment"><?php _e( 'WordPress Environment', 'mfn-opts' ); ?></th>
					</tr>
				</thead>
				
				<tbody>
				
					<tr>
						<td data-export-label="Home URL"><?php _e( 'Home URL', 'mfn-opts' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The URL of your site\'s homepage.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
						<td><?php form_option( 'home' ); ?></td>
					</tr>
					
					<tr>
						<td data-export-label="Site URL"><?php _e( 'Site URL', 'mfn-opts' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The root URL of your site.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
						<td><?php form_option( 'siteurl' ); ?></td>
					</tr>
					
					<tr>
						<td data-export-label="WP Version"><?php _e( 'WP Version', 'mfn-opts' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of WordPress installed on your site.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
						<td><?php bloginfo('version'); ?></td>
					</tr>
					
					<tr>
						<td data-export-label="WP Multisite"><?php _e( 'WP Multisite', 'mfn-opts' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Whether or not you have WordPress Multisite enabled.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
						<td><?php if ( is_multisite() ) echo '&#10004;'; else echo '&ndash;'; ?></td>
					</tr>
					
					<tr>
						<td data-export-label="WP Memory Limit"><?php _e( 'WP Memory Limit', 'mfn-opts' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum amount of memory (RAM) that your site can use at one time.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
						<td><?php
							$memory = $this->let_to_num( WP_MEMORY_LIMIT );
							
							if( function_exists( 'memory_get_usage' ) ) {
								$server_memory = $this->let_to_num( @ini_get( 'memory_limit' ) );
								$memory = max( $memory, $server_memory );
							}
			
							if ( $memory < 134217728 ) {
								echo '<mark class="error">' . sprintf( __( '%s - We recommend setting memory to at least 128MB. See: <a href="%s" target="_blank">Increasing memory allocated to PHP</a>', 'mfn-opts' ), size_format( $memory ), 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP' ) . '</mark>';
							} else {
								echo '<mark class="yes">'. size_format( $memory ) .'</mark>';
							}
						?></td>
					</tr>
					
					<tr>
						<td data-export-label="WP Debug Mode"><?php _e( 'WP Debug Mode', 'mfn-opts' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Displays whether or not WordPress is in Debug Mode.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
						<td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">&#10004;</mark>'; else echo '<mark class="no">&ndash;</mark>'; ?></td>
					</tr>
					
					<tr>
						<td data-export-label="Language"><?php _e( 'Language', 'mfn-opts' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The current language used by WordPress. Default = English', 'mfn-opts' ) . '">[?]</a>'; ?></td>
						<td><?php echo get_locale() ?></td>
					</tr>
					
				</tbody>
				
			</table>
			
			
			<table class="widefat" cellspacing="0">
			
				<thead>
					<tr>
						<th colspan="3" data-export-label="Server Environment"><?php _e( 'Server Environment', 'mfn-opts' ); ?></th>
					</tr>
				</thead>
				
				<tbody>
				
					<tr>
						<td data-export-label="Server Info"><?php _e( 'Server Info', 'mfn-opts' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Information about the web server that is currently hosting your site.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
						<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
					</tr>
					
					<tr>
						<td data-export-label="PHP Version"><?php _e( 'PHP Version', 'mfn-opts' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of PHP installed on your hosting server.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
						<td><?php if ( function_exists( 'phpversion' ) ) echo esc_html( phpversion() ); ?></td>
					</tr>
					
					<?php if ( function_exists( 'ini_get' ) ) : ?>
					
						<tr>
							<td data-export-label="PHP Post Max Size"><?php _e( 'PHP Post Max Size', 'mfn-opts' ); ?>:</td>
							<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The largest filesize that can be contained in one post.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
							<td><?php echo size_format( $this->let_to_num( ini_get('post_max_size') ) ); ?></td>
						</tr>
						
						<tr>
							<td data-export-label="PHP Time Limit"><?php _e( 'PHP Time Limit', 'mfn-opts' ); ?>:</td>
							<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'mfn-opts' ) . '">[?]</a>'; ?></td>
							<td><?php
								$time_limit = ini_get('max_execution_time');
	
								if ( $time_limit > 0 && $time_limit < 180 ) {
									echo '<mark class="error">' . sprintf( __( '%s - We recommend setting max execution time to at least 180. See: <a href="%s" target="_blank">Increasing max execution to PHP</a>', 'mfn-opts' ), $time_limit, 'http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded' ) . '</mark>';
								} else {
									echo '<mark class="yes">' . $time_limit . '</mark>';
								}
							?></td>
						</tr>
						
						<tr>
							<td data-export-label="PHP Max Input Vars"><?php _e( 'PHP Max Input Vars', 'mfn-opts' ); ?>:</td>
							<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
							<td><?php
								$max_input_vars = ini_get('max_input_vars');
	
								if ( $max_input_vars < 5000 ) {
									echo '<mark class="error">' . sprintf( __( '%s - Max input vars limitation will truncate POST data such as menus.', 'mfn-opts' ), $max_input_vars ) . '</mark>';
								} else {
									echo '<mark class="yes">' . $max_input_vars . '</mark>';
								}
							?></td>
						</tr>
						
						<tr>
							<td data-export-label="SUHOSIN Installed"><?php _e( 'SUHOSIN Installed', 'mfn-opts' ); ?>:</td>
							<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Suhosin is an advanced protection for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself. If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
							<td><?php echo extension_loaded( 'suhosin' ) ? '&#10004;' : '&ndash;'; ?></td>
						</tr>
						
					<?php endif; ?>
					
					<tr>
						<td data-export-label="MySQL Version"><?php _e( 'MySQL Version', 'mfn-opts' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of MySQL installed on your hosting server.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
						<td>
							<?php
								global $wpdb;
								echo $wpdb->db_version();
							?>
						</td>
					</tr>
					
					<tr>
						<td data-export-label="Max Upload Size"><?php _e( 'Max Upload Size', 'mfn-opts' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The largest filesize that can be uploaded to your WordPress installation.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
						<td><?php echo size_format( wp_max_upload_size() ); ?></td>
					</tr>
					
					<tr>
						<td data-export-label="Default Timezone is UTC"><?php _e( 'Default Timezone is UTC', 'mfn-opts' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The default timezone for your server.', 'mfn-opts' ) . '">[?]</a>'; ?></td>
						<td><?php
							$default_timezone = date_default_timezone_get();
							if ( 'UTC' !== $default_timezone ) {
								echo '<mark class="error">&#10005; ' . sprintf( __( 'Default timezone is %s - it should be UTC', 'mfn-opts' ), $default_timezone ) . '</mark>';
							} else {
								echo '<mark class="yes">&#10004;</mark>';
							} ?>
						</td>
					</tr>
					
					<?php
						$checks = array();
			
						// fsockopen/cURL
						$checks['fsockopen_curl']['name'] = 'fsockopen/cURL';
						$checks['fsockopen_curl']['help'] = '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Plugins may use it when communicating with remote services.', 'mfn-opts' ) . '">[?]</a>';
			
						if ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
							$checks['fsockopen_curl']['success'] = true;
						} else {
							$checks['fsockopen_curl']['success'] = false;
							$checks['fsockopen_curl']['note']    = __( 'Your server does not have fsockopen or cURL enabled. Contact your hosting provider.', 'mfn-opts' ). '</mark>';
						}
			
						// DOMDocument
						$checks['dom_document']['name'] = 'DOMDocument';
						$checks['dom_document']['help'] = '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'WordPress Importer use DOMDocument.', 'mfn-opts' ) . '">[?]</a>';
			
						if ( class_exists( 'DOMDocument' ) ) {
							$checks['dom_document']['success'] = true;
						} else {
							$checks['dom_document']['success'] = false;
							$checks['dom_document']['note']    = sprintf( __( 'Your server does not have the <a href="%s">DOMDocument</a> class enabled. Contact your hosting provider.', 'mfn-opts' ), 'http://php.net/manual/en/class.domdocument.php' ) . '</mark>';
						}
			
						// WP Remote Get Check
						$checks['wp_remote_get']['name'] = __( 'Remote Get', 'mfn-opts');
						$checks['wp_remote_get']['help'] = '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Retrieve the raw response from the HTTP request using the GET method.', 'mfn-opts' ) . '">[?]</a>';

						$response = wp_remote_get( LIBS_URI . '/importer/demo/menu.txt' );
			
						if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
							$checks['wp_remote_get']['success'] = true;
						} else {
							$checks['wp_remote_get']['note']    = __( 'WordPress function <a href="https://codex.wordpress.org/Function_Reference/wp_remote_get">wp_remote_get()</a> test failed. Contact your hosting provider.', 'mfn-opts' );
							if ( is_wp_error( $response ) ) {
								$checks['wp_remote_get']['note'] .= ' ' . sprintf( __( 'Error: %s', 'mfn-opts' ), sanitize_text_field( $response->get_error_message() ) );
							} else {
								$checks['wp_remote_get']['note'] .= ' ' . sprintf( __( 'Status code: %s', 'mfn-opts' ), sanitize_text_field( $response['response']['code'] ) );
							}
							$checks['wp_remote_get']['success'] = false;
						}
			
						foreach ( $checks as $check ) {
							$mark = ! empty( $check['success'] ) ? 'yes' : 'error';
							?>
							<tr>
								<td data-export-label="<?php echo esc_html( $check['name'] ); ?>"><?php echo esc_html( $check['name'] ); ?>:</td>
								<td class="help"><?php echo isset( $check['help'] ) ? $check['help'] : ''; ?></td>
								<td>
									<mark class="<?php echo $mark; ?>">
										<?php echo ! empty( $check['success'] ) ? '&#10004' : '&#10005'; ?> <?php echo ! empty( $check['note'] ) ? wp_kses_data( $check['note'] ) : ''; ?>
									</mark>
								</td>
							</tr>
							<?php
						}
					?>
					
				</tbody>
				
			</table>
			
			<table class="widefat" cellspacing="0">
			
				<thead>
					<tr>
						<th colspan="3" data-export-label="Theme"><?php _e( 'Theme', 'mfn-opts' ); ?></th>
					</tr>
				</thead>

				<tbody>
				
					<tr>
						<td data-export-label="Name"><?php _e( 'Name', 'mfn-opts' ); ?>:</td>
						<td class="help"></td>
						<td>BeTheme</td>
					</tr>
					
					<tr>
						<td data-export-label="Version"><?php _e( 'Version', 'mfn-opts' ); ?>:</td>
						<td class="help"></td>
						<td><?php echo THEME_VERSION; ?></td>
					</tr>

				</tbody>
			</table>


		</div>	
		<?php	
	}
	
}

$mfnServerStatus = new mfnServerStatus;
