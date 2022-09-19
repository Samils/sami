<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Router
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
namespace Sammy\Packs\Sami\Router {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Router\Store')) {
  /**
   * @trait Store
   * Base internal trait for the
   * Sami\Router module.
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
  trait Store {
    /**
     * @var ApplicationRoutes
     * - A set of list of the application
     * - routes
     */
    private $ApplicationRoutes = array ();

    /**
     * [$routerBase description]
     * @var string
     * Base for whole the routes created by
     * router library, a path that should be
     * at the beggining of each route
     */
    private $routerBase = '/';

    /**
     * [base description]
     * @param  string $path
     * @return null
     */
    function base ($path = '') {
      if (!(is_string($path) && $path))
        return;

      $path = preg_replace ('/^(\/*)/', '/',
        preg_replace ('/(\/*)$/', '/', $path)
      );

      $this->routerBase = strtolower (
        $path
      );
    }

    /**
     * [get description]
     * @param  string $path
     * @param  unknown $source
     * @return null
     */
    function get ($path, $source = null) {
      $path = $this->routerBase . (
        preg_replace ('/^(\/+)/', '',
          preg_replace ('/(\/+)$/', '', $path)
        )
      );
      array_push ($this->ApplicationRoutes, array (
        'meth' => 'get',
        'args' => array (
          $path, $source, debug_backtrace ()
        )
      ));
    }

    /**
     * [post description]
     * @param  string $path
     * @param  unknown $source
     * @return null
     */
    function post ($path, $source = null) {
      $path = $this->routerBase . (
        preg_replace ('/^(\/+)/', '',
          preg_replace ('/(\/+)$/', '', $path)
        )
      );
      array_push ($this->ApplicationRoutes, array (
        'meth' => 'post',
        'args' => array (
          $path, $source, debug_backtrace ()
        )
      ));
    }

    /**
     * [matches description]
     * @param  string $path
     * @param  unknown $source
     * @return null
     */
    function matches ($path, $source = null) {
      array_push ($this->ApplicationRoutes, array (
        'meth' => 'match',
        'args' => array (
          $path, $source, debug_backtrace ()
        )
      ));
    }
  }}
}
