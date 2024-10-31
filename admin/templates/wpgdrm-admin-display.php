<?php
/**
 * Admin View Screen
 *
 * @package Wpgdrm
 * @subpackage Wpgdrm/admin/templates
 * @author Wilson Cavalcante <hello@gasoline.digital>
 * @since 1.0.0
 */

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/qsheeraz#content-plugins
 * @since      1.0.0
 *
 * @package    Wpfc
 * @subpackage Wpfc/admin/partials
 */
?>
	
<div class="wrap wpgdrm gd-page">
	<h1><?php _e('Read More by @Gasoline.Digital',WPGDRM_TXT_DOMAIN); ?></h1>	
	<?php settings_errors(); ?>

	<form id="wpgdrm-settings" class="gd-form-action" action='options.php' method='post'>
		<div class="gd-wrap">
			<div  class="gd-block">
			<?php  
			settings_fields( 'wpgdrm_options' );
			do_settings_sections( 'wpgdrm_options' );
			submit_button();
			?>
		</div>		
	</form>
</div>	

