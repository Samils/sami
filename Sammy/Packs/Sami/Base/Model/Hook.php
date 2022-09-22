<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base\Model
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
namespace Sammy\Packs\Sami\Base\Model {
  use Exception;
  use Closure;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Base\Model\Hook')) {
  /**
   * @trait Hook
   * Base internal trait for the
   * Sami\Base\Model module.
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
  trait Hook {
    /**
     * @var array $SamiBaseHooks
     */
    private static $SamiBaseHooks = [
      []
    ];

    /**
     * @method boolean addHook
     * @version 0.1
     * @author Sammy
     * @return boolean
     */
    public static function addHook ($hookName, $deleteOnHandle = false) {
      $handler = func_get_arg (func_num_args() - 1);
      $deleteOnHandle = !is_bool($deleteOnHandle) ? false : (
        $deleteOnHandle
      );

      if (!($handler instanceof Closure)) {
        return false;
      }

      $hookDefaultProps = array (
        'handler' => $handler,
        'deleteOnHandle' => $deleteOnHandle
      );

      if ( is_string ($hookName) && !empty($hookName) ) {
        self::$SamiBaseHooks [ strtolower( $hookName ) ] = array_merge (
          $hookDefaultProps, [ 'name' => 'hook' . $hookName ]
        );

        return true;
      }

      return self::$SamiBaseHooks[0][] = $hookDefaultProps;
    }

    private static function handleGlobalHooks () {
      $hooks = self::$SamiBaseHooks[ 0 ];
      $hooksCount = count ($hooks);

      for ($i = 0; $i < $hooksCount; $i++) {
        $hook = $hooks[ $i ];

        $validHook = ( boolean ) (
          is_array ($hook) &&
          isset($hook['handler']) &&
          is_callable($hook['handler'])
        );

        if ( $validHook ) {

          $deleteOnHandle = ( boolean ) (
            isset ($hook['deleteOnHandle']) &&
            is_bool($hook['deleteOnHandle']) &&
            $hook['deleteOnHandle']
          );

          if ( $deleteOnHandle ) {
            unset (self::$SamiBaseHooks[0][ $i ]);
          }

          call_user_func_array ( $hook[ 'handler' ], [] );
        }
      }
    }
  }}
}
