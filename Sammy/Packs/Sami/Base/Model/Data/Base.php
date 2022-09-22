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
  if (!trait_exists ('Sammy\Packs\Sami\Base\Model\Data\Base')) {
  /**
   * @trait Base
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
  trait Base {
    use Setter;
    use Getter;
    use Caller;

    public function leanDatas () {
      $datas = array ();
      $props = array_keys ($this->props);
      $propsCount = count ($props);

      for ($i = 0; $i < $propsCount; $i++) {
        $prop = $props[ $i ];

        if (is_right_var_name ($prop)) {
          $datas [ $prop ] = $this->getData ($prop);
        }
      }

      return $datas;
    }

    public function lean () {
      $props = array ();
      $colsCount = count ($this->cols);

      for ($i = 0; $i < $colsCount; $i++) {
        $columnName = $this->cols [ $i ];
        $dataValue = $this->getData ($columnName);

        #echo $columnName, " => ", $dataValue, "<br />";

        if ($dataValue) {
          $props [ $columnName ] = $dataValue;
        }
      }

      #exit (json_encode($props));

      return $props;
    }

    public function getProps () {
      $props = array ();
      $colsCount = count ($this->cols);

      for ($i = 0; $i < $colsCount; $i++) {
        $props [] = lower ($this->cols [$i]);
      }

      return $props;
    }

    private static function ModelAttributes () {
      $modelObject = self::ModelObject ();
      # Get the model object
      # from the global model
      # store inside the base
      # class.
      # Return null if not found
      # any reference for the
      # current class
      if ( $modelObject ) {
        return $modelObject->get_cols ( 0 );
      }
    }
  }}
}
