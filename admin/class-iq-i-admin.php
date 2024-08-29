<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://juan.com
 * @since      1.0.0
 *
 * @package    Iq_I
 * @subpackage Iq_I/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Iq_I
 * @subpackage Iq_I/admin
 * @author     Juan  <jporras@iqtsystems.com>
 */
class Iq_I_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * .
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', array($this, 'addAdminMenuItems'), 9);
		add_action('admin_init', array( $this, 'registerAndBuildFields' ));

	}

	public function registerAndBuildFields() {

		// Register a new section in the "iq_settings" page.
		// add_settings_section( string $id, string $title, callable $callback, string $page )
		add_settings_section(
			'iq_connection_settings',
			__( 'Configuración de IQ.', $this->plugin_name ),
			array($this, 'settingsCallback'),
			'iq_settings'
		);

		// Register a new field in the "iqforms_connection_settings" section, inside the "iqforms_settings" page.
		unset($args);
		$args = array (
		'type'      => 'input',
		'subtype'   => 'text',
		'id'    => 'iq_rest_api_base',
		'name'      => 'iq_rest_api_base',
		'required' => 'true',
		'get_options_list' => '',
		'value_type'=>'normal',
		'wp_data' => 'option',
		);
		add_settings_field(
		'iq_rest_api_base',
		__('Licencia IQ', $this->plugin_name),
		array( $this, 'renderField' ),
		'iq_settings',
		'iq_connection_settings',
		$args
		);
		register_setting(
		'iq_settings',
		'iq_rest_api_base',
		array(
		'type' => 'string',
		'description' => 'URL needed for connecting to IQ',
		//'sanitize_callback' => array($this, 'calidateRestApiBase'),
		//'show_in_rest' => false,
		'default' => '',
		)
		);
	}

	public function settingsCallBack() {
		echo '<p>En esta sección se solicita la licencia de IQ otorgada al momento de adqurir el plugin.</p>';
	}

	public function renderField( $args ) {
		if( $args['wp_data'] == 'option' ) {
		 $wp_data_value = get_option( $args['name'] );
		} elseif( $args['wp_data'] == 'post_meta' ) {
		 $wp_data_value = get_post_meta($args['post_id'], $args['name'], true );
		}
	   switch ( $args['type'] ) {
		 case 'input':
		  $value = ( $args['value_type'] == 'serialized' ) ? serialize($wp_data_value) : $wp_data_value;
		  if( $args['subtype'] != 'checkbox' ) {
		   $prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">'.$args['prepend_value'].'</span>' : '';
		   $prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
		   $step = (isset($args['step'])) ? 'step="'.$args['step'].'"' : '';
		   $min = (isset($args['min'])) ? 'min="'.$args['min'].'"' : '';
		   $max = (isset($args['max'])) ? 'max="'.$args['max'].'"' : '';
		   if( isset( $args['disabled'] ) ) {
			// hide the actual input bc if it was just a disabled input the informaiton saved in the database would be wrong - bc it would pass empty values and wipe the actual information
			echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'_disabled" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="'.$args['id'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
		   } else {
			echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'" required="'.$args['required'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
		   }
			 /*<input required="required" '.$disabled.' type="number" step="any" id="'.$this->plugin_name.'_cost2" name="'.$this->plugin_name.'_cost2" value="' . esc_attr( $cost ) . '" size="25" /><input type="hidden" id="'.$this->plugin_name.'_cost" step="any" name="'.$this->plugin_name.'_cost" value="' . esc_attr( $cost ) . '" />*/
		  } else {
		   $checked = ($value) ? 'checked' : '';
		   echo '<input type="'.$args['subtype'].'" id="'.$args['id'].'" required="'.$args['required'].'" name="'.$args['name'].'" size="40" value="1" '.$checked.' />';
		  }
	   break;
		 default:
		  # code...
		 break;
		}
	}

	public function validateUrl($value) {
		$url = filter_var($value, FILTER_SANITIZE_URL);
		if( ! filter_var($url, FILTER_VALIDATE_URL)) {
		 //add_settings_error( string $setting, string $code, string $message, string $type = 'error' )
		 add_settings_error( 'iq_rest_api_base', 'iq_rest_api_base', 'URL not valid' );
		 return false;
		}
		return $url;
	}

	public function addAdminMenuItems() {
		//add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )
		add_menu_page(
		  $this->plugin_name,
		  'IQ Plugin',
		  'administrator',
		  $this->plugin_name,
		  array(
			$this,
			'displayAdminDashboard',
		  ),
		  'dashicons-money',
		  20
		);

		//add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', int $position = null )
		add_submenu_page(
			$this->plugin_name,
			'Your plugin Settings',
			'Settings',
			'administrator',
			$this->plugin_name.'-settings',
			array(
			$this,
			'displayAdminSettings',
			)
		);

	  }

	  public function displayAdminDashboard() {
		require_once 'partials/' . $this->plugin_name . '-admin-display.php';
	  }


	  public function displayAdminSettings() {
		require_once 'partials/' . $this->plugin_name . '-admin-settings-display.php';
	   }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Iq_I_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Iq_I_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/iq-i-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Iq_I_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Iq_I_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/iq-i-admin.js', array( 'jquery' ), $this->version, false );

	}
}
?>

<<<<<<< HEAD
<script>
    import {createpay} from "../includes/Payment/js/servicesbutonpayment.js"
	createpay();
	</script>
=======
>>>>>>> 9982e63521184c51977645d841aa1b0541fd75b6
