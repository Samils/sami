<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base\Table
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
namespace Sammy\Packs\Sami\Base\Table {
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Base\Table\Column')) {
  /**
   * @class Column
   * Base internal class for the
   * Sami\Base\Table module.
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
  class Column {
    use Column\Helper;
    /**
     * [$props description]
     * @var array
     */
    private $props = array (
      '@type' => null
    );

    /**
     * [__construct description]
     * @param [type] $props [description]
     * @param [type] $type  [description]
     */
    public function __construct ($props = null, $type = null) {
      if (!is_array ($props)) {
        $props = array ();
      }

      $this->props = array_merge ($this->props, $props);

      $this->props ['@type'] = $type;
    }

    /**
     * [__set description]
     * @param string $prop  [description]
     * @param [type] $value [description]
     */
    public function __set ($prop = '', $value = null) {
      if (is_right_var_name ($prop)) {
        $this->props [$prop] = $value;
      }
    }

    /**
     * [__get description]
     * @param  string $prop [description]
     * @return [type]       [description]
     */
    public function __get ($prop = '') {
      if (is_right_var_name ($prop) &&
        isset ($this->props [$prop])) {
        return $this->props [$prop];
      }
    }

    /**
     * [__isset description]
     * @param  [type]  $prop [description]
     * @return boolean       [description]
     */
    public function __isset ($prop = null) {
      return isset ($this->props [strtolower ($prop)]);
    }

    public function __call ($property, $arguments) {
      if (!(is_array ($arguments) && $arguments)) {
        $arguments = [true];
      }

      list ($value) = $arguments;

      $this->__set ($property, $value);

      return $this;
    }

    /**
     * [getProps description]
     * @return [type] [description]
     */
    public function getProps () {
      return $this->props;
    }
  }}
}
