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
  use Sammy\Packs\Sami\Module\Scope;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Module')) {
  /**
   * @class Module
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
  class Module {
    use Module\Base;
    use Module\Props;

    /**
     * @method void __construct
     *
     * Initialize the Module class context.
     *
     * @param array $props
     *
     * A set of props for configurating
     * the current module object.
     *
     */
    public function __construct ($props = []) {
      /**
       *
       * Make sure the sent '$props' argument is an
       * array and it contain a 'RestryingControllerName'
       * key whish should be the module controller name as
       * a string in order using it to register the module
       * core object into the Samils application bootstrapper.
       *
       * As a string, the controller name could be sufixed with
       * the 'Controller' keyword or not and used without the
       * sufix when registering it in the Samils Application
       * Bootstrapper.
       *
       */
      if (is_array ($props) && isset ($props ['RestryingControllerName'])) {

        /**
         * @var string $controllerName
         *
         * Registry controler name.
         *
         */
        $controllerName = $props ['RestryingControllerName'];

        $moduleName = strtolower (static::class);
        $controllerName = preg_replace ('/(Controller)$/i', '', $controllerName);

        if (Application::IsController ($controllerName)) {
          array_push (
            self::$ApplicationModuleBase [$moduleName],
            Application::Mod ($controllerName)
          );
        }
      }
    }
  }}
}
