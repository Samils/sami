<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\MiddleHandler
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
namespace Sammy\Packs\Sami\MiddleHandler {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\MiddleHandler\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   * Sami\MiddleHandler module.
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
  trait Base {
    /**
     * [handle description]
     * @param  string|array $middleware
     * @param  array $args
     * @return null
     */
    function handle ($middleware = null, $args = []) {
      if (is_array($middleware) && $middleware) {
        return $this->handleController (
          $middleware, $args
        );
      }

      if (!(is_string($middleware) && $middleware))
        return;

      $middleware = preg_replace ('/((Middleware)?)$/i', 'Middleware',
        $middleware
      );

      if (class_exists ($middleware)) {
        $middlewareCore = new $middleware;

        if (method_exists($middlewareCore, 'handle')) {
          return call_user_func_array (
            [$middlewareCore, 'handle'], $args
          );
        }
      }
    }

    /**
     * [handle description]
     * @param  array $middleware
     * @param  array $args
     * @return null
     */
    function handleController ($ctrl = [], $args = []) {
      if (!(is_array($ctrl) && count ($ctrl) >= 2))
        return;

      list ($controller, $action) = (
        $ctrl
      );

      if (is_array($action) && $action) {
        $actionRefsLen = count (
          $action
        );

        for ($i = 0; $i < $actionRefsLen; $i++) {
          if (!is_array($action [ $i ]))
            continue;

          $actionRef = array_merge ( [$controller],
            $action [ $i ]
          );

          call_user_func_array([$this, 'handleController'],
            [$actionRef, $args]
          );
        }


        return;
      }

      $order = !isset($ctrl[2]) ? '' : (
        $ctrl[ 2 ]
      );

      if (!(is_string($order)))
        $order = '';

      $middlewareFinalName = preg_replace (
        '/((Middleware)?)$/i', 'Middleware', (
          $controller
        )
      );

      if (!class_exists($middlewareFinalName))
        return;


      $middlewareClassParents = class_parents (
        $middlewareFinalName
      );

      if (in_array ('ApplicationMiddleware', $middlewareClassParents)) {
        $middlewareCore = new $middlewareFinalName;
        $middlewareMeth = $order . (
          str ($action)
        );

        if (method_exists ($middlewareCore, $middlewareMeth)) {
          call_user_func_array (
            [$middlewareCore, $middlewareMeth], (
              $args
            )
          );
        }
      }
    }
  }}
}
