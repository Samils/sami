<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\RouteFactory
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
namespace Sammy\Packs\Sami\RouteFactory {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\RouteFactory\Rest')) {
  /**
   * @trait Rest
   * Base internal trait for the
   * Sami\RouteFactory module.
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
  trait Rest {

    public static function Rest ($base = null, $middleware = '') {
      /**
       * Make sure $path is not an invalid or empty
       * string before proceding.
       */
      if (!(is_string ($base) && !empty ($base))) {
        return false;
      }
      /**
       * [$resourceBaseGivenFromArgs]
       * @var boolean
       */
      #$resourceBaseGivenFromArgs = ( boolean ) (
       # isset ($args[0]) &&
       # is_string ($base = $args[0])
      #);

      /**
       * [$resourceMiddlewareGivenFromArgs]
       * @var boolean
       */
      #$resourceMiddlewareGivenFromArgs = ( boolean ) (
      #  isset ($args[1]) &&
      #  is_string ($args[1])
      #);

      if (!(is_string ($middleware) && $middleware)) {
        $middleware = '';
      }

      $base_ctrl = self::PathToName ($base, [
        'separator' => '\\',
        'capitalized' => true
      ]);

      # Rest Routes
      # An array containg the basics routes
      # for creating resources given a router
      # base for routes inside the same group
      # such as 'pages'
      return [
        'index' => [
          'getRq',
          $base,
          $middleware . '@' . $base_ctrl . '/index'
        ],

        'create' => [
          'postRq',
          $base,
          $middleware . '@' . $base_ctrl . '/create'
        ],

        'new' => [
          'getRq',
          $base . '/new',
          $middleware . '@' . $base_ctrl . '/new_'
        ],

        'edit' => [
          'getRq',
          $base . '/:id/edit',
          $middleware . '@' . $base_ctrl . '/edit'
        ],

        'show' => [
          'getRq',
          $base.'/:id',
          $middleware . '@' . $base_ctrl . '/show'
        ],

        'update' => [
          'putRq',
          $base.'/:id',
          $middleware . '@' . $base_ctrl . '/update'
        ],

        'remove' => [
          'getRq',
          $base . '/:id/remove',
          $middleware . '@' . $base_ctrl . '/remove'
        ],

        'delete' => [
          'deleteRq',
          $base . '/:id',
          $middleware . '@' . $base_ctrl . '/delete'
        ]
      ];
    }
  }}
}
