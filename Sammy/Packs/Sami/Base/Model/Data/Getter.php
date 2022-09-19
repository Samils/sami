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
  if (!trait_exists ('Sammy\Packs\Sami\Base\Model\Data\Getter')) {
  /**
   * @trait Getter
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
  trait Getter {
    public function getData ($data = '') {
      if (!(is_string($data) && $data))
        return;

      $alts = ['', '#'];
      $altsCount = count ( $alts );

      for ($i = 0; $i < $altsCount; $i++) {
        $dataKey = lower ($alts[$i] . $data);

        if (isset ($this->props [$dataKey])) {
          return $this->props [$dataKey];
        }
      }

      $data = lower ($data);

      if (in_array ($data, $this->noparams)) {
        if (method_exists ($this, $data)) {
          return call_user_func ([$this, $data]);
        }
      }

      $dataGetterName = join ('', ['get', $data]);

      if (method_exists ($this, $dataGetterName)) {
        return call_user_func ([$this, $dataGetterName]);
      }
    }

    public function dataExists ($data) {
      if (!(is_string($data) && $data))
        return;

      $alts = ['', '#'];
      $altsCount = count ( $alts );

      for ($i = 0; $i < $altsCount; $i++) {
        $dataKey = lower ($alts [$i] . $data);

        if (isset($this->props [$dataKey])) {
          return true;
        }
      }

      return false;
    }

    public function getDatas () {
      $args = func_get_args ();
      $datas = array ();
      $argsCount = count (
        $args
      );

      for ($i = 0; $i < $argsCount; $i++) {
        array_push ($datas, $this->getData (
          $args[$i]
        ));
      }

      return ($datas);
    }

    public function __get ($prop = null) {
      return $this->getData ($prop);
    }
  }}
}
