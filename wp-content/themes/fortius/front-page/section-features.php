<div class="front_page_section front_page_section_features<?php
	$fortius_scheme = fortius_get_theme_option( 'front_page_features_scheme' );
	if ( ! empty( $fortius_scheme ) && ! fortius_is_inherit( $fortius_scheme ) ) {
		echo ' scheme_' . esc_attr( $fortius_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( fortius_get_theme_option( 'front_page_features_paddings' ) );
	if ( fortius_get_theme_option( 'front_page_features_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$fortius_css      = '';
		$fortius_bg_image = fortius_get_theme_option( 'front_page_features_bg_image' );
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
	$fortius_anchor_icon = fortius_get_theme_option( 'front_page_features_anchor_icon' );
	$fortius_anchor_text = fortius_get_theme_option( 'front_page_features_anchor_text' );
if ( ( ! empty( $fortius_anchor_icon ) || ! empty( $fortius_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_features"'
									. ( ! empty( $fortius_anchor_icon ) ? ' icon="' . esc_attr( $fortius_anchor_icon ) . '"' : '' )
									. ( ! empty( $fortius_anchor_text ) ? ' title="' . esc_attr( $fortius_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_features_inner
	<?php
	if ( fortius_get_theme_option( 'front_page_features_fullheight' ) ) {
		echo ' fortius-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$fortius_css      = '';
			$fortius_bg_mask  = fortius_get_theme_option( 'front_page_features_bg_mask' );
			$fortius_bg_color_type = fortius_get_theme_option( 'front_page_features_bg_color_type' );
			if ( 'custom' == $fortius_bg_color_type ) {
				$fortius_bg_color = fortius_get_theme_option( 'front_page_features_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_features_content_wrap content_wrap">
			<?php
			// Caption
			$fortius_caption = fortius_get_theme_option( 'front_page_features_caption' );
			if ( ! empty( $fortius_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_features_caption front_page_block_<?php echo ! empty( $fortius_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $fortius_caption, 'fortius_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$fortius_description = fortius_get_theme_option( 'front_page_features_description' );
			if ( ! empty( $fortius_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_features_description front_page_block_<?php echo ! empty( $fortius_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $fortius_description ), 'fortius_kses_content' ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_features_output">
				<?php
				if ( is_active_sidebar( 'front_page_features_widgets' ) ) {
					dynamic_sidebar( 'front_page_features_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! fortius_exists_trx_addons() ) {
						fortius_customizer_need_trx_addons_message();
					} else {
						fortius_customizer_need_widgets_message( 'front_page_features_caption', 'ThemeREX Addons - Services' );
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
