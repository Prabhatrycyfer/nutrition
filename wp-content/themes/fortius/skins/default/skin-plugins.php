<?php
/**
 * Required plugins
 *
 * @package FORTIUS
 * @since FORTIUS 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$fortius_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'fortius' ),
	'page_builders' => esc_html__( 'Page Builders', 'fortius' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'fortius' ),
	'socials'       => esc_html__( 'Socials and Communities', 'fortius' ),
	'events'        => esc_html__( 'Events and Appointments', 'fortius' ),
	'content'       => esc_html__( 'Content', 'fortius' ),
	'other'         => esc_html__( 'Other', 'fortius' ),
);
$fortius_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'fortius' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'fortius' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $fortius_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'fortius' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'fortius' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $fortius_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'fortius' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'fortius' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $fortius_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'fortius' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'fortius' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $fortius_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'fortius' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'fortius' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'woocommerce.png',
		'group'       => $fortius_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'fortius' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'fortius' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'elegro-payment.png',
		'group'       => $fortius_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'fortius' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'fortius' ),
		'required'    => false,
		'logo'        => 'instagram-feed.png',
		'group'       => $fortius_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'fortius' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'fortius' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $fortius_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'fortius' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'booked.png',
		'group'       => $fortius_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'fortius' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'the-events-calendar.png',
		'group'       => $fortius_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'fortius' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'fortius' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $fortius_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'fortius' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => fortius_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $fortius_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'fortius' ),
		'description' => '',
		'required'    => false,
		'logo'        => fortius_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $fortius_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'fortius' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => fortius_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $fortius_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'fortius' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => fortius_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $fortius_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'fortius' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => fortius_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $fortius_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'fortius' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => fortius_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $fortius_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'fortius' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $fortius_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'fortius' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $fortius_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'fortius' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'fortius' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $fortius_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'fortius' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'fortius' ),
		'required'    => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $fortius_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'fortius' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'fortius' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $fortius_theme_required_plugins_groups['other'],
	),
);

if ( FORTIUS_THEME_FREE ) {
	unset( $fortius_theme_required_plugins['js_composer'] );
	unset( $fortius_theme_required_plugins['booked'] );
	unset( $fortius_theme_required_plugins['the-events-calendar'] );
	unset( $fortius_theme_required_plugins['calculated-fields-form'] );
	unset( $fortius_theme_required_plugins['essential-grid'] );
	unset( $fortius_theme_required_plugins['revslider'] );
	unset( $fortius_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $fortius_theme_required_plugins['trx_updater'] );
	unset( $fortius_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
fortius_storage_set( 'required_plugins', $fortius_theme_required_plugins );
