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
  use Sami;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\RouteFactory')) {
  /**
   * @class RouteFactory
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
  class RouteFactory {
    use RouteFactory\Rest;
    /**
     * @method mixed Factory
     */
    public static function Factory ($routeMethod, $backTrace) {

      if (!self::validTrace ($backTrace)) {
        $backTrace = debug_backtrace ();
      }

      $trace = (array)$backTrace [0];
      $funcArgs = $trace ['args'];

      $path = $funcArgs ? $funcArgs [0] : null;
      $ca = !(count ($funcArgs) >= 2) ? null : (
        $funcArgs [-1 + count ($funcArgs)]
      );

      if (is_string ($path)) {
        list ($path, $ca) = self::rewriteRoutePath ($backTrace, $path, $ca);

        $app = Sami::ApplicationModule ();

        if (method_exists ($app, $routeMethod)) {
          return call_user_func_array ([$app, $routeMethod], [$path, $ca, $backTrace]);
        }
      }
    }

    public static function rewriteRoutePath ($backTrace = null, $path = null, $ca = null) {
      $traceClosureArgumentsElementIndex = 0;

      if (isset ($backTrace[$traceClosureArgumentsElementIndex]) && is_array ($backTrace [$traceClosureArgumentsElementIndex]) && isset ($backTrace[$traceClosureArgumentsElementIndex]['function'])) {

        $funcRe = '/^(Application\\\Routes\\\Drawing\\\([a-z]+))$/i';

        /**
         * Make sure, the current flux is inside a php closure
         * inside the Application\Routes\Drawing namespace.
         */
        if (preg_match ($funcRe, $backTrace [$traceClosureArgumentsElementIndex]['function'])) {
          /**
           * [$clos_args Closure Arguments]
           * @var array
           */
          $clos_args = isset ($backTrace[1]['args']) && is_array ($backTrace[1]['args']) ? (
            $backTrace [1]['args']
          ) : [];

          $routeGroupOptionsGiven = ( boolean ) (
            isset ($backTrace[3]) &&
            is_array ($backTrace[3]) &&
            isset ($backTrace[3]['args']) &&
            is_array ($backTrace[3]['args']) && (
              isset ($backTrace[3]['args'][1]) &&
              is_string ($backTrace[3]['args'][1])
            ) &&
            (is_string ($ca) || is_null ($ca))
          );

          $resourceBaseReferenceGiven = ( boolean ) (
            self::resourceBaseRefGiven ($backTrace)
          );

          if ( $resourceBaseReferenceGiven ) {
            $basePath = preg_replace ('/^(\/+)/', '',
              preg_replace ('/(\/+)$/', '',
                $backTrace[1]['args'][0]['base']
              )
            );

            $path = ('/' . $basePath . '/' . $path);
          }

          if ( $routeGroupOptionsGiven ) {
            $action = (empty (trim($ca)) ? $path : '');

            $mdRe = '/^([^@]+)/';
            $middleware = '';
            $groupBase = trim ($backTrace[3]['args'][1]);

            if (preg_match ($mdRe, $groupBase, $mdMatch)) {
              $middleware = trim ($mdMatch [0]);
              $groupBase = trim (preg_replace ($mdRe, '', $groupBase));
            }

            if (preg_match ('/^((.*)@(.+)\/?)/', $ca)) {

              if (!preg_match ($mdRe, $ca)) {
                $ca = $middleware . $ca;
              }

            } else {
              /**
               * [$ca]

               * @var string
               */
              $ca = "{$middleware}$groupBase/" . (
                preg_replace ( '/^(\/+)/', '', $ca )
              );
            }

            $ca = preg_replace ('/(\/)+$/', '', $ca) . '/' . (
              preg_replace ('/^(\/+)/', '', $action)
            );

            $ca = preg_replace ('/(\/+)$/', '', $ca);
          }

          # Closure Arguments
          $closureArguments = isset ($clos_args [0]) ? (
            $clos_args[0]
          ) : null;

          $path = preg_replace ('/\/{2,}/', '/', $path);
          $path = '/' . preg_replace ('/^(\/+)/', '', $path);

          if (is_array ($closureArguments)) {
            /**
             * [$routeBaseReferenceSet]
             * @var boolean
             */
            $routeBaseReferenceSet = ( boolean ) (
              isset ($closureArguments ['rb']) &&
              is_string ($closureArguments ['rb'])
            );

            if ($routeBaseReferenceSet) {
              $path = join ('', [$closureArguments ['rb'], $path]);
            }
          }

          return [$path, self::PathToName ($ca, ['separator' => '\\'])];
        }

        return [];
      }
    }

    /**
     * RoutePathToName
     */
    public static function PathToName ($path = '', $options = []) {
      $options = !is_array ($options) ? [] : $options;

      $underscored = ( boolean ) (
        isset ($options['underscored']) &&
        is_bool ($options['underscored']) &&
        $options ['underscored']
      );

      $separator = $underscored ? '_' : '';
      if (!isset ($options['underscored'])) {
        $underscored = true;
      }

      $capitalized = ( boolean ) (
        isset ($options['capitalized']) &&
        is_bool ($options['capitalized']) &&
        $options ['capitalized']
      );

      if (isset ($options['separator']) &&
        is_string ($options['separator']) &&
        $options ['separator']) {
        $separator = $options ['separator'];
      }

      # /pages/groups
      # - page_group

      $path = preg_replace ('/^(\/+)/', '',
        preg_replace ('/(\/+)$/', '', $path)
      );

      $pathSlices = preg_split ('/\/+/', $path);

      $name = '';
      $singular = requires ('singular');

      for ($i = 0; $i < count ($pathSlices); $i++) {
        /**
         * Igone parameter definition inside the
         * given path string
         */
        if (!preg_match ('/^:/', $pathSlices [$i])) {
          $currentValue = $singular->parse ($pathSlices [$i]);

          if ($capitalized) {
            $currentValue = ucfirst ($currentValue);
          }

          $name .= join ('', [$separator, $currentValue]);
        }
      }

      $separatorRe = self::path2re ($separator);

      return preg_replace ('/^('.$separatorRe.')/', '', $name);
    }


    private static function validTrace ($trace) {
      return ( boolean ) (
        is_array ($trace) &&
        isset ($trace [0]) &&
        is_array ($trace [0]) &&
        isset ($trace [0]['file']) &&
        isset ($trace [0]['args']) &&
        is_array ($trace [0]['args'])
      );
    }

    private static function path2re ($path = null) {
      $specialCharsList = '/[\/\^\$\[\]\{\}\(\)\\\\.]/';

      return preg_replace_callback (
        $specialCharsList, function ($match) {
          return '\\' . $match[0];
      }, (string)$path);
    }

    public static function resourceBaseRefGiven ($backTrace = null) {
      $re = 'application\routes\drawing\{closure}';

      #echo '<pre>';

      #print_r ($backTrace);

      #exit (0);

      /**
       * [$f]
       * @var string
       */
      if (is_array ($backTrace) &&
        isset ($backTrace[1]) && is_array ($backTrace[1]) &&
        isset ($backTrace[1]['args']) &&
        is_array ($backTrace[1]['args']) &&
        isset ($backTrace[1]['args'][0]) &&
        is_array ($backTrace[1]['args'][0]) &&
        isset ($backTrace[1]['args'][0]['base']) &&
        is_string ($backTrace[1]['args'][0]['base']) &&
        isset ($backTrace[1]['function']) &&
        strtolower ($backTrace[1]['function']) == $re) {
        return $backTrace[1]['args'][0]['base'];
      }
    }

    public static function resourceCoreRefGiven ($backTrace = null) {
      $re = 'application\routes\drawing\{closure}';

      /**
       * [$f]
       * @var string
       */
      if (is_array ($backTrace) &&
        isset ($backTrace[1]) && is_array ($backTrace[1]) &&
        isset ($backTrace[1]['args']) &&
        is_array ($backTrace[1]['args']) &&
        isset ($backTrace[1]['args'][0]) &&
        is_array ($backTrace[1]['args'][0]) &&
        isset ($backTrace[1]['args'][0]['routerResourceCore']) &&
        is_object ($backTrace[1]['args'][0]['routerResourceCore']) &&
        isset ($backTrace[1]['function']) &&
        strtolower ($backTrace[1]['function']) == $re) {
        return $backTrace[1]['args'][0]['routerResourceCore'];
      }
    }
  }}
}
