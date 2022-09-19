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
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Middler')) {
  /**
   * @class Middler
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
  class Middler {
    use Middler\Base;

    /**
     * [resolve]
     * @param  string $middleware
     * @param array $args?
     * @param array $options?
     * @return array|null
     */
    function resolve ($middleware = '', $args = [], $options = []) {
      if (!is_string ($middleware) ) {
        $middleware = str ($middleware);
      }

      $re = '/(\:([a-zA-Z0-9_]+))$/';

      $args = !is_array ($args) ? [] : $args;
      $options = !is_array ($options) ? [] : $options;
      $middlewareAction = 'handle';
      $middlewareName = preg_replace ('/\:+/', '\\',
        preg_replace ( $re, '', $middleware )
      );

      if (preg_match ($re, $middleware, $actionMatch)) {
        $middlewareAction = $actionMatch [2];
      }

      if ($response = $this->resolveClass ($middlewareName, $middlewareAction, $args)) {
        return $response [ 0 ];
      }

      if ($response = $this->resolveFunc ($middlewareName, $args)) {
        return $response [ 0 ];
      }

      $validTraceArrayInOptions = ( boolean ) (
        isset ($options['trace']) &&
        is_array ($options['trace']) &&
        isset($options['trace'][0]) &&
        is_array ($t0 = $options['trace'][0]) && (
          isset ($t0['file']) &&
          isset ($t0['line'])
        )
      );

      $trace = $validTraceArrayInOptions ? $options['trace'] : (
        debug_backtrace ()
      );

      MiddlerError::NoMiddleware ($middleware, $trace);
    }
  }}
}
