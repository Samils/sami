<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Cli
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\Sami\Cli {

	if (!class_exists('Sammy\\Packs\\Sami\\Cli\\ArgumentBind')) {
	class ArgumentBind {

		protected $args = (
			null
		);
		/**
		 * [$argsi description]
		 * @var array
		 */
		protected $argsi = array (
		);

		function bind ($args, $str = null) {
			if (!(is_string($str) && $str))
				return;

			$this->args = is_array($args) ? $args : array (
			);
			$re = (
				'/\{\s*(([A-Za-z0-9\.\|\s]*))\s*\}/i'
			);

			return preg_replace_callback( $re, [$this, 'match'],
				$str
			);
		}

		protected function match ($match) {
			$index = $match[ 1 ];

			$index_slices = preg_split('/\|+/',
				trim( $index )
			);

			$index_core = trim($index_slices [
				0
			]);

			# If 'index_core' is a number
			# certainly it is the index to
			# get inside the 'args' array,
			# Get its values and apply the
			# filters if there is a some to
			# apply in it.
			if (is_numeric($index_core)) {
				# make sure the given index
				# eixists inside the 'args'
				# array, in order avoiding
				# errors when trying to use
				# the value for the given
				# index late.
				if (isset($this->args[$index_core])) {
					# Store that value inside the
					# 'args' variable in order
					# reusing it late when
					# applying the filters on it
					$arg = $this->args[
						$index_core
					];

					# Verify if there is a filter
					# to apply on the 'arg' variable.
					# Apply whole in a loop in order
					# returning it.
					if (count($index_slices) >= 2) {
						# apply filter
						$slices_len = count(
							$index_slices
						);
						for ($i = 1; $i < $slices_len; $i++) {
							$filter = \str(trim($index_slices[
								$i
							]));

							if (function_exists($filter)) {
								$arg = call_user_func_array($filter,
									[$arg]
								);
							}
						}
					}

					array_push($this->argsi,
						(int)$index_core
					);

					return (
						$arg
					);
				}

			} elseif ($index_core === '...') {
				$str = '';
				$args_count = count($this->args);

				for ($i = 0; $i < $args_count; $i++) {
					if (!in_array($i, $this->argsi)) {
						$str .= ' ' . $this->args[
							$i
						];
					}
				}

				return trim (
					$str
				);
			}

		}
	}}

	if (isset($module)) {
		$module->exports = (
			new ArgumentBind (
				... $args
			)
		);
	}
}
