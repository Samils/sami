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
	 * Make sure the command base internal class is not
	 * declared in the php global scope defore creating
	 * it.
	 */
	if (!class_exists('Sammy\Packs\Sami\Cli\env')){
	/**
	 * @class env
	 * Base internal class for the
	 * Sami\Cli module command 'env'.
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
	class env {
		/**
		 * [def description]
		 * @return null
		 */
		function def ($args) {
			if (!(is_array($args) && $args))
				return;

			$var = $args [0];
			$value = join (' ',
				array_slice($args, 1, count($args))
			);

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
				$message = ("\n'{$var}' defined at: .env file.\n");

				foreach ($dotEnvFileContet as $line) {
					$lineContent = $line;


					if (preg_match ('/^([^=]+)/', $line, $keyMatch)) {
						$key = rtrim($keyMatch [0]);

						if (!empty(trim($key)) && !preg_match ('/^#/', $key)) {
							if ($key === $var) {
								$message = (
									("\n'{$key}' updated at: .env file.\n")
								);
								$lineContent = ("$key=$value");
								$varDefinedInDotEnv = true;
							}
						}
					}

					$file->writeLine ($lineContent);
				}

				if (!$varDefinedInDotEnv) {
					$file->writeLine ("$var=$value");
				}

				echo $message;
			}
		}

		function set () {
			return call_user_func_array (
				[$this, 'def'], func_get_args()
			);
		}
	}}
}
