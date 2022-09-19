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
  if (!function_exists('Sammy\Packs\Sami\Cli\server')){
  /**
   * @function server
   * Base internal function for the
   * Sami\Cli module command 'server'.
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
  function server ($args) {
    $arguments = join ($args, ' ');
    $portRe = '/-{1,3}p(ort|)\s+([0-9]+)/';
    $port = '7000';

    if (preg_match ($portRe, $arguments, $portMatch)) {
      $port = $portMatch [ 2 ];
    }

    $welcome_message = (
      ("\n - Samils Development Server\n") .
      ("\n - \033[1;32mRunning on http:/") .
      ("/localhost:{$port}.\033[0m\n\n")
    );

    echo ( $welcome_message );
    system ("php -S localhost:{$port} public/index.php");
  }}
}
