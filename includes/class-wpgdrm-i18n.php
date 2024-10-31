<?php
/**
 * Internationalization
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @package Wpgdrm
 * @subpackage Wpgdrm/includes
 * @author Wilson Cavalcante <hello@gasoline.digital>
 * @since 1.0.0
 */
class Wpgdrm_i18n {
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			WPGDRM_TXT_DOMAIN,
			false,
			WPGDRM_PLUGIN_DIR . '/languages/'
		);

	}



}
