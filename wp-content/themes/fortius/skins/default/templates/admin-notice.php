<?php
/**
 * The template to display Admin notices
 *
 * @package FORTIUS
 * @since FORTIUS 1.0.1
 */

$fortius_theme_slug = get_option( 'template' );
$fortius_theme_obj  = wp_get_theme( $fortius_theme_slug );
?>
<div class="fortius_admin_notice fortius_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$fortius_theme_img = fortius_get_file_url( 'screenshot.jpg' );
	if ( '' != $fortius_theme_img ) {
		?>
		<div class="fortius_notice_image"><img src="<?php echo esc_url( $fortius_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'fortius' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="fortius_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'fortius' ),
				$fortius_theme_obj->get( 'Name' ) . ( FORTIUS_THEME_FREE ? ' ' . __( 'Free', 'fortius' ) : '' ),
				$fortius_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="fortius_notice_text">
		<p class="fortius_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $fortius_theme_obj->description ) );
			?>
		</p>
		<p class="fortius_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'fortius' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="fortius_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=fortius_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'fortius' );
			?>
		</a>
	</div>
</div>
