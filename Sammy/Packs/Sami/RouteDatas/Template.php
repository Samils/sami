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
  use Sammy\Packs\Sami\Router\Path;
  use Param as RouteParam;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\RouteDatas\Template')) {
  /**
   * @trait Template
   * Base internal trait for the
   * Sami\RouteDatas module.
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
  trait Template {
    /**
     * @method mixed getTemplateDatas
     */
    public function getTemplateDatas () {
      $routes = $this->routeList;
      $requestRoute = $this->path;

      $routes = !is_array ($routes) ? [] : $routes;
      // $route = !(strlen (trim ($route)) >= 2) ? $route : (
      //   preg_replace ( '/(\/+)$/', '',  $route )
      // );
      //
      // # Template
      // $paramContext = null;

      // if (isset ($routes [$route])) {
      //   $this->asign ($routes [$route]);
      //   return $routes [$route];
      // } else {
      //   # $routes -> The defined routes list
      //   # $r -> a $route
      //   # $d -> a $route data
      //   foreach ($routes as $routeRegularExpression => $routeDatas) {

      //     if (!((is_array ($routeDatas) &&
      //       isset ($routeDatas ['template']) &&
      //       $routeDatas ['template'] instanceof RouteParam) ||
      //       (is_array ($routeDatas) &&
      //       isset ($routeDatas ['match']) &&
      //       is_bool ($routeDatas ['match']) &&
      //       $routeDatas ['match'])
      //     )) {
      //       continue;
      //     }

      //     # Validate Regular expression
      //     # before matching to the route
      //     if (@preg_match_all ($routeRegularExpression, $route, $match)) {
      //       # Template
      //       $paramContext = $routeDatas['template'];

      //       if ( $paramContext instanceof RouteParam ) {
      //         $paramNames = $paramContext->getParamNames();
      //         $paramNamesCount = count($paramNames);

      //         for ($i = 0; $i < $paramNamesCount; $i++) {
      //           $paramValue = null;

      //           $validParamValueSent = ( boolean ) (
      //             isset ($match [ $i + 1 ]) &&
      //             is_array ($match [ $i + 1 ]) &&
      //             isset ($match [ $i + 1 ][ 0 ])
      //           );

      //           if ( $validParamValueSent ) {
      //             $paramValue = $match [ $i + 1 ][ 0 ];
      //           }

      //           $paramContext->set ($paramNames [ $i ], $paramValue);
      //         }

      //         $routeDatas ['params'] = $paramContext;
      //       } else {
      //         $routeDatas ['matches'] = $match;
      //       }

      //       $this->asign ($routeDatas);

      //       return $routeDatas;
      //     }
      //   }
      // }
      //
      //
      foreach ($routes as $route) {
        $routePath = $route ['route'];

        if ($routePath instanceof Path
          && $routePath->matches ($requestRoute)) {
          return $route;
        }
      }
    }
  }}
}
