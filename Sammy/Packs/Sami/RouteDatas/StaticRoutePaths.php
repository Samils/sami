<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\RouteDatas
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
namespace Sammy\Packs\Sami\RouteDatas {
  use SamiController as Controller;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\RouteDatas\StaticRoutePaths')) {
  /**
   * @trait StaticRoutePaths
   * Base internal trait for the
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
  trait StaticRoutePaths {
    /**
     * @method array get static route paths
     */
    public static function GetStaticRoutePaths () {
      $sami = requires ('sami');

      $app = $sami->application_module ();

      $routes = $app->ApplicationRoutesList ('@get');

      $routePaths = array_map (function ($route) {
        if (is_array ($route) && isset ($route ['route'])) {
          $routePath = $route ['route'];

          return (string)($routePath);
        }

      }, $routes);

      $staticRoutePaths = array_filter ($routePaths, function ($routePath) {
        return !preg_match ('/^\/\^\\\\\//', $routePath);
      });

      $staticRoutePaths = array_merge (
        $staticRoutePaths,
        self::GetControllersStaticRoutePaths ()
      );

      return $staticRoutePaths;
    }

    /**
     * @method array get controllers static route paths
     */
    public static function GetControllersStaticRoutePaths () {
      $globalClasses = get_declared_classes ();

      $staticPaths = [];

      foreach ($globalClasses as $globalClass) {
        if (!in_array (Controller::class, class_parents ($globalClass))) {
          continue;
        }

        if (method_exists ($globalClass, 'getStaticPaths')) {
          $controllerSttaicPaths = forward_static_call ([$globalClass, 'getStaticPaths']);

          if (is_array ($controllerSttaicPaths)) {
            $staticPaths = array_merge ($staticPaths, $controllerSttaicPaths);
          }
        }
      }

      return $staticPaths;
    }
  }}
}
