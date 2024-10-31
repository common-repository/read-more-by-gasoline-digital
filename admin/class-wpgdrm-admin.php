<?php
/**
 * Admin functions plugin
 * The admin-specific functionality of the plugin.
 *
 * @package Wpgdrm
 * @subpackage Wpgdrm/admin
 * @author Wilson Cavalcante <hello@gasoline.digital>
 * @since 1.0.0
 */
class Wpgdrm_Admin{
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
	 * Initialize the class and set its properties.
	 */
	public function __construct( $plugin_name, $version, $icon ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->icon = $icon;
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

		wp_enqueue_style( "wpgdrm-admin.css", plugin_dir_url( __FILE__ ) . 'css/wpgdrm-admin.css', array(), $this->version, 'all' );

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
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 */
	public function wpgdrm_admin_menu() {
	    /*
	     * Add a settings page for this plugin to the Settings menu.
	     */
		add_menu_page( 'Read More', 'Read More', 'manage_options', $this->plugin_name, '', $this->icon, 54 );
		$page_options  = add_submenu_page( $this->plugin_name, 'Options', 'Options', 'manage_options', $this->plugin_name, array( $this, 'display_plugin_setup_page' ) );

	}

	/**
	 * Render the settings page for this plugin.
	 */
	public function display_plugin_setup_page() {
		include_once( 'templates/wpgdrm-admin-display.php' );
	}


	/**
	 * admin init function.
	 */
	public function wpgdrm_admin_init() {
		register_setting( 'wpgdrm_options', 'wpgdrm_settings' );

		add_settings_section(
			'wpgdrm_enable_section',
			__( 'Enabled | Disable', WPGDRM_TXT_DOMAIN ),
			'',
			'wpgdrm_options'
		);

		add_settings_section(
			'wpgdrm_options_section',
			__( 'Options', WPGDRM_TXT_DOMAIN ),
			'',
			'wpgdrm_options'
		);

		add_settings_section(
			'wpgdrm_customize_section',
			__( 'Customize Layout', WPGDRM_TXT_DOMAIN ),
			array($this, 'wpgdrm_customize_section_callback'),
			'wpgdrm_options'
		);


		add_settings_section(
			'wpgdrm_shortcode_section',
			__( 'Shortcode', WPGDRM_TXT_DOMAIN ),
			array($this, 'wpgdrm_shortcode_section_callback'),
			'wpgdrm_options'
		);

		add_settings_field(
			'wpgdrm_checkbox_enable',
			__( 'Enable?', WPGDRM_TXT_DOMAIN),
			array($this, 'wpgdrm_checkbox_enable'),
			'wpgdrm_options',
			'wpgdrm_enable_section'
		);

		add_settings_field(
			'wpgdrm_checkbox_auto',
			__( 'Auto Mode', WPGDRM_TXT_DOMAIN),
			array($this, 'wpgdrm_checkbox_auto'),
			'wpgdrm_options',
			'wpgdrm_enable_section'
		);


		add_settings_field(
			'wpgdrm_text_position',
			__( 'Position', WPGDRM_TXT_DOMAIN),
			array($this, 'wpgdrm_text_position'),
			'wpgdrm_options',
			'wpgdrm_options_section'
		);

		add_settings_field(
			'wpgdrm_text_number',
			__( 'Number Posts', WPGDRM_TXT_DOMAIN),
			array($this, 'wpgdrm_text_number'),
			'wpgdrm_options',
			'wpgdrm_options_section'
		);

		add_settings_field(
			'wpgdrm_text_title',
			__( 'Title', WPGDRM_TXT_DOMAIN),
			array($this, 'wpgdrm_text_title'),
			'wpgdrm_options',
			'wpgdrm_options_section'
		);

		add_settings_field(
			'wpgdrm_checkbox_amp',
			__( 'AMP?', WPGDRM_TXT_DOMAIN),
			array($this, 'wpgdrm_checkbox_amp'),
			'wpgdrm_options',
			'wpgdrm_options_section'
		);

		add_settings_field(
			'wpgdrm_checkbox_thumb',
			__( 'Post Thumbnail?', WPGDRM_TXT_DOMAIN),
			array($this, 'wpgdrm_checkbox_thumb'),
			'wpgdrm_options',
			'wpgdrm_options_section'
		);

		add_settings_field(
			'wpgdrm_option_filters',
			__( 'Filters', WPGDRM_TXT_DOMAIN),
			array($this, 'wpgdrm_option_filters'),
			'wpgdrm_options',
			'wpgdrm_options_section'
		);

		add_settings_field(
			'wpgdrm_option_sorting',
			__( 'Sorting', WPGDRM_TXT_DOMAIN),
			array($this, 'wpgdrm_option_sorting'),
			'wpgdrm_options',
			'wpgdrm_options_section'
		);


	}

	/**
	 * wpgdrm_enable_section_callback function.
	 * Enable or Disable Funtionality
	 */
	function wpgdrm_enable_section_callback() {

		echo '<h3 class="gd-table-title">' . __( 'Enable | Disable', WPGDRM_TXT_DOMAIN ) . '</h3>';

	}

	/**
	* wpgdrm_checkbox_enable function
	*/
	function wpgdrm_checkbox_enable(){
		$options = get_option( 'wpgdrm_settings' );
		if(!isset($options['wpgdrm_checkbox_enable']))
			$options['wpgdrm_checkbox_enable'] = false;
	?>
				<label for="wpgdrm_checkbox_enable"><b><?php _e('No',WPGDRM_TXT_DOMAIN); ?></b></label>&nbsp;
				<input type='checkbox'
					   class="ios8-switch"
					   id = 'wpgdrm_checkbox_enable'
					   name='wpgdrm_settings[wpgdrm_checkbox_enable]'
					   <?php checked($options['wpgdrm_checkbox_enable'],1); ?>
					   value='1'>
				<label for="wpgdrm_checkbox_enable"><b><?php _e('Yes',WPGDRM_TXT_DOMAIN); ?></b></label><br />
	<?php
	}


	/**
	* wpgdrm_checkbox_auto function
	*/
	function wpgdrm_checkbox_auto(){
		$options = get_option( 'wpgdrm_settings' );
		if(!isset($options['wpgdrm_checkbox_auto']))
			$options['wpgdrm_checkbox_auto'] = false;
	?>
				<label for="wpgdrm_checkbox_auto"><b><?php _e('No',WPGDRM_TXT_DOMAIN); ?></b></label>&nbsp;
				<input type='checkbox'
					   class="ios8-switch"
					   id = 'wpgdrm_checkbox_auto'
					   name='wpgdrm_settings[wpgdrm_checkbox_auto]'
					   <?php checked($options['wpgdrm_checkbox_auto'],1); ?>
					   value='1'>
				<label for="wpgdrm_checkbox_auto"><b><?php _e('Yes',WPGDRM_TXT_DOMAIN); ?></b></label><br />
				<span class='description'><?php _e( 'You can use the functionality manually with the shortcode or the metabox options in the post.', WPGDRM_TXT_DOMAIN); ?></span><br />
	<?php
	}


	/**
	* wpgdrm_checkbox_amp function
	*/
	function wpgdrm_checkbox_amp(){
		$options = get_option( 'wpgdrm_settings' );
		if(!isset($options['wpgdrm_checkbox_amp']))
			$options['wpgdrm_checkbox_amp'] = false;
	?>
				<label for="wpgdrm_checkbox_amp"><b><?php _e('No',WPGDRM_TXT_DOMAIN); ?></b></label>&nbsp;
				<input type='checkbox'
					   class="ios8-switch"
					   id = 'wpgdrm_checkbox_amp'
					   name='wpgdrm_settings[wpgdrm_checkbox_amp]'
					   <?php checked($options['wpgdrm_checkbox_amp'],1); ?>
					   value='1'>
				<label for="wpgdrm_checkbox_amp"><b><?php _e('Yes',WPGDRM_TXT_DOMAIN); ?></b></label><br />
				<span class='description'><?php _e( 'Enable for AMP Version?', WPGDRM_TXT_DOMAIN) ?></span>
				<br/>
	<?php
	}

	/**
	* wpgdrm_checkbox_thumb function
	*/
	function wpgdrm_checkbox_thumb(){
		$options = get_option( 'wpgdrm_settings' );
		if(!isset($options['wpgdrm_checkbox_thumb']))
			$options['wpgdrm_checkbox_thumb'] = false;
	?>
				<label for="wpgdrm_checkbox_thumb"><b><?php _e('No',WPGDRM_TXT_DOMAIN); ?></b></label>&nbsp;
				<input type='checkbox'
					   class="ios8-switch"
					   id = 'wpgdrm_checkbox_thumb'
					   name='wpgdrm_settings[wpgdrm_checkbox_thumb]'
					   <?php checked($options['wpgdrm_checkbox_thumb'],1); ?>
					   value='1'>
				<label for="wpgdrm_checkbox_thumb"><b><?php _e('Yes',WPGDRM_TXT_DOMAIN); ?></b></label><br />
				<span class='description'><?php _e( 'Display Thumbnails?', WPGDRM_TXT_DOMAIN) ?></span>
	<?php
	}

	/**
	 * wpgdrm_text_position function
	 */
	function wpgdrm_text_position(){
		$options = get_option( 'wpgdrm_settings' );
		if ( !isset ( $options['wpgdrm_text_position'] ) )
			$options['wpgdrm_text_position'] = '3';
		?>
		<input type='number' min='1' max='100' name='wpgdrm_settings[wpgdrm_text_position]'
         value='<?php echo $options['wpgdrm_text_position'] ?>' >
		<span class='description'><?php _e( 'Paragraph Position (default 3 or last)', WPGDRM_TXT_DOMAIN) ?></span>
		<?php

	}

	/**
	 * wpgdrm_text_number function
	 */
	function wpgdrm_text_number(){
		$options = get_option( 'wpgdrm_settings' );
		if ( !isset ( $options['wpgdrm_text_number'] ) )
			$options['wpgdrm_text_number'] = '2';
		?>
		<input type='number' min='1' max='4' name='wpgdrm_settings[wpgdrm_text_number]'
         value='<?php echo $options['wpgdrm_text_number'] ?>' >
		<span class='description'><?php _e( 'Qty of Posts Shown (default 2 or last)', WPGDRM_TXT_DOMAIN) ?></span>
		<?php

	}

	/**
	 * wpgdrm_text_title function
	 */
	function wpgdrm_text_title(){
		$options = get_option( 'wpgdrm_settings' );
		if ( !isset ( $options['wpgdrm_text_title'] ) )
			$options['wpgdrm_text_title'] = 'Read More';
		?>
		<input type='text'  name='wpgdrm_settings[wpgdrm_text_title]'
         value="<?php echo $options['wpgdrm_text_title']?>">
		<span class='description'><?php _e( 'Box Title', WPGDRM_TXT_DOMAIN) ?></span>
		<?php

	}


	/**
	 * wpgdrm_option_filters function.
	 */
	function wpgdrm_option_filters(  ) {
		$options = get_option( 'wpgdrm_settings' );
		if ( !isset ( $options['wpgdrm_option_filters'] ) )
			$options['wpgdrm_option_filters'] = 'random';
		?>
		<select id="wpgdrm_option_filters" class="selectpicker" data-width="fit" name='wpgdrm_settings[wpgdrm_option_filters]'>
    		<option value="random" 		  	<?php selected( $options['wpgdrm_option_filters'], "random" ); ?>	data-content='<?php _e( 'Random', WPGDRM_TXT_DOMAIN) ?>'><?php _e( 'Random', WPGDRM_TXT_DOMAIN) ?></option>
  			<option value="same_category" 	<?php selected( $options['wpgdrm_option_filters'], "same_category" ); ?>   data-content='<?php _e( 'Same Category', WPGDRM_TXT_DOMAIN) ?>'><?php _e( 'Same Category', WPGDRM_TXT_DOMAIN) ?></option>
  			<option value="same_tag"  		<?php selected( $options['wpgdrm_option_filters'], "same_tag" ); ?>   data-content='<?php _e( 'Same Tag', WPGDRM_TXT_DOMAIN) ?>'><?php _e( 'Same Tag', WPGDRM_TXT_DOMAIN) ?></option>

		</select>
		<span class='description'><?php _e( 'Select filter options: Random, Same Category(ies) or Same Tag(s)', WPGDRM_TXT_DOMAIN) ?></span>
		<?php
	}


	/**
	 * wpgdrm_option_sorting function.
	 */
	function wpgdrm_option_sorting(  ) {
		$options = get_option( 'wpgdrm_settings' );
		if ( !isset ( $options['wpgdrm_option_sorting'] ) )
			$options['wpgdrm_option_sorting'] = 'random';
		?>
		<select id="wpgdrm_option_sorting" class="selectpicker" data-width="fit" name='wpgdrm_settings[wpgdrm_option_sorting]'>
    		<option value="random" <?php selected( $options['wpgdrm_option_sorting'], "random" ); ?> data-content='<?php _e( 'Random', WPGDRM_TXT_DOMAIN) ?>'><?php _e( 'Random', WPGDRM_TXT_DOMAIN) ?></option>
  			<option value="newest" <?php selected( $options['wpgdrm_option_sorting'], "newest" ); ?> data-content='<?php _e( 'Newest First', WPGDRM_TXT_DOMAIN) ?>'><?php _e( 'Newest First', WPGDRM_TXT_DOMAIN) ?></option>
  			<option value="oldest" <?php selected( $options['wpgdrm_option_sorting'], "oldest" ); ?> data-content='<?php _e( 'Oldest First', WPGDRM_TXT_DOMAIN) ?>'><?php _e( 'Oldest First', WPGDRM_TXT_DOMAIN) ?></option>

		</select>
		<span class='description'><?php _e( 'Select sorting options: Random, Newest First or Oldest First', WPGDRM_TXT_DOMAIN) ?></span>
		<?php
	}



/**
 * wpgdrm_customize_section_callback function.
 */
function wpgdrm_customize_section_callback( ) {

		echo '<div class="gd-block-special">';
		echo '<p><b>'.__( 'How to Customize the Layout?', WPGDRM_TXT_DOMAIN ) .'</b></p>';
		echo '<p>'.__( 'You can create rules in your theme\'s .css file, or use the wordpress css editor.', WPGDRM_TXT_DOMAIN ) .'</p>';
		echo '<p>'.__( 'To rewrite the rules you can use id #wpgdrm as a base.', WPGDRM_TXT_DOMAIN ) .'</p>';
	echo '</div>';
}



	/**
	 * wpgdrm_shortcode_section_callback function.
	 */
	function wpgdrm_shortcode_section_callback( ) {

		//echo '<h3 class="gd-table-title">' . __( 'Use the manual mode of the plug-in', WPGDRM_TXT_DOMAIN ) . '</h3>';

	    echo '<div class="gd-block-special">';
			//echo '<strong>' . __( 'Please use shortcode ', WPGDRM_TXT_DOMAIN ) . '</strong>';
			echo '<strong>IN FUTURE VERSION</strong>';
			//echo '<code>[gd-read-more]</code>';
		echo '</div>';
	}
}
