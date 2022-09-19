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
  use php\module;
  /**
   * Make sure the command base internal function is not
   * declared in the php global scope defore creating
   * it.
   */
  if (!function_exists('Sammy\Packs\Sami\Cli\help')){
  /**
   * @function help
   * Base internal function for the
   * Sami\Cli module command 'help'.
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
  function help ($args) {
    #echo "\nILS HELPS\n";
    #module::config ('root path', __DIR__);
    #module::config ('app name', 'Samils App');
    #module::config ('moduleName', 'php module');
    #module::config ('app dir', __appdir);
    #module::definePath ('<base>', __DIR__);
    #module::definePath ('/(mundo(Dir)?)/i', '<rootDir>/mundo');
    #$moduleConfigs = module::getConfigData ('appName', 'rootPath');
    #$pathToAFile = module::readPath ('<<<<<</config\\app/teste.yaml', [
    #    ['file' => __FILE__]
    #]);
    #echo "\n\n\nPATH => $pathToAFile\n\n\n\n";

    $teste = requires ('~/teste.yaml');
    print_r($teste);

  }}
}
