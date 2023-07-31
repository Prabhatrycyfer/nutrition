<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'fortius_booked_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'fortius_booked_theme_setup9', 9 );
	function fortius_booked_theme_setup9() {
		if ( fortius_exists_booked() ) {
			add_action( 'wp_enqueue_scripts', 'fortius_booked_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_booked', 'fortius_booked_frontend_scripts', 10, 1 );
			add_action( 'wp_enqueue_scripts', 'fortius_booked_frontend_scripts_responsive', 2000 );
			add_action( 'trx_addons_action_load_scripts_front_booked', 'fortius_booked_frontend_scripts_responsive', 10, 1 );
			add_filter( 'fortius_filter_merge_styles', 'fortius_booked_merge_styles' );
			add_filter( 'fortius_filter_merge_styles_responsive', 'fortius_booked_merge_styles_responsive' );
		}
		if ( is_admin() ) {
			add_filter( 'fortius_filter_tgmpa_required_plugins', 'fortius_booked_tgmpa_required_plugins' );
			add_filter( 'fortius_filter_theme_plugins', 'fortius_booked_theme_plugins' );
		}
	}
}


// Filter to add in the required plugins list
if ( ! function_exists( 'fortius_booked_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('fortius_filter_tgmpa_required_plugins',	'fortius_booked_tgmpa_required_plugins');
	function fortius_booked_tgmpa_required_plugins( $list = array() ) {
		if ( fortius_storage_isset( 'required_plugins', 'booked' ) && fortius_storage_get_array( 'required_plugins', 'booked', 'install' ) !== false && fortius_is_theme_activated() ) {
			$path = fortius_get_plugin_source_path( 'plugins/booked/booked.zip' );
			if ( ! empty( $path ) || fortius_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => fortius_storage_get_array( 'required_plugins', 'booked', 'title' ),
					'slug'     => 'booked',
					'source'   => ! empty( $path ) ? $path : 'upload://booked.zip',
					'version'  => '2.3',
					'required' => false,
				);
			}
		}
		return $list;
	}
}


// Filter theme-supported plugins list
if ( ! function_exists( 'fortius_booked_theme_plugins' ) ) {
	//Handler of the add_filter( 'fortius_filter_theme_plugins', 'fortius_booked_theme_plugins' );
	function fortius_booked_theme_plugins( $list = array() ) {
		return fortius_add_group_and_logo_to_slave( $list, 'booked', 'booked-' );
	}
}


// Check if plugin installed and activated
if ( ! function_exists( 'fortius_exists_booked' ) ) {
	function fortius_exists_booked() {
		return class_exists( 'booked_plugin' );
	}
}


// Return a relative path to the plugin styles depend the version
if ( ! function_exists( 'fortius_booked_get_styles_dir' ) ) {
	function fortius_booked_get_styles_dir( $file ) {
		$base_dir = 'plugins/booked/';
		return $base_dir
				. ( defined( 'BOOKED_VERSION' ) && version_compare( BOOKED_VERSION, '2.4', '<' ) && fortius_get_folder_dir( $base_dir . 'old' )
					? 'old/'
					: ''
					)
				. $file;
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'fortius_booked_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'fortius_booked_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_booked', 'fortius_booked_frontend_scripts', 10, 1 );
	function fortius_booked_frontend_scripts( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
			current_action() == 'wp_enqueue_scripts' && fortius_need_frontend_scripts( 'booked' )
			||
			current_action() != 'wp_enqueue_scripts' && $force === true
			)
		) {
			$loaded = true;
			$fortius_url = fortius_get_file_url( fortius_booked_get_styles_dir( 'booked.css' ) );
			if ( '' != $fortius_url ) {
				wp_enqueue_style( 'fortius-booked', $fortius_url, array(), null );
			}
		}
	}
}


// Enqueue responsive styles for frontend
if ( ! function_exists( 'fortius_booked_frontend_scripts_responsive' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'fortius_booked_frontend_scripts_responsive', 2000 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_booked', 'fortius_booked_frontend_scripts_responsive', 10, 1 );
	function fortius_booked_frontend_scripts_responsive( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
			current_action() == 'wp_enqueue_scripts' && fortius_need_frontend_scripts( 'booked' )
			||
			current_action() != 'wp_enqueue_scripts' && $force === true
			)
		) {
			$loaded = true;
			$fortius_url = fortius_get_file_url( fortius_booked_get_styles_dir( 'booked-responsive.css' ) );
			if ( '' != $fortius_url ) {
				wp_enqueue_style( 'fortius-booked-responsive', $fortius_url, array(), null, fortius_media_for_load_css_responsive( 'booked' ) );
			}
		}
	}
}


// Merge custom styles
if ( ! function_exists( 'fortius_booked_merge_styles' ) ) {
	//Handler of the add_filter('fortius_filter_merge_styles', 'fortius_booked_merge_styles');
	function fortius_booked_merge_styles( $list ) {
		$list[ fortius_booked_get_styles_dir( 'booked.css' ) ] = false;
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'fortius_booked_merge_styles_responsive' ) ) {
	//Handler of the add_filter('fortius_filter_merge_styles_responsive', 'fortius_booked_merge_styles_responsive');
	function fortius_booked_merge_styles_responsive( $list ) {
		$list[ fortius_booked_get_styles_dir( 'booked-responsive.css' ) ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( fortius_exists_booked() ) {
	$fortius_fdir = fortius_get_file_dir( fortius_booked_get_styles_dir( 'booked-style.php' ) );
	if ( ! empty( $fortius_fdir ) ) {
		require_once $fortius_fdir;
	}
}
