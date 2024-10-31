<?php
/**
 * Metabox functions plugin
 * The admin-specific functionality of the plugin.
 *
 * @package Wpgdrm
 * @subpackage Wpgdrm/admin
 * @author Wilson Cavalcante <hello@gasoline.digital>
 * @since 1.0.0
 */
class Wpgdrm_Metabox{
	/**
	 * The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 */
	private $version;

	/**
	 * The icon of this plugin.
	 */
	private $icon;

	/**
	 * The types used of this plugin.
	 */
	private $types;


	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct( $plugin_name, $version, $icon ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->icon = $icon;
		$this->types = ['post'];
	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpfc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpfc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( "wpgdrm-admin.css", plugin_dir_url( __FILE__ ) . 'css/wpgdrm-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpfc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpfc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( "wpgdrm-admin.js", plugin_dir_url( __FILE__ ) . 'js/wpgdrm-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Metabox init function.
	 */		
	public function wpgdrm_metabox_init(){
	    foreach ($this->types as $type) {
	        add_meta_box(
	            'wpgdrm_metabox',         
	            'Read More Settings',  	  
	             array( $this, 'display_plugin_setup_metabox' ),  
	            $type,
	            'side'           
	        );
	    }

	}	
	
	/**
	 * Render the settings metabox for this plugin.
	 */
	public function display_plugin_setup_metabox($post) {
		include_once('templates/wpgdrm-metabox-display.php');
	}


	/**
	 * Metabox save values function.
	 */		
	public function wpgdrm_metabox_save($post_id){				

		/* Check Nonce */
		if ( ! isset( $_POST['wpgdrm_metabox_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['wpgdrm_metabox_nonce'] ), 'wpgdrm_metabox' ) ) { 
			return $post_id;
		}

		/* Check Permission */
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}		

		/* Not save for Autosave */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}		


		/* Enable Read More */
		$options = get_option( 'wpgdrm_settings' );		
		$enable = false;
		if(isset($options['wpgdrm_checkbox_enable']))
			$enable = boolval($options['wpgdrm_checkbox_enable']);		

		if(!$enable){
			return $post_id;
		}

		/* Save Fields */
		$this->wpgdrm_metabox_save_field_check($post_id,'wpgdrm_post_disable');
		$this->wpgdrm_metabox_save_field_check($post_id,'wpgdrm_post_enable');
		$this->wpgdrm_metabox_save_field_check($post_id,'wpgdrm_post_disable_thumbnail');
		$this->wpgdrm_metabox_save_field_check($post_id,'wpgdrm_post_enable_thumbnail');
		$this->wpgdrm_metabox_save_field_check($post_id,'wpgdrm_post_disable_amp');
		$this->wpgdrm_metabox_save_field_check($post_id,'wpgdrm_post_enable_amp');
		
		$this->wpgdrm_metabox_save_field($post_id,'wpgdrm_post_position');
		$this->wpgdrm_metabox_save_field($post_id,'wpgdrm_post_number');
		$this->wpgdrm_metabox_save_field($post_id,'wpgdrm_post_filter');
		$this->wpgdrm_metabox_save_field($post_id,'wpgdrm_post_sorting');
		
		$number = 10;	
		for($x=1; $x <= $number; $x++){
			$field = "wpgdrm_post_especific_$x";		
			$this->wpgdrm_metabox_save_field($post_id,$field);

		}
	
		return $post_id;

	}	

	public function wpgdrm_metabox_save_field($post_id,$field){
		if(isset($_POST[$field])){
			$value = sanitize_text_field(wp_unslash($_POST[$field]));
			update_post_meta( $post_id, $field, $value );
		}
	}	

	public function wpgdrm_metabox_save_field_check($post_id,$field){
		if(isset($_POST[$field])){
			$value = ( isset( $_POST[$field] ) && '1' === $_POST[$field] ) ? 1 : 0;
			update_post_meta( $post_id, $field, esc_attr($value));
		}else{
			delete_post_meta( $post_id, $field );
		}
	}	


}