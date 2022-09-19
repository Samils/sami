<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Application\Routes\Drawing
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
namespace Application\Routes\Drawing {
  use Sammy\Packs\KlassProps;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Application\Routes\Drawing\ApplicationRouterBase')) {
  /**
   * @class ApplicationRouterBase
   * Base internal class for the
   * Application\Routes\Drawing module.
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
  class ApplicationRouterBase {
    use KlassProps;

    /**
     * [$props ApplicationRouterBase::Props]
     * @var array
     */
    private static $props = array (
      '_failure' => array (
        'routerDidFail' => array(),
        'routerDidFailGet' => array(),
        'routerDidFailPost' => array()
      )
    );

    /**
     * [routerDidFail description]
     * @param  array $datas
     * @return void
     */
    public static function routerDidFail ($datas = []) {
      if (!is_array ($datas))
        return;

      $callBack = !isset($datas['callBack']) ? null : (
        $datas['callBack']
      );

      if (!is_func($callBack))
        return;

      self::$props['_failure']['routerDidFail'] = (
        array_merge(self::$props['_failure']['routerDidFail'],
          array ($callBack)
        )
      );
    }

    /**
     * [routerDidFailGet description]
     * @param  array $datas
     * @return void
     */
    public static function routerDidFailGet ($datas = []) {
      if (!is_array ($datas))
        return;

      $callBack = !isset($datas['callBack']) ? null : (
        $datas['callBack']
      );

      if (!is_func($callBack))
        return;

      self::$props['_failure']['routerDidFailGet'] = (
        array_merge(self::$props['_failure']['routerDidFailGet'],
          array ($callBack)
        )
      );
    }

    /**
     * [routerDidFailPost description]
     * @param  array $datas
     * @return void
     */
    public static function routerDidFailPost ($datas = []) {
      if (!is_array ($datas))
        return;

      $callBack = !isset($datas['callBack']) ? null : (
        $datas['callBack']
      );

      if (!is_func ($callBack)) {
        return;
      }

      self::$props['_failure']['routerDidFailPost'] = (
        array_merge(self::$props['_failure']['routerDidFailPost'],
          array ($callBack)
        )
      );
    }
  }}
}
