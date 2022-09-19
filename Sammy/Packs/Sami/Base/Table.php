<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base
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
namespace Sammy\Packs\Sami\Base {
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Base\Table')) {
  /**
   * @class Table
   * Base internal class for the
   * Sami\Base module.
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
  class Table {
    use Table\Base;
    use Table\Store;
    use Table\Helper;
    /**
     * [$props description]
     * @var array
     */
    private $props = [
      '@cols' => [],
      '@name' => null
    ];
    /**
     * [__construct description]
     * @param string $name [description]
     */
    public final function __construct ($name = '') {
      $this->props ['@name'] = $name;

      if (!in_array (strtolower ($name), self::$Tables)) {
        array_push (self::$Tables, strtolower ($name));
      }
    }

    public final function __call ($meth, $arguments) {
      $meth = strtolower ($meth);

      $colsType = self::columnTypes ();
      $args = array ();

      if (is_array ($colsType) && isset ($colsType [$meth])) {
        if (!count ($arguments) >= 1) {
          exit ('noName for Table');
        }

        if (count ($arguments) >= 2) {
          $args = $arguments [1];
        }
        /**
         * Considering the '$meth' var the
         * type for the column being created
         * , add it to the '@cols' property
         * of the current context as an
         * instance of 'Sami\Base\Model\Table\Column'
         */
        $meth = self::rewriteType ($meth);

        /**
         * @var columnName The cullumn name
         *
         */
        $columnName = strtolower ($arguments [ 0 ]);

        return $this->props[ '@cols' ][ $columnName ] = (
          new Table\Column ($args, $meth . $colsType [$meth])
        );

      } else {
        Error::NoMethod ($meth, static::class, debug_backtrace ());
      }
    }
  }}
}
