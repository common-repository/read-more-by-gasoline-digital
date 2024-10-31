<?php
/**
 * Core Plugin
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package Wpgdrm
 * @subpackage Wpgdrm/includes
 * @author Wilson Cavalcante <hello@gasoline.digital>
 * @since 1.0.0
 */
class Wpgdrm {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 */
	protected $version;

	/**
	 * The icon of the plugin.
	 */
	protected $icon;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 */
	public function __construct() {
		if ( defined( 'WPGDRM_VERSION' ) ) {
			$this->version = WPGDRM_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = WPGDRM_PLUGIN_NAME;
		$this->icon = "data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMTI5LjYzIDExNjcuNjMiPgogIDx0aXRsZT5pY29uLWdhc29saW5lPC90aXRsZT4KICA8cGF0aCBkPSJNMTA4MC41MSw0MDguNDFhNTAzLjA2LDUwMy4wNiwwLDAsMC0yMS4yMS02Mi41OWw3MC4zMy04Ni4zOS05OS43OCwyNi44N0M5MjIuNTQsMTAxLjY1LDcwNC40MSwxLjQ5LDQ4OCw1MC44OUw0NTUuMTUsMGwtMy4wOSw2MC41QzIzOS44NiwxMjUuNjMsMTAwLjc3LDMyMS4yNiw5OS44OCw1MzQuODJMMCw1NjEuMywxMDQuMDYsNjAxLjFhNTAzLjA4LDUwMy4wOCwwLDAsMCwxMi44NCw2NC44M0MxNTgsODE5Ljc3LDI2Ni43Nyw5MzcuNTIsNDAyLjY0LDk5NS43M2wtOS40NSwxNzEuOTEsMTEzLjI4LTE0MC4yNUE0OTkuNzEsNDk5LjcxLDAsMCwwLDkyMy4xOSw5MTZsMTY4LjE1LDY1LTk0LTE0NC4yN0MxMDg2LjEsNzE4LjU2LDExMjEuNjIsNTYyLjI2LDEwODAuNTEsNDA4LjQxWm0tNTM3LDU3My4xM0w2NzQuMjEsODE5LjdsMTk0LDc1LjA2YTQ0OS4wNyw0NDkuMDcsMCwwLDEtMzI0Ljc1LDg2Ljc5Wk00MTcuNzQsNzIxLjA2bC0xMi4xLDIyMGMtMTE0LTU0LjU0LTIwNC4yOC0xNTYuNzEtMjM5LjQ1LTI4OC4zMXEtNC4wOC0xNS4yOC03LTMwLjU5Wk0xNTEuMTksNTIxLjIxYzYuMzgtMTgwLjI2LDEyMi4xNC0zNDQsMjk4LjA3LTQwNi4wNmwtMTcsMzMxLjUyWk01MTcuNjksOTYuODZjMTgzLjQ1LTM0LDM2NS40Myw1MC4xOSw0NjAuODksMjAzLjI0TDY5Ny43NiwzNzUuNzNaTTg0Ny4yNiw2MDYuMjdsMTc0Ljc5LTIxNC43MXE1LjA1LDE0Ljc0LDkuMTUsMzBjMzUuMTcsMTMxLjYsNy44NiwyNjUuMi02My43LDM2OS4zM1oiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAgMCkiIHN0eWxlPSJmaWxsOiAjNDA0MDQwO2ZpbGwtcnVsZTogZXZlbm9kZCIvPgo8L3N2Zz4K";

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_metabox_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wpgdrm_Loader. Orchestrates the hooks of the plugin.
	 * - Wpgdrm_i18n. Defines internationalization functionality.
	 * - Wpgdrm_Admin. Defines all hooks for the admin area.
	 * - Wpgdrm_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once WPGDRM_PLUGIN_DIR . '/includes/class-wpgdrm-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once WPGDRM_PLUGIN_DIR . '/includes/class-wpgdrm-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once WPGDRM_PLUGIN_DIR . '/admin/class-wpgdrm-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the metabox area.
		 */
		require_once WPGDRM_PLUGIN_DIR . '/admin/class-wpgdrm-metabox.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once WPGDRM_PLUGIN_DIR. '/public/class-wpgdrm-public.php';

		$this->loader = new Wpgdrm_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wpgdrm_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 */
	private function set_locale() {

		$plugin_i18n = new Wpgdrm_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wpgdrm_Admin( $this->get_plugin_name(), $this->get_version(), $this->get_icon()  );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		/**
		 * Adding admin menu in main WordPress menu.
		 */
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wpgdrm_admin_menu' );

		/**
		 * Registering all plugin settings and options.
		 */
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wpgdrm_admin_init' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 */
	private function define_public_hooks() {

		$plugin_public = new Wpgdrm_Public( $this->get_plugin_name(), $this->get_version(), $this->get_icon()  );
		if($plugin_public->is_enable()){
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
			//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

			/**
			 * Showing featured in the content.
			 */
			$this->loader->add_filter( 'the_content', $plugin_public, 'wpgdrm_add_readmore');

			/**
			 * Showing featured in the content with shortcode. (in a version future)
			 */
			//$this->loader->add_shortcode( 'gd-read-more', $plugin_public, 'wpgdrm_add_readmore_shortcode' );
		}
	}

	/**
	 * Register all of the hooks related to the metabox area functionality
	 * of the plugin.
	 */
	private function define_metabox_hooks() {

		$plugin_admin = new Wpgdrm_Metabox( $this->get_plugin_name(), $this->get_version(), $this->get_icon() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		/**
		 * Registering metabox options.
		 */
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'wpgdrm_metabox_init' );

		/**
		 * Registering metabox save action.
		 */
		$this->loader->add_action( 'save_post', $plugin_admin, 'wpgdrm_metabox_save' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the icon of the plugin.
	 */
	public function get_icon() {
		return $this->icon;
	}


}
