<?php
namespace TrxAddons\AiHelper;

if ( ! class_exists( 'Options' ) ) {

	/**
	 * Add options to the ThemeREX Addons Options
	 */
	class Options {

		/**
		 * Constructor
		 */
		function __construct() {
			add_filter( 'trx_addons_filter_options', array( $this, 'add_options' ) );
			add_filter( 'trx_addons_filter_before_show_options', array( $this, 'fix_options' ) );
			add_filter( 'trx_addons_filter_export_options', array( $this, 'remove_token_from_export' ) );
		}

		/**
		 * Add options to the ThemeREX Addons Options
		 * 
		 * @hooked trx_addons_filter_options
		 *
		 * @param array $options  Array of options
		 * 
		 * @return array  	  Modified array of options
		 */
		function add_options( $options ) {
			$usage_tokens = Logger::instance()->get_log_report();
			trx_addons_array_insert_before( $options, 'sc_section', apply_filters( 'trx_addons_filter_options_ai_helper', array(
				'ai_helper_section' => array(
					"title" => esc_html__('AI Helper', 'trx_addons'),
					'icon' => 'trx_addons_icon-android',
					"type" => "section"
				),

				// Common settings
				'ai_helper_info' => array(
					"title" => esc_html__('AI Helper', 'trx_addons'),
					"desc" => wp_kses_data( __("Settings of the AI Helper.", 'trx_addons') )
							. ( ! empty( $usage_tokens ) ? wp_kses( $usage_tokens, 'trx_addons_kses_content' ) : '' ),
					"type" => "info"
				),
				'ai_helper_token_openai' => array(
					"title" => esc_html__('Open AI token', 'trx_addons'),
					"desc" => wp_kses( sprintf(
													__('Specify a token to use the OpenAI API. You can generate a token in your personal account using the link %s', 'trx_addons'),
													apply_filters( 'trx_addons_filter_openai_api_key_url',
																	'<a href="https://beta.openai.com/account/api-keys" target="_blank">https://beta.openai.com/account/api-keys</a>'
																)
												),
										'trx_addons_kses_content'
									),
					"std" => "",
					"type" => "text"
				),
				'ai_helper_model_openai' => array(
					"title" => esc_html__('Open AI model', 'trx_addons'),
					"desc" => wp_kses_data( __('Select a model to use with OpenAI API', 'trx_addons') ),
					"std" => "gpt-3.5-turbo",
					"options" => apply_filters( 'trx_addons_filter_ai_helper_list_models', Lists::get_list_ai_models() ),
					"type" => "select"
				),
				'ai_helper_temperature' => array(
					"title" => esc_html__('Temperature', 'trx_addons'),
					"desc" => wp_kses_data( __('Select a temperature to use with OpenAI API queries in the editor.', 'trx_addons') )
							. '<br />'
							. wp_kses_data( __('What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.', 'trx_addons') ),
					"std" => 1.0,
					"min" => 0,
					"max" => 2.0,
					"step" => 0.1,
					"type" => "slider"
				),
				
				// Image Generator
				'ai_helper_sc_igenerator_info' => array(
					"title" => esc_html__('Shortcode IGenerator', 'trx_addons'),
					"type" => "info"
				),
				'ai_helper_sc_igenerator_limit_per_hour' => array(
					"title" => esc_html__('Images per 1 hour', 'trx_addons'),
					"desc" => wp_kses_data( __('How many images can all visitors generate in 1 hour?', 'trx_addons') ),
					"std" => 12,
					"min" => 0,
					"max" => 1000,
					"type" => "slider"
				),
				'ai_helper_sc_igenerator_limit_per_visitor' => array(
					"title" => esc_html__('Requests from 1 visitor', 'trx_addons'),
					"desc" => wp_kses_data( __('How many requests can send a single visitor in 1 hour?', 'trx_addons') ),
					"std" => 2,
					"min" => 0,
					"max" => 100,
					"type" => "slider"
				),

				// Text Generator
				'ai_helper_sc_tgenerator_info' => array(
					"title" => esc_html__('Shortcode TGenerator', 'trx_addons'),
					"type" => "info"
				),
				'ai_helper_sc_tgenerator_temperature' => array(
					"title" => esc_html__('Temperature', 'trx_addons'),
					"desc" => wp_kses_data( __('What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.', 'trx_addons') ),
					"std" => 1,
					"min" => 0,
					"max" => 2,
					"step" => 0.1,
					"type" => "slider"
				),
				'ai_helper_sc_tgenerator_limit_per_request' => array(
					"title" => esc_html__('Max. tokens per 1 request', 'trx_addons'),
					"desc" => wp_kses_data( __('How many tokens can be used per one request to the API?', 'trx_addons') ),
					"std" => 1000,
					"min" => 0,
					"max" => 32000,
					"step" => 100,
					"type" => "slider"
				),
				'ai_helper_sc_tgenerator_limit_per_hour' => array(
					"title" => esc_html__('Requests per 1 hour', 'trx_addons'),
					"desc" => wp_kses_data( __('How many requests can be processed for all visitors in 1 hour?', 'trx_addons') ),
					"std" => 8,
					"min" => 0,
					"max" => 1000,
					"type" => "slider"
				),
				'ai_helper_sc_tgenerator_limit_per_visitor' => array(
					"title" => esc_html__('Requests from 1 visitor', 'trx_addons'),
					"desc" => wp_kses_data( __('How many requests can send a single visitor in 1 hour?', 'trx_addons') ),
					"std" => 2,
					"min" => 0,
					"max" => 100,
					"type" => "slider"
				),

				// Chat
				'ai_helper_sc_chat_info' => array(
					"title" => esc_html__('Shortcode AI Chat', 'trx_addons'),
					"type" => "info"
				),
				'ai_helper_sc_chat_temperature' => array(
					"title" => esc_html__('Temperature', 'trx_addons'),
					"desc" => wp_kses_data( __('What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.', 'trx_addons') ),
					"std" => 1,
					"min" => 0,
					"max" => 2,
					"step" => 0.1,
					"type" => "slider"
				),
				'ai_helper_sc_chat_limit_per_request' => array(
					"title" => esc_html__('Max. tokens per 1 request', 'trx_addons'),
					"desc" => wp_kses_data( __('How many tokens can be used per one request to the chat?', 'trx_addons') ),
					"std" => 1000,
					"min" => 0,
					"max" => 32000,
					"step" => 100,
					"type" => "slider"
				),
				'ai_helper_sc_chat_limit_per_hour' => array(
					"title" => esc_html__('Requests per 1 hour', 'trx_addons'),
					"desc" => wp_kses_data( __('How many requests can be processed for all visitors in 1 hour?', 'trx_addons') ),
					"std" => 80,
					"min" => 0,
					"max" => 1000,
					"type" => "slider"
				),
				'ai_helper_sc_chat_limit_per_visitor' => array(
					"title" => esc_html__('Requests from 1 visitor', 'trx_addons'),
					"desc" => wp_kses_data( __('How many requests can send a single visitor in 1 hour?', 'trx_addons') ),
					"std" => 10,
					"min" => 0,
					"max" => 100,
					"type" => "slider"
				),
			) ) );

			return $options;
		}

		/**
		 * Fix option params in the ThemeREX Addons Options
		 * 
		 * @hooked trx_addons_filter_before_show_options
		 *
		 * @param array $options  Array of options
		 * 
		 * @return array  	  Modified array of options
		 */
		function fix_options( $options ) {
			$max_tokens = OpenAI::get_max_tokens();
			if ( ! empty( $options['ai_helper_sc_tgenerator_limit_per_request']['std'] ) && $options['ai_helper_sc_tgenerator_limit_per_request']['std'] > $max_tokens ) {
				$options['ai_helper_sc_tgenerator_limit_per_request']['std'] = $max_tokens;
			}
			if ( ! empty( $options['ai_helper_sc_tgenerator_limit_per_request']['val'] ) && $options['ai_helper_sc_tgenerator_limit_per_request']['val'] > $max_tokens ) {
				$options['ai_helper_sc_tgenerator_limit_per_request']['val'] = $max_tokens;
			}
			if ( ! empty( $options['ai_helper_sc_tgenerator_limit_per_request']['max'] ) ) {
				$options['ai_helper_sc_tgenerator_limit_per_request']['max'] = $max_tokens;
			}
			if ( ! empty( $options['ai_helper_sc_chat_limit_per_request']['std'] ) && $options['ai_helper_sc_chat_limit_per_request']['std'] > $max_tokens ) {
				$options['ai_helper_sc_chat_limit_per_request']['std'] = $max_tokens;
			}
			if ( ! empty( $options['ai_helper_sc_chat_limit_per_request']['val'] ) && $options['ai_helper_sc_chat_limit_per_request']['val'] > $max_tokens ) {
				$options['ai_helper_sc_chat_limit_per_request']['val'] = $max_tokens;
			}
			if ( ! empty( $options['ai_helper_sc_chat_limit_per_request']['max'] ) ) {
				$options['ai_helper_sc_chat_limit_per_request']['max'] = $max_tokens;
			}
			return $options;
		}

		/**
		 * Clear some addon specific options before export
		 * 
		 * @hooked trx_addons_filter_export_options
		 * 
		 * @param array $options  Array of options
		 * 
		 * @return array  	  Modified array of options
		 */
		 function remove_token_from_export( $options ) {
			if ( isset( $options['trx_addons_ai_helper_log'] ) ) {
				unset( $options['trx_addons_ai_helper_log'] );
			}
			if ( ! empty( $options['trx_addons_options']['ai_helper_token_openai'] ) ) {
				$options['trx_addons_options']['ai_helper_token_openai'] = '';
			}
			return $options;
		}
	}
}
