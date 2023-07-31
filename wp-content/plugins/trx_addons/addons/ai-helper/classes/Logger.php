<?php
namespace TrxAddons\AiHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class to log queries to the OpenAI API: used tokens in prompt, completion and total
 */
class Logger extends Singleton {

	var $log = array();

	/**
	 * Plugin constructor.
	 *
	 * @access protected
	 */
	protected function __construct() {
		parent::__construct();
		$saved = get_option( 'trx_addons_ai_helper_log' );
		if ( is_array( $saved ) ) {
			$this->log = $saved;
		}
	}

	/**
	 * Return an empty array with log entries for the model
	 * 
	 * @access private
	 * 
	 * @return array  Array with log entries for the model
	 */
	private function get_empty_log() {
		return array(
			'total_tokens' => 0,
			'prompt_tokens' => 0,
			'completion_tokens' => 0,
		);
	}

	/**
	 * Log a query results
	 * 
	 * @access public
	 * 
	 * @param array $response  Response from OpenAI API with completion and usage data
	 */
	public function log( $response, $type = 'chat', $args = array() ) {
		// Chat usage
		if ( ! empty( $response['model'] ) && ! empty( $response['usage'] ) ) {
			if ( empty( $this->log[ $response['model'] ] ) ) {
				$this->log[ $response['model'] ] = $this->get_empty_log();
			}
			foreach ( array_keys( $this->log[ $response['model'] ] ) as $k ) {
				if ( ! empty( $response['usage'][ $k ] ) ) {
					$this->log[ $response['model'] ][ $k ] += $response['usage'][ $k ];
				}
			}

		// Images usage
		} else {
			$number = 1;
			$size = ! empty( $args['size'] ) ? $args['size'] : 'unknown';
			if ( $type == 'images' ) {
				if ( ! empty( $response['data'] ) ) {
					$number = count( $response['data'] );
				}
				if ( empty( $this->log[ $type ] ) ) {
					$this->log[ $type ] = array();
				} else if ( ! is_array( $this->log[ $type ] ) ) {
					$this->log[ $type ] = array( 'unknown' => $this->log[ $type ] );
				}
				if ( empty( $this->log[ $type ][ $size ] ) ) {
					$this->log[ $type ][ $size ] = 0;
				}
				$this->log[ $type ][ $size ] += $number;
			} else {
				$this->log[ $type ] = ! empty( $this->log[ $type ] ) ? $this->log[ $type ] + 1 : 1;
			}
		}
		update_option( 'trx_addons_ai_helper_log', $this->log );
	}

	/**
	 * Get log
	 *
	 * @access public
	 * 
	 * @param string $model  Model name
	 * @param string $key    Key to get from log
	 * 
	 * @return int|array     Value from log for the specified model and key or whole log for the specified model or whole log for all models
	 */
	public function get_log( $model = '', $key = '' ) {
		if ( empty( $model ) ) {
			return $this->log;
		} else {
			foreach( $this->log as $m => $v ) {
				if ( strpos( $m, $model ) !== false ) {
					$model = $m;
					break;
				}
			}
			if ( empty( $key ) ) {
				return ! empty( $this->log[ $model ] )
						? $this->log[ $model ]
						: ( $model == 'images' ? 0 : $this->get_empty_log() );
			} else {
				return ! empty( $this->log[ $model ][ $key ] ) ? $this->log[ $model ][ $key ] : 0;
			}
		}
	}

	/**
	 * Get log as a report string
	 *
	 * @access public
	 */
	public function get_log_report() {
		$report = '';
		$log = $this->get_log();
		if ( is_array( $log ) ) {
			$report ='<br /><br />' . '<b><u>' .  __( 'Current usage of tokens:', 'trx_addons' ) . '</u></b>';
			foreach ( $log as $model => $tokens ) {
				if ( ! in_array( $model, array( 'images', 'chat' ) ) && is_array( $tokens ) ) {
					$report .= '<br />'
										. str_repeat( '&nbsp;', 4 )
										. '<tt>'
											. sprintf( __( 'Model "%1$s": <b>%2$d</b> ( %3$d in prompts, %4$d in completions )', 'trx_addons' ), $model, $tokens['total_tokens'], $tokens['prompt_tokens'], $tokens['completion_tokens'] )
										. '</tt>';
				}
			}
			$report .= '<br /><br />' . '<b><u>' . __( 'Images generated:', 'trx_addons' ) . '</u></b>';
			foreach ( $log as $model => $tokens ) {
				if ( $model == 'images' ) {
					if ( ! is_array( $tokens ) ) {
						$tokens = array( 'unknown' => $tokens );
					}
					foreach ( $tokens as $size => $count ) {
						$report .= '<br />'
										. str_repeat( '&nbsp;', 4 )
										. '<tt>'
											. sprintf( __( 'Size "%1$s": <b>%2$d</b>', 'trx_addons' ), $size, (int)$count )
										. '</tt>';
					}
				}
			}
		}
		return $report;
	}
}
