<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base\Model
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
namespace Sammy\Packs\Sami\Base\Model {
  use Sammy\Packs\Samils\Controller\Base as SamiController;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Base\Model\Instance')) {
  /**
   * @trait Instance
   * Base internal trait for the
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
  trait Instance {
    /**
     * [$props description]
     * @var array
     */
    private $props = array (
      '#id' => null,
      '#createdat' => null,
      '#updatedat' => null,
      '#key' => null
    );

    /**
     * [$cols description]
     * @var array
     */
    private $cols = array ();

    private function scopeDefined () {
      $model = self::ModelName ();

      #echo $model, '<br /><pre>';

      #print_r(array_keys (self::$obmodels));

      #echo '</pre><br /><br /><br />';
      return (boolean) (
        isset (self::$obmodels[ $model ]) &&
        (self::$obmodels[ $model ] instanceof ContextObject)
      );
    }

    private function fill_props () {
      $model = self::ModelName ();

      #echo $model, '<br /><pre>';

      #print_r(array_keys (self::$obmodels));

      #echo '</pre><br /><br /><br />';

      if (!!$this->scopeDefined ()) {
        $modelObject = self::$obmodels [$model];

        $cols = $modelObject->get_cols ();
        $props = array_keys ($this->props);
        $colsCount = count ($cols);

        #echo "<pre>"; print_r($cols);

        for ($i = 0; $i < $colsCount; $i++) {
          $col = $modelObject->get_col_fields ($cols [$i]);

          array_push ( $this->cols, $cols [$i] );

          if (!in_array ('#'.strtolower ($cols [$i]), $props)) {
            $this->props [$cols [$i]] = (
              !isset ($col['default']) ? '' : $col['default']
            );
          }
        }
      }
    }

    private static function constructingFromController () {
      $backTrace = func_num_args() >= 1 ? func_get_arg(0) : null;

      if ( $backTrace && is_array ($backTrace) ) {

        #if (isset($backTrace[1]['class'])) {
        #  echo '<div style="background:yellow;">'.SamiBase::class.'<pre>';
        #  print_r(class_parents($backTrace[1]['class']));
        #  echo '</pre></div><br /><br /><br /><br /><br /><br />';
        #}

        #if (isset ($backTrace[1]) &&
        #  is_array ($backTrace[1]) &&
        #  isset ($backTrace[1]['class'])) {
        #  echo $backTrace[1]['class'], "<br /><pre>";

        #  print_r(class_parents ($backTrace[1]['class']));
        #  echo '</pre><br /><br />';
        #}

        return ( boolean ) (
          isset ($backTrace[1]) &&
          is_array ($backTrace[1]) &&
          isset ($backTrace[1]['class']) && (
            in_array (SamiController::class, class_parents(
              $backTrace[1]['class']
            ))
          )
        );
      }
    }

    /**
     * [__construct description]
     * @param array $datas
     */
    public function __construct ($datas = []) {
      $args = func_get_args ();
      $backTrace = debug_backtrace ();
      $model = self::ModelName ();

      if (self::constructingFromController ($backTrace)) {
        self::tryConnecting ($model);
      }

      $this->fill_props ();

      call_user_func_array ([$this, 'setDatas'], $args);
    }

    public function __isset ($data) {
      return $this->dataExists ($data);
    }

    public function __toString () {
      return str ( $this->lean () );
    }

    public function save () {
      $datas = $this->leanDatas ();

      if (!is_null ($this->id)) {
        return self::update (array_merge (
          $datas,
          ['where()' => ['id' => $this->id]]
        ));
      }

      #echo '<pre>'; print_r($datas);
      #exit (0);

      $it = self::create ( $datas );

      if (!$it) return (
        false
      );

      $this->setDatas ( $it->lean() );
      return ($this);
    }

    /**
     * [update_attributes description]
     * @param  array  $datas
     * @return boolean
     */
    public function update_attributes ($datas = []) {
      $this->change_attributes ( $datas );
      return ($this->save ());
    }

    /**
     * [change_attributes description]
     * @param  array  $datas
     * @return null
     */
    public function change_attributes ($datas = []) {
      if (is_array ($datas)) {
        foreach ($datas as $data => $value) {
          $d = lower($data);

          if (!isset($this->props['#'.$d])) {
            $this->setData ($d, $value);
          }
        }
      }
    }

    public function auto_destroy () {
      if (is_null ($this->id))
        return;

      return self::deleteById ($this->id);
    }
  }}
}
