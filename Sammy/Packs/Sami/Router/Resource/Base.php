<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Router\Resource
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
namespace Sammy\Packs\Sami\Router\Resource {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Router\Resource\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   * Sami\Router\Resource module.
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
     * [$routes List of created routes]
     * @var array
     */
    private $routes = array (
      'get' => array (),
      'post' => array ()
    );

    private $module;
    private $base;
    private $middleware;
    private $exceptions = array ();
    private $only = array ();

    public function setModule ($module) {
      $this->module = $module;
    }

    public function setBase ($base) {
      $this->base = $base;
    }

    public function getMiddleware () {
      return $this->middleware;
    }

    public function setMiddleware ($middleware = null) {
      $this->middleware = $middleware;
    }

    public function setException ($exception = '') {
      $this->setExceptions ([$exception]);
    }

    public function setExceptions ($exceptions = []) {
      $exceptions = !is_array ($exceptions) ? func_get_args() : (
        $exceptions
      );
      /**
       * [$this->exceptions description]
       * @var array
       */
      $this->exceptions = array_merge ($this->exceptions,
        $exceptions
      );
    }

    public function setOnlyList ($only = []) {
      $only = !is_array ($only) ? func_get_args() : (
        $only
      );
      /**
       * [$this->exceptions description]
       * @var array
       */
      $this->only = array_merge ($this->only,
        $only
      );
    }

    public function getExceptions () {
      return (array)$this->exceptions;
    }

    public function getOnlyList () {
      return (array)$this->only;
    }

    private function route ($type, $path, $target) {
    }

    public function get () {
      /**
       * Execute The Route Method
       */
      return call_user_func_array ([$this, 'route'],
        array_merge (['get'], func_get_args())
      );
    }

    public function post () {
      /**
       * Execute The Route Method
       */
      return call_user_func_array ([$this, 'route'],
        array_merge (['post'], func_get_args())
      );
    }

  }}
}
