<?php
/**
 *
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Cli\samils\dev\server
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\Sami\Cli\samils\dev\server {
	/**
	 * Make sure the command base internal function is not
	 * declared in the php global scope defore creating
	 * it.
	 */
	if (!function_exists('Sammy\Packs\Sami\Cli\samils\dev\server\start')){
	/**
	 * @function start
	 * Base internal function for the
	 * Sami\Cli module command 'start'.
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
	function start ($args) {
		/**
		 * Execute run:all
		 */
		\Samils\Application\Cli\Execute (
			['run:all', '--p', 'serve:dev', 'xsami-dev-server']
		);
	}}
}
