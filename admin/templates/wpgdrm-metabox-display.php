<?php
/**
 * Metabox View Screen
 *
 * @package Wpgdrm
 * @subpackage Wpgdrm/admin/templates
 * @author Wilson Cavalcante <hello@gasoline.digital>
 * @since 1.0.0
 */

/**
 * Provide a metabox area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/qsheeraz#content-plugins
 * @since      1.0.0
 *
 * @package    Wpfc
 * @subpackage Wpfc/admin/partials
 */
$options = get_option( 'wpgdrm_settings' );
$enable = false;
$auto = false;
$thumb = false;
$amp = false;

if(isset($options['wpgdrm_checkbox_enable']))
	$enable = boolval($options['wpgdrm_checkbox_enable']);

if(isset($options['wpgdrm_checkbox_auto']))
	$auto = boolval($options['wpgdrm_checkbox_auto']);

if(isset($options['wpgdrm_checkbox_thumb']))
	$thumb = boolval($options['wpgdrm_checkbox_thumb']);


if(isset($options['wpgdrm_checkbox_amp']))
	$amp = boolval($options['wpgdrm_checkbox_amp']);


$number = '2';
if(isset($options['wpgdrm_text_number']))
	$number = (is_numeric($options['wpgdrm_text_number'])? $options['wpgdrm_text_number'] : 2);

// Post Setting
$post_number = get_post_meta($post->ID, 'wpgdrm_post_number', true);
if(is_numeric($post_number) && $post_number > 0){
	$number = $post_number;
}




wp_nonce_field( 'wpgdrm_metabox', 'wpgdrm_metabox_nonce' );
?>


