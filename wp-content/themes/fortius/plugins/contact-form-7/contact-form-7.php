<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'fortius_cf7_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'fortius_cf7_theme_setup9', 9 );
	function fortius_cf7_theme_setup9() {
		if ( fortius_exists_cf7() ) {
			add_action( 'wp_enqueue_scripts', 'fortius_cf7_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_cf7', 'fortius_cf7_frontend_scripts', 10, 1 );
			add_filter( 'fortius_filter_merge_styles', 'fortius_cf7_merge_styles' );
			add_filter( 'fortius_filter_merge_scripts', 'fortius_cf7_merge_scripts' );
		}
		if ( is_admin() ) {
			add_filter( 'fortius_filter_tgmpa_required_plugins', 'fortius_cf7_tgmpa_required_plugins' );
			add_filter( 'fortius_filter_theme_plugins', 'fortius_cf7_theme_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'fortius_cf7_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('fortius_filter_tgmpa_required_plugins',	'fortius_cf7_tgmpa_required_plugins');
	function fortius_cf7_tgmpa_required_plugins( $list = array() ) {
		if ( fortius_storage_isset( 'required_plugins', 'contact-form-7' ) && fortius_storage_get_array( 'required_plugins', 'contact-form-7', 'install' ) !== false ) {
			// CF7 plugin
			$list[] = array(
				'name'     => fortius_storage_get_array( 'required_plugins', 'contact-form-7', 'title' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			);
		}
		return $list;
	}
}

// Filter theme-supported plugins list
if ( ! function_exists( 'fortius_cf7_theme_plugins' ) ) {
	//Handler of the add_filter( 'fortius_filter_theme_plugins', 'fortius_cf7_theme_plugins' );
	function fortius_cf7_theme_plugins( $list = array() ) {
		return fortius_add_group_and_logo_to_slave( $list, 'contact-form-7', 'contact-form-7-' );
	}
}



// Check if cf7 installed and activated
if ( ! function_exists( 'fortius_exists_cf7' ) ) {
	function fortius_exists_cf7() {
		return class_exists( 'WPCF7' );
	}
}

// Enqueue custom scripts
if ( ! function_exists( 'fortius_cf7_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'fortius_cf7_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_cf7', 'fortius_cf7_frontend_scripts', 10, 1 );
	function fortius_cf7_frontend_scripts( $force = false ) {
		static $loaded = false;
		if ( ! $loaded && (
			current_action() == 'wp_enqueue_scripts' && fortius_need_frontend_scripts( 'cf7' )
			||
			current_action() != 'wp_enqueue_scripts' && $force === true
			)
		) {
			$loaded = true;
			$fortius_url = fortius_get_file_url( 'plugins/contact-form-7/contact-form-7.css' );
			if ( '' != $fortius_url ) {
				wp_enqueue_style( 'fortius-contact-form-7', $fortius_url, array(), null );
			}
			$fortius_url = fortius_get_file_url( 'plugins/contact-form-7/contact-form-7.js' );
			if ( '' != $fortius_url ) {
				wp_enqueue_script( 'fortius-contact-form-7', $fortius_url, array( 'jquery' ), null, true );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'fortius_cf7_merge_styles' ) ) {
	//Handler of the add_filter('fortius_filter_merge_styles', 'fortius_cf7_merge_styles');
	function fortius_cf7_merge_styles( $list ) {
		$list[ 'plugins/contact-form-7/contact-form-7.css' ] = false;
		return $list;
	}
}

// Merge custom scripts
if ( ! function_exists( 'fortius_cf7_merge_scripts' ) ) {
	//Handler of the add_filter('fortius_filter_merge_scripts', 'fortius_cf7_merge_scripts');
	function fortius_cf7_merge_scripts( $list ) {
		$list[ 'plugins/contact-form-7/contact-form-7.js' ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( fortius_exists_cf7() ) {
	$fortius_fdir = fortius_get_file_dir( 'plugins/contact-form-7/contact-form-7-style.php' );
	if ( ! empty( $fortius_fdir ) ) {
		require_once $fortius_fdir;
	}
}
