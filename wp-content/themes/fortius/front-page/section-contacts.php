<div class="front_page_section front_page_section_contacts<?php
	$fortius_scheme = fortius_get_theme_option( 'front_page_contacts_scheme' );
	if ( ! empty( $fortius_scheme ) && ! fortius_is_inherit( $fortius_scheme ) ) {
		echo ' scheme_' . esc_attr( $fortius_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( fortius_get_theme_option( 'front_page_contacts_paddings' ) );
	if ( fortius_get_theme_option( 'front_page_contacts_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$fortius_css      = '';
		$fortius_bg_image = fortius_get_theme_option( 'front_page_contacts_bg_image' );
		if ( ! empty( $fortius_bg_image ) ) {
			$fortius_css .= 'background-image: url(' . esc_url( fortius_get_attachment_url( $fortius_bg_image ) ) . ');';
		}
		if ( ! empty( $fortius_css ) ) {
			echo ' style="' . esc_attr( $fortius_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$fortius_anchor_icon = fortius_get_theme_option( 'front_page_contacts_anchor_icon' );
	$fortius_anchor_text = fortius_get_theme_option( 'front_page_contacts_anchor_text' );
if ( ( ! empty( $fortius_anchor_icon ) || ! empty( $fortius_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_contacts"'
									. ( ! empty( $fortius_anchor_icon ) ? ' icon="' . esc_attr( $fortius_anchor_icon ) . '"' : '' )
									. ( ! empty( $fortius_anchor_text ) ? ' title="' . esc_attr( $fortius_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_contacts_inner
	<?php
	if ( fortius_get_theme_option( 'front_page_contacts_fullheight' ) ) {
		echo ' fortius-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$fortius_css      = '';
			$fortius_bg_mask  = fortius_get_theme_option( 'front_page_contacts_bg_mask' );
			$fortius_bg_color_type = fortius_get_theme_option( 'front_page_contacts_bg_color_type' );
			if ( 'custom' == $fortius_bg_color_type ) {
				$fortius_bg_color = fortius_get_theme_option( 'front_page_contacts_bg_color' );
			} elseif ( 'scheme_bg_color' == $fortius_bg_color_type ) {
				$fortius_bg_color = fortius_get_scheme_color( 'bg_color', $fortius_scheme );
			} else {
				$fortius_bg_color = '';
			}
			if ( ! empty( $fortius_bg_color ) && $fortius_bg_mask > 0 ) {
				$fortius_css .= 'background-color: ' . esc_attr(
					1 == $fortius_bg_mask ? $fortius_bg_color : fortius_hex2rgba( $fortius_bg_color, $fortius_bg_mask )
				) . ';';
			}
			if ( ! empty( $fortius_css ) ) {
				echo ' style="' . esc_attr( $fortius_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$fortius_caption     = fortius_get_theme_option( 'front_page_contacts_caption' );
			$fortius_description = fortius_get_theme_option( 'front_page_contacts_description' );
			if ( ! empty( $fortius_caption ) || ! empty( $fortius_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $fortius_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo ! empty( $fortius_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $fortius_caption, 'fortius_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description
				if ( ! empty( $fortius_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo ! empty( $fortius_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $fortius_description ), 'fortius_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$fortius_content = fortius_get_theme_option( 'front_page_contacts_content' );
			$fortius_layout  = fortius_get_theme_option( 'front_page_contacts_layout' );
			if ( 'columns' == $fortius_layout && ( ! empty( $fortius_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ( ( ! empty( $fortius_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo ! empty( $fortius_content ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $fortius_content, 'fortius_kses_content' );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $fortius_layout && ( ! empty( $fortius_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div><div class="column-2_3">
				<?php
			}

			// Shortcode output
			$fortius_sc = fortius_get_theme_option( 'front_page_contacts_shortcode' );
			if ( ! empty( $fortius_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo ! empty( $fortius_sc ) ? 'filled' : 'empty'; ?>">
					<?php
					fortius_show_layout( do_shortcode( $fortius_sc ) );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $fortius_layout && ( ! empty( $fortius_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>

		</div>
	</div>
</div>
