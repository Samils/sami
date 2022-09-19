<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Middler
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
namespace Sammy\Packs\Sami\Middler {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Middler\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   * Sami\Middler module.
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
    use Autoload;

    /**
     * @var boolean $ready
     */
    private static $ready = false;

    /**
     * @method void __construct
     */
    public function __construct () {
      /**
       * Make sure self::$ready is false
       * to read whole the
       */
      if (!self::$ready) {
        self::Autoload ();
      }
    }

    /**
     * @method array getNameAlts
     */
    private function getNameAlts ($name) {
      return array (
        'App\\Middleware\\' . $name,
        'App\\Middleware\\' . $name . 'Middleware',
        'Application\\Middleware\\' . $name,
        'Application\\Middleware\\' . $name . 'Middleware',
        $name,
        $name . 'Middleware',
      );
    }

    public function resolveFunc ($middlewareName, $args) {
      $alts = $this->getNameAlts ($middlewareName);

      foreach ($alts as $k => $alt) {
        if (function_exists ($alt) ) {
          return [ call_user_func_array ($alt, $args) ];
        }
      }
    }

    public function resolveClass ($middlewareName,$middlewareAction, $args) {
      $alts = $this->getNameAlts ($middlewareName);

      foreach ($alts as $k => $alt) {

        $middlewareIsAnAppMiddleware = ( boolean ) (
          class_exists ($cn = $alt) &&
          in_array ('ApplicationMiddleware',
            class_parents ($cn)
          )
        );

        if ( $middlewareIsAnAppMiddleware ) {
          $middlewareCore = new $cn ();

          if (method_exists($middlewareCore, $middlewareAction)) {
            $response = call_user_func_array (
              [$middlewareCore, $middlewareAction], $args
            );

            return [ $response ];
          }
        }
      }
    }
  }}
}
