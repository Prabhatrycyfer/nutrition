<?php
$fortius_woocommerce_sc = fortius_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $fortius_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$fortius_scheme = fortius_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $fortius_scheme ) && ! fortius_is_inherit( $fortius_scheme ) ) {
			echo ' scheme_' . esc_attr( $fortius_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( fortius_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( fortius_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$fortius_css      = '';
			$fortius_bg_image = fortius_get_theme_option( 'front_page_woocommerce_bg_image' );
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
		$fortius_anchor_icon = fortius_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$fortius_anchor_text = fortius_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $fortius_anchor_icon ) || ! empty( $fortius_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $fortius_anchor_icon ) ? ' icon="' . esc_attr( $fortius_anchor_icon ) . '"' : '' )
											. ( ! empty( $fortius_anchor_text ) ? ' title="' . esc_attr( $fortius_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( fortius_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' fortius-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$fortius_css      = '';
				$fortius_bg_mask  = fortius_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$fortius_bg_color_type = fortius_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $fortius_bg_color_type ) {
					$fortius_bg_color = fortius_get_theme_option( 'front_page_woocommerce_bg_color' );
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
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$fortius_caption     = fortius_get_theme_option( 'front_page_woocommerce_caption' );
				$fortius_description = fortius_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $fortius_caption ) || ! empty( $fortius_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $fortius_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $fortius_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $fortius_caption, 'fortius_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $fortius_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $fortius_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $fortius_description ), 'fortius_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $fortius_woocommerce_sc ) {
						$fortius_woocommerce_sc_ids      = fortius_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$fortius_woocommerce_sc_per_page = count( explode( ',', $fortius_woocommerce_sc_ids ) );
					} else {
						$fortius_woocommerce_sc_per_page = max( 1, (int) fortius_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$fortius_woocommerce_sc_columns = max( 1, min( $fortius_woocommerce_sc_per_page, (int) fortius_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$fortius_woocommerce_sc}"
										. ( 'products' == $fortius_woocommerce_sc
												? ' ids="' . esc_attr( $fortius_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $fortius_woocommerce_sc
												? ' category="' . esc_attr( fortius_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $fortius_woocommerce_sc
												? ' orderby="' . esc_attr( fortius_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( fortius_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $fortius_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $fortius_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
