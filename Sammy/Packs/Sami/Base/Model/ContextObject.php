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
  use Sammy\Packs\Sami\Base as SamiBase;
  use Sammy\Packs\Sami\Error;
  use Sami\Base as DataBase;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Base\Model\ContextObject')) {
  /**
   * @class ContextObject
   * Base internal class for the
   * Sami\Base\Model module.
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
  class ContextObject {
    /**
     * [$props description]
     * @var array
     */
    private $props = array (
      '@name' => null,
      '@rules' => array (
        'attributes' => array (),
        'belongs_to' => array (),
        'has_many' => array ()
      ),
      '@cols' => array (
        'id' => array (
          '@type' => 'int(11)',
          'null' => false
        ),
        'key' => array (
          '@type' => 'varchar(25)',
          'null' => true,
          'default' => null
        ),
        'createdAt' => array (
          '@type' => 'datetime',
          'null' => false,
          'default' => 'DEFAULT_TIMESTAMP'
        ),
        'updatedAt' => array (
          '@type' => 'datetime',
          'null' => false,
          'default' => 'DEFAULT_TIMESTAMP'
        )
      )
    );

    private function setAttr ($attr) {
      if (!(is_string ($attr) && $attr)) {
        return;
      }

      $rules = $this->props['@rules'];

      $issetAttribute = ( boolean ) (
        isset($rules['attributes'][$attr]) &&
        is_array($rules['attributes'][$attr])
      );

      if (!$issetAttribute) {
        $this->props['@rules']['attributes'][$attr] = [];
      }
    }

    public function config_attr ($attr, $prop) {
      if (!(is_string ($attr) && $attr)) {
        return;
      }

      $this->setAttr ($attr);

      if (is_array ($prop) && $prop) {

        $attributes = $this->props ['@rules']['attributes'];

        $this->props ['@rules']['attributes'][$attr] = (
          array_merge ($attributes [$attr], $prop)
        );
      } elseif (is_string ($prop)) {
        $this->props ['@rules']['attributes'][$prop] = (
          array_last_i (func_get_args ())
        );
      }
    }

    public final function __construct ($name, $columns = null) {
      $this->props ['@name'] = strtolower ($name);

      $cols = array_merge ($columns, $this->props ['@cols']);
      # ...
      # ...
      $this->props ['@cols'] = $cols;
    }

    public final function __call ($meth, $args) {
      $meth = strtolower ($meth);
      $model = $this->props ['@name'];
      /**
       * [$conn description]
       * @var [type]
       */
      $conn = SamiBase::getAdapterInstance ();

      $crud = ['create', 'read', 'update', 'destroy'];

      if (in_array ($meth, $crud)) {

        DataBase::ForceConnection ($model);
        $conn = SamiBase::getAdapterInstance();

        #exit (gettype($conn));

        if (method_exists ($conn, $meth)) {
          return call_user_func_array ([$conn, $meth], [
            $this->name, ( isset($args[0]) ? $args[0] : [] )
          ]);
        }
      }

      Error::NoMethod (static::class, $meth, debug_backtrace ());
    }

    /**
     * [has_col description]
     * @param  [type]  $col [description]
     * @return boolean      [description]
     */
    function has_col ($col = null) {
      return isset ($this->props ['@cols'][ lower($col) ]);
    }

    /**
     * [get_col_fields description]
     * @param  [type] $col [description]
     * @return [type]      [description]
     */
    function get_col_fields ($col = null) {
      $col = strtolower ($col);
      if (isset ($this->props ['@cols'][$col])) {
        return ( $this->props ['@cols'][ $col ] );
      }
    }

    /**
     * [get_cols description]
     * @return array
     */
    function get_cols () {
      if (is_array ($this->props ['@cols'])) {
        return array_keys ($this->props [ '@cols' ]);
      }
    }

    /**
     * [__get description]
     * @param  string $prop
     * @return mixed
     */
    function __get ($prop = null) {
      if (is_string ($prop)) {
        $prop = preg_replace('/^@+/', '', $prop);

        if (isset ($this->props [$prop])) {
          return ($this->props [$prop]);
        }

        if (isset ($this->props ['@'.$prop])) {
          return ( $this->props ['@'.$prop] );
        }
      }
    }
  }}
}
