<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base\Model\Data
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
namespace Sammy\Packs\Sami\Base\Model\Data {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Base\Model\Data\Setter')) {
  /**
   * @trait Setter
   * Base internal trait for the
   * Sami\Base\Model\Data module.
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
  trait Setter {
    /**
     * @method Sami\Base setDatas
     *
     * @param [type] $datas
     */
    public function setDatas ($datas = null) {
      if (is_array ($datas) && $datas) {
        foreach ($datas as $data => $value) {
          $this->setData ($data, $value);
        }
      } elseif (is_string ($datas)) {
        $args = func_get_args();
        $argsCount = count ($args);

        for ($i = 0; $i < $argsCount; $i += 2) {
          $value = !isset($args [$i + 1]) ? null : (
            $args [ $i + 1 ]
          );

          $this->setData ($args[$i], $value);
        }
      }

      return $this;
    }

    /**
     * @method Sami\Base setData
     *
     * @param string $data
     * @param [type] $value
     */
    public function setData ($data = '', $value = null) {
      if (!(is_string ($data) && is_right_var_name ($data)))
        return;

      $data = lower ($data);
      $trace = debug_backtrace();

      $inSamiBaseClass = (boolean) (
        isset( $trace [ 1 ] ) &&
        is_array ( $trace [ 1 ] ) &&
        isset ( $trace [ 1 ][ 'class' ] ) &&
        $trace [ 1 ][ 'class' ] === self::class
      );

      if (in_array ($data, array_keys($this->props))) {
        $this->props [ $data ] = str ( $value );
      } elseif ($inSamiBaseClass && in_array ('#'.$data, array_keys ($this->props))) {
        $this->props[ '#'.$data ] = str ( $value );
      } elseif (self::isValidProp ($data)) {
        $this->props [ '#'.$data ] = $value;
      }

      return $this;
    }

    /**
     * @method Sami\Base __set
     *
     * @param string $prop
     * @param mixed $value
     */
    public function __set ($prop, $value) {
      return $this->setData ( $prop, $value );
    }
  }}
}
