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
	/**
	 * Make sure the command base internal function is not
	 * declared in the php global scope defore creating
	 * it.
	 */
	if (!function_exists('Sammy\Packs\Sami\Cli\logger')){
	/**
	 * @function logger
	 * Base internal function for the
	 * Sami\Cli module command 'logger'.
	 * -
	 * This is (in the ils environment)
	 * an instance of the php module,
	 * wich should contain the module
	 * core functionalities that should
	 * be extended.
	 * -
	 * For extending the module, just create
	 * an 'exts' directory in the module directory
	 * and boot it by using the ils directory boot.
	 * -
	 * \Samils\dir_boot ('./exts');
	 * -
	 * @param array $args
	 * list of sent arguments to the
	 * current cli command.
	 */
	function logger ($args) {
		/**
		 * [$logfile description]
		 * @var string
		 */
		$logfile = __log__ . (
			'/puts.log'
		);

		if (!is_file($logfile)) {
			return null;
		}

		$loggerCurrentIterationIndex = 1;
		/**
		 * Make an infinite loop
		 */
		while ( $loggerCurrentIterationIndex++ ) {
			$fileContent = file_get_contents (
				$logfile
			);

			if (!empty ($fileContent)) {
				$out = requires ('out');
				$out->puts ($fileContent);


				@file_put_contents (
					$logfile, ''
				);
			}
		}
	}}
}
