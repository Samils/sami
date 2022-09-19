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
	if (!function_exists('Sammy\Packs\Sami\Cli\version')){
	/**
	 * @function version
	 * Base internal function for the
	 * Sami\Cli module command 'version'.
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
	function version ($args) {
		$y = date ('Y');
		$content = array (
			null,
			'Samils, @Copright '. date ('Y'),
			' - version 1.0.12.3',
			' - CLI version 1.0.6'
		);

		foreach ($content as $p) {
			echo $p . "\n";
		}
		exit (0);
	}}
}