<?php if($enable){ ?>
	<?php if($auto){ ?>
	<p class="meta-options">
		<label for="wpgdrm_post_disable" class="selectit">
			<input name="wpgdrm_post_disable" type="checkbox" <?php checked(boolval(get_post_meta($post->ID, 'wpgdrm_post_disable', true)),1) ?> id="wpgdrm_post_disable" value="1"> <?php _e('Disable Read More for this post', WPGDRM_TXT_DOMAIN);?>
		</label>
	</p>
	<?php }else{ ?>
	<p class="meta-options">
		<label for="wpgdrm_post_enable" class="selectit">
			<input name="wpgdrm_post_enable" type="checkbox" <?php checked(boolval(get_post_meta($post->ID, 'wpgdrm_post_enable', true)),1) ?> id="wpgdrm_post_enable" value="1"> <?php _e('Enable Read More for this post', WPGDRM_TXT_DOMAIN);?>
		</label>
	</p>
	<?php }?>

	<h4><?php _e( 'Overwrite Global Settings', WPGDRM_TXT_DOMAIN);?></h4>
	<p class="howto" id="wpgdrm_overwrite_settings"><?php _e('Overwritten rules apply only to this post', WPGDRM_TXT_DOMAIN);?></p>

	<?php if($thumb){ ?>
	<p class="meta-options">
		<label for="wpgdrm_post_disable_thumbnail" class="selectit">
			<input name="wpgdrm_post_disable_thumbnail" <?php checked(boolval(get_post_meta($post->ID, 'wpgdrm_post_disable_thumbnail', true)),1) ?> type="checkbox" id="wpgdrm_post_disable_thumbnail" value="1"> <?php _e('Disable Thumbnail', WPGDRM_TXT_DOMAIN);?>
		</label>
	</p>
	<?php }else{ ?>
	<p class="meta-options">
		<label for="wpgdrm_post_enable_thumbnail" class="selectit">
			<input name="wpgdrm_post_enable_thumbnail" <?php checked(boolval(get_post_meta($post->ID, 'wpgdrm_post_enable_thumbnail', true)),1) ?> type="checkbox" id="wpgdrm_post_enable_thumbnail" value="1"> <?php _e('Enable Thumbnail', WPGDRM_TXT_DOMAIN);?>
		</label>
	</p>
	<?php }?>

	<?php if($amp){ ?>
	<p class="meta-options">
		<label for="wpgdrm_post_disable_amp" class="selectit">
			<input name="wpgdrm_post_disable_amp" type="checkbox" <?php checked(boolval(get_post_meta($post->ID, 'wpgdrm_post_disable_amp', true)),1) ?> id="wpgdrm_post_disable_amp" value="1"> <?php _e('Disable AMP', WPGDRM_TXT_DOMAIN);?>
		</label>
	</p>
	<?php }else{ ?>
	<p class="meta-options">
		<label for="wpgdrm_post_enable_amp" class="selectit">
			<input name="wpgdrm_post_enable_amp" type="checkbox" <?php checked(boolval(get_post_meta($post->ID, 'wpgdrm_post_enable_amp', true)),1) ?> id="wpgdrm_post_enable_amp" value="1"> <?php _e('Enable AMP', WPGDRM_TXT_DOMAIN);?>
		</label>
	</p>
	<?php }?>


	<p>
		<label for="wpgdrm_post_position"><?php _e( 'Position', WPGDRM_TXT_DOMAIN) ?>:
			<input type='number' min='1' max='100' name='wpgdrm_post_position' class="code" value="<?php echo get_post_meta($post->ID, 'wpgdrm_post_position', true); ?>">
		</label>
	</p>
	<p>
		<label for="wpgdrm_post_number"><?php _e( 'Number Posts', WPGDRM_TXT_DOMAIN) ?>:
			<input type='number' min='1' max='4' name='wpgdrm_post_number' class="code" value="<?php echo get_post_meta($post->ID, 'wpgdrm_post_number', true); ?>">
		</label>
	</p>

	<p>
		<label for="wpgdrm_post_filter"><?php _e( 'Filters', WPGDRM_TXT_DOMAIN) ?>:
		<select id="wpgdrm_post_filter" class="selectpicker" data-width="fit" name='wpgdrm_post_filter'>
			<option value=""></option>
			<option value="random" 		  	<?php selected( get_post_meta($post->ID, 'wpgdrm_post_filter', true), "random" ); ?>	data-content='<?php _e( 'Random', WPGDRM_TXT_DOMAIN) ?>'><?php _e( 'Random', WPGDRM_TXT_DOMAIN) ?></option>
			<option value="same_category" 	<?php selected( get_post_meta($post->ID, 'wpgdrm_post_filter', true), "same_category" ); ?>   data-content='<?php _e( 'Same Category', WPGDRM_TXT_DOMAIN) ?>'><?php _e( 'Same Category', WPGDRM_TXT_DOMAIN) ?></option>
			<option value="same_tag"  		<?php selected( get_post_meta($post->ID, 'wpgdrm_post_filter', true), "same_tag" ); ?>   data-content='<?php _e( 'Same Tag', WPGDRM_TXT_DOMAIN) ?>'><?php _e( 'Same Tag', WPGDRM_TXT_DOMAIN) ?></option>
		</select>
		</label>
	</p>

	<p>
		<label for="wpgdrm_post_sorting"><?php _e( 'Sorting', WPGDRM_TXT_DOMAIN) ?>:
		<select id="wpgdrm_post_sorting" class="selectpicker" data-width="fit" name='wpgdrm_post_sorting'>
    		<option value=""></option>
    		<option value="random" <?php selected( get_post_meta($post->ID, 'wpgdrm_post_sorting', true), "random" ); ?> data-content='<?php _e( 'Random', WPGDRM_TXT_DOMAIN) ?>'><?php _e( 'Random', WPGDRM_TXT_DOMAIN) ?></option>
  			<option value="newest" <?php selected( get_post_meta($post->ID, 'wpgdrm_post_sorting', true), "newest" ); ?> data-content='<?php _e( 'Newest First', WPGDRM_TXT_DOMAIN) ?>'><?php _e( 'Newest First', WPGDRM_TXT_DOMAIN) ?></option>
  			<option value="oldest" <?php selected( get_post_meta($post->ID, 'wpgdrm_post_sorting', true), "oldest" ); ?> data-content='<?php _e( 'Oldest First', WPGDRM_TXT_DOMAIN) ?>'><?php _e( 'Oldest First', WPGDRM_TXT_DOMAIN) ?></option>
		</select>
	</p>

	<p>
		<label for="wpgdrm_post_especific"><?php _e( 'Specific Posts', WPGDRM_TXT_DOMAIN) ?>:
			<?php for($x=1; $x <= $number; $x++){?>
				<input type='text' name='wpgdrm_post_especific_<?php echo $x?>' class="code" value="<?php echo get_post_meta($post->ID, 'wpgdrm_post_especific_'.$x, true); ?>" placeholder="Fill in with post ID Or Slug">
			<?php } ?>
		</label>
	</p>
<?php }else{ ?>
	<?php _e( 'The functionality needs to be activated in the plugin options', WPGDRM_TXT_DOMAIN);?>
<?php }?>
