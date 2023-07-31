<?php
/**
 * The template to display Admin notices
 *
 * @package FORTIUS
 * @since FORTIUS 1.0.64
 */

$fortius_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$fortius_skins_args = get_query_var( 'fortius_skins_notice_args' );
?>
<div class="fortius_admin_notice fortius_skins_notice notice notice-info is-dismissible" data-notice="skins">
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
		<?php esc_html_e( 'New skins available', 'fortius' ); ?>
	</h3>
	<?php

	// Description
	$fortius_total      = $fortius_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$fortius_skins_msg  = $fortius_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $fortius_total, 'fortius' ), $fortius_total ) . '</strong>'
							: '';
	$fortius_total      = $fortius_skins_args['free'];
	$fortius_skins_msg .= $fortius_total > 0
							? ( ! empty( $fortius_skins_msg ) ? ' ' . esc_html__( 'and', 'fortius' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $fortius_total, 'fortius' ), $fortius_total ) . '</strong>'
							: '';
	$fortius_total      = $fortius_skins_args['pay'];
	$fortius_skins_msg .= $fortius_skins_args['pay'] > 0
							? ( ! empty( $fortius_skins_msg ) ? ' ' . esc_html__( 'and', 'fortius' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $fortius_total, 'fortius' ), $fortius_total ) . '</strong>'
							: '';
	?>
	<div class="fortius_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'fortius' ), $fortius_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="fortius_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $fortius_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'fortius' );
			?>
		</a>
	</div>
</div>
