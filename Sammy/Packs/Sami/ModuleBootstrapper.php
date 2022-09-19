<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami
 * - Autoload, application dependencies
 *
 * MIT License
 *
 * Copyright (c) 2020 Ysare
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace Sammy\Packs\Sami {
  use Sami as Application;
  use ApplicationModule;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\ModuleBootstrapper')) {
  /**
   * @class ModuleBootstrapper
   * Base internal class for the
   * Sami module.
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
   */
  class ModuleBootstrapper {
    /**
     * @method void Bootstrap
     */
    public static function Bootstrap () {
      $i = 0;
      /**
       * [$globalClassesList description]
       * @var array
       */
      $globalClassesList = get_declared_classes();

      if (!$globalClassesList) {
        return;
      }

      $globalClassesListCount = count ($globalClassesList);

      for ( ; $i < $globalClassesListCount; $i++ ) {
        $className = $globalClassesList [$i];

        if (!in_array (ApplicationModule::class, class_parents($className))) {
          continue;
        }

        # Module name's the class
        # name without the 'Module'
        # sifix at the end of the
        # string, used to get the
        # module controller reference
        # inside the same namespace than
        # the module and craete a comuication
        # betwin them, order one know that
        # the other exists.
        $moduleName = preg_replace ('/(Module)$/i', '', $className);

        if (preg_match ('/(\\\+)$/i', $moduleName) || empty ($moduleName)) {
          exit ('Invalid module name');
        }

        # Look for a controller for the current
        # module in order configurating it based
        # on the controller and module properties
        $moduleControllerName = join ('', [$moduleName, 'Controller']);

        if (!Application::IsController ($moduleControllerName)) {

          echo $className, "\n\n";

          exit ('No controller found for the ' . $moduleName .
            ' module --> ' . __FILE__
          );
        }

        $className::initialize_props ();

        $moduleControllerName::RegisterModule ($className);

        if (!Application::ModExists ($moduleName)) {
          Application::Mod ($moduleName, []);
        }
      }
    }
  }}
}
