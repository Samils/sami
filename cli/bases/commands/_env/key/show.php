<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Cli\env\key
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\Sami\Cli\env\key {
	/**
	 * Make sure the command base internal function is not
	 * declared in the php global scope defore creating
	 * it.
	 */
	if (!function_exists('Sammy\Packs\Sami\Cli\env\key\show')){
	/**
	 * @function show
	 * Base internal function for the
	 * Sami\Cli module command 'show'.
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
	function show ($args) {
		if (!(is_array($args) && $args))
			return;

		$var = $args [0];

		$dotEnvFile = __root__ . (
			DIRECTORY_SEPARATOR . '.env'
		);

		if (is_file ($dotEnvFile)) {
			$dotEnvFileContet = \Saml::FileContent (
				$dotEnvFile
			);

			$dotEnvFileContet = preg_split('/\n+/',
				preg_replace ('/(\s+)$/', '',
					$dotEnvFileContet
				)
			);

			$file = new \File ($dotEnvFile, 'w');
			$varDefinedInDotEnv = false;
			$newFileContent = '';
			$message = ("\n'{$var}' now shown at: .env file.\n");

			foreach ($dotEnvFileContet as $line) {
				$lineContent = $line;


				if (preg_match ('/^([^=]+)/', $line, $keyMatch)) {
					$key = rtrim($keyMatch [0]);

					if (!empty(trim($key)) && preg_match ('/^#/', $key)) {
						$commentRe = '/^(#\s*)/';

						$hidenVarName = preg_replace ($commentRe, '',
							$key
						);

						if (trim($hidenVarName) === $var) {
							$lineContent = preg_replace ($commentRe, '',
								$lineContent
							);

							$varDefinedInDotEnv = true;
						}
					}
				}

				$file->writeLine ($lineContent);
			}

			if (!$varDefinedInDotEnv) {
				return print ("\n'{$var}' is not defined at .env file.\n");
			}

			echo $message;
		}
	}}
}
