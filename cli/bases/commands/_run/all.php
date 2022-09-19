<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Cli\run
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\Sami\Cli\run {
	/**
	 * Make sure the command base internal function is not
	 * declared in the php global scope defore creating
	 * it.
	 */
	if (!function_exists('Sammy\Packs\Sami\Cli\run\all')){
	/**
	 * @function all
	 * Base internal function for the
	 * Sami\Cli module command 'all'.
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
	function all ( $args ) {
		$options = array (
			'p' => false
		);
		/**
		 * Make sure '$args' is a
		 * non empty array
		 */
		if (!(is_array ($args) && $args)) {
			return;
		}

		$re = '/^-{1,3}([a-zA-Z0-9_\-]+)/';
		$commandList = array ();

		foreach ( $args as $arg ) {
			/**
			 * Verify of the current argument
			 * is an option
			 */
			if (preg_match ($re, $arg, $match)) {
				$options[ lower($match[1]) ] = true;
			} else {
				array_push ($commandList, $arg);
			}
		}

		$moduleConfs = requires ('<rootDir>/module.json');

		$moduleScriptConfigurationsSet = ( boolean ) (
			is_array($moduleConfs) &&
			isset ($moduleConfs['scripts']) &&
			is_array ($moduleConfs['scripts'])
		);

		if ( $moduleScriptConfigurationsSet ) {
			$scripts = $moduleConfs['scripts'];

			$commandSeparator = $options['p'] ? ' | ' : (
				' && '
			);

			$commandSynth = '';

			foreach ($commandList as $command) {
				$commandSynth .= $commandSeparator . (
					'php samils ' . $command
				);
			}

			$commandSynth = preg_replace ('/^(\s*(\\||&&))\s*/', '',
				$commandSynth
			);

			@system ($commandSynth);
		}
	}}
}
