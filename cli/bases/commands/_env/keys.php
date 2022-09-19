<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Cli\env
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\Sami\Cli\env {
	/**
	 * Make sure the command base internal function is not
	 * declared in the php global scope defore creating
	 * it.
	 */
	if (!function_exists('Sammy\Packs\Sami\Cli\env\keys')){
	/**
	 * @function keys
	 * Base internal function for the
	 * Sami\Cli module command 'keys'.
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
	function keys ($args) {
		$keys = array_keys (
			ENV
		);

		$keyLen = count (
			$keys
		);

		foreach ($keys as $i => $key) {
			echo ("\n - {$key}\n");
		}

		exit ("\n \033[33m* Counts: $keyLen keys at .env.\033[0m\n");
	}}
}
