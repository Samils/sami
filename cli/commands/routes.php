<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Cli
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
namespace Sammy\Packs\Sami\Cli {
  /**
   * Version Command
   */
  $module->exports = [
    'name' => 'routes',
    'description' => 'List whole the application routes',
    'aliases' => [],
    'handler' => function () {
      $sami = requires ('sami');

      $app = $sami->application_module ();
      $routes = array_merge (
        $app->ApplicationRoutesList ('@get'),
        $app->ApplicationRoutesList ('@post'),
        $app->ApplicationRoutesList ('@put'),
        $app->ApplicationRoutesList ('@patch'),
        $app->ApplicationRoutesList ('@delete')
      );

      $routes = array_map (function ($route) {
        echo "path => ", $route['route']->getOriginalRawPath(), "\n\n";
      }, $routes);

    }
  ];
}
