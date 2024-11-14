<?php
/**
 * Initializes the Theme
 *
 * @package KJR_Dev
 */

namespace KJR_Dev;

/** Builds the Theme */
class Theme_Init {
	/** Constructor Function that also loads the proper favicon package
	 */
	public function __construct() {
		$this->load_required_files();
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_theme_scripts' ) );
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
		add_action( 'init', array( $this, 'alter_post_types' ) );
		/**
		 * Filter the priority of the Yoast SEO metabox
		 */
		add_filter(
			'wpseo_metabox_prio',
			function (): string {
				return 'low';
			}
		);
	}


	/** Load required files. */
	private function load_required_files() {
		$base_path = get_template_directory() . '/includes';

		/** Loads the Theme Functions File (to keep the actual functions.php file clean) */
		require_once $base_path . '/theme/theme-functions.php';

		$asset_loaders = array(
			'enum-enqueue-type',
			'class-asset-loader',
		);
		foreach ( $asset_loaders as $asset_loader ) {
			require_once $base_path . "/theme/asset-loader/{$asset_loader}.php";
		}

		$navwalkers = array(
			'navwalker',
			// 'mega-menu',
		);
		foreach ( $navwalkers as $navwalker ) {
			require_once $base_path . "/theme/navwalkers/class-{$navwalker}.php";
		}

		$utility_files = array(
			'allow-svg'   => 'Allow_SVG',
			'role-editor' => 'Role_Editor',
		);
		foreach ( $utility_files as $utility_file => $class_name ) {
			require_once $base_path . "/theme/class-{$utility_file}.php";
			$class = __NAMESPACE__ . '\\' . $class_name;
			new $class();
		}
	}

	/**
	 * Adds scripts with the appropriate dependencies
	 */
	public function enqueue_theme_scripts() {
		new Asset_Loader(
			'bootstrap',
			Enqueue_Type::both,
			'vendors',
			array(
				'scripts' => array(),
				'styles'  => array(),
			)
		);

		new Asset_Loader(
			'global',
			Enqueue_Type::both,
			null,
			array(
				'scripts' => array( 'bootstrap' ),
				'styles'  => array( 'bootstrap' ),
			)
		);
		wp_localize_script( 'global', 'kjrSiteData', array( 'rootUrl' => home_url() ) );

		// style.css
		wp_enqueue_style(
			'main',
			get_stylesheet_uri(),
			array( 'global' ),
			wp_get_theme()->get( 'Version' )
		);
	}

	/** Registers Theme Supports */
	public function theme_support() {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );

		register_nav_menus(
			array(
				'primary_menu' => __( 'Primary Menu', 'kjr_dev' ),
				'footer_menu'  => __( 'Footer Menu', 'kjr_dev' ),
			)
		);
	}
}
