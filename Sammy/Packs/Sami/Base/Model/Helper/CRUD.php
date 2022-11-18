<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base\Model\Helper
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
namespace Sammy\Packs\Sami\Base\Model\Helper {
  use Closure;
  use params;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Base\Model\Helper\CRUD')) {
  /**
   * @trait CRUD
   * Base internal trait for the
   * Sami\Base\Model\Helper module.
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
  trait CRUD {
    /**
     * [createMany description]
     * @return object
     */
    public static function __acbcreateMany () {
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $model = self::ModelName ();
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!isset (self::$obmodels [$model])){
        return;
      }

      $model_obj = self::$obmodels [$model];

      $args = func_get_args();
      $args_len = count( $args );
      $result = false;

      $tokens = requires ('sami-tokens');

      for ($i = 0; $i < $args_len; $i++) {
        $datas = $args [$i];

        if (!is_array ($datas)) {
          continue;
        }

        if (method_exists($model, 'beforeCreate')) {
          $datas = forward_static_call_array (
            [$model, 'beforeCreate'], [$datas]
          );
        }

        $key = $tokens->newNumericToken (21);

        $datas = array_merge ($datas, [
          'key' => join ('', ['1000', $key])
        ]);

        $result = $model_obj->create (
          $datas
        );

        if (method_exists($model, 'onCreate')) {
          $datas = forward_static_call_array (
            [$model, 'onCreate'], [$datas]
          );
        }
      }

      return is_bool($result) ? $result : (
        self::find ($result)
      );
    }

    public static function __acbcreate ($datas = []) {
      if (!(is_array ($datas) && $datas)) {
        return false;
      }

      return self::createMany ( $datas );
    }

    /**
     * [all description]
     * @return object
     */
    public static function __acball () {
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $model = self::ModelName ();
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!isset (self::$obmodels [$model])) {
        return;
      }

      $model_obj = self::$obmodels [ $model ];
      # Collect whole the got rows
      # from the current query
      return self::CollectRows (
        $model_obj->read ()
      );
    }

    public static function __acbfindall () {
      return self::__acball ();
    }

    /**
     * [filter description]
     * @return [type] [description]
     */
    public static function __acbfilter ($callBack = null) {
      if (!($callBack instanceof Closure)) {
        return array ();
      }
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $model = self::ModelName ();
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!isset (self::$obmodels [$model])) {
        return;
      }
      # Model Object
      # an instance of the module
      # connection class from the driver
      # man of Sami\Base.
      # This is an object containing the
      # database CRUD Reference methods
      # to allow creating ohter that should
      # complement that inside Sami\Base.
      $model_obj = self::$obmodels [
        # Model name
        # A reference for the
        # current model inside
        # the Sami\Base Store
        # that should make a reference
        # for the same inside the Sami\Base
        # general context
        $model
      ];

      $modelRows = $model_obj->read ();

      # return rows
      # an array array containing
      # whole the returned value
      # from the rows list according
      # to the logic inside the 'callback'
      # Closure
      $returnRows = array ();

      # If the Query was executed
      # and returned some data
      if ($modelRows) {
        # Map whole the datas
        # inside the '$modelRows'
        # array in order doing the
        # filter according to the
        # 'callBack' Closure logic
        while ($modelRow = $modelRows->fetch ()) {
          $row = new static (\Saml::Object2Array ($modelRow));

          if ($callBack ($row)) {
            array_push ($returnRows, $row);
          }
        }
      }

      return $returnRows;
    }

    /**
     * [map description]
     * @return [type] [description]
     */
    public static function __acbmap ($callBack = null) {
      return self::mapEach (1, $callBack);
    }

    /**
     * [mapEach description]
     * @return [type] [description]
     */
    public static function __acbmapEach ($num = null) {
      $callBack = array_last_i (func_get_args ());

      if (!($callBack instanceof Closure)) {
        return array ();
      }
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $model = self::ModelName ();
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!isset (self::$obmodels [$model])) {
        return;
      }
      # Model Object
      # an instance of the module
      # connection class from the driver
      # man of Sami\Base.
      # This is an object containing the
      # database CRUD Reference methods
      # to allow creating ohter that should
      # complement that inside Sami\Base.
      $model_obj = self::$obmodels [
        # Model name
        # A reference for the
        # current model inside
        # the Sami\Base Store
        # that should make a reference
        # for the same inside the Sami\Base
        # general context
        $model
      ];
      # Model rows
      # An array that'll contain whole
      # the rows inside the model object
      # table in the database.
      # Without any filter or restriction,
      # everything about logic'll be be done
      # in the '$callBack' closure
      $modelRows = self::all ();
      # return rows
      # an array array containing
      # whole the returned value
      # from the rows list according
      # to the logic inside the 'callback'
      # Closure
      $returnRows = array ();

      # If the Query was executed
      # and returned some data
      if ($modelRows) {
        $num = (!is_numeric($num)) ? 1 : (int)($num);
        # Count the items inside the
        # '$modelRows' array
        $modelRowsCount = count ($modelRows);

        # Map whole the datas
        # inside the '$modelRows'
        # array in order doing the
        # filter according to the
        # 'callBack' Closure logic
        for ($i = 0; $i < $modelRowsCount; $i += $num) {

          $currentRows = array_slice ($modelRows, $i, $num);

          if (!(count($currentRows) >= $num)) {
            $currentRows = array_merge (
              $currentRows, data_repeat (null, $num - count($currentRows))
            );
          }

          $callBackResult = call_user_func_array ($callBack, $currentRows);

          if (!is_null ($callBackResult)) {
            array_push ($returnRows, $callBackResult);
          }
        }
      }

      return $returnRows;
    }

    /**
     * [find description]
     * @return [type] [description]
     */
    public static function __acbfind ($id = null) {
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $model = self::ModelName ();
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!isset (self::$obmodels [$model])) {
        return;
      }

      if (is_array ($id)) {
        # If '$id' variable is an array,
        # use it as a reference for the
        # wanted data, and look for matches
        # for that in the database in order
        # returning an array.
        return self::read ([ 'where()' => $id ]);
      } elseif (is_null ($id)) {
        $id = !defined ('params::id') ? '' : (int)(params::id);
      }

      $key = 'id';

      if (strlen ((string)($id)) >= 25) {
        $key = 'key';
      }

      $foundData = self::where ([ $key => $id ]);

      if (is_array ($foundData) && $foundData) {
        return $foundData [ 0 ];
      }
    }

    public static function __acbfindone () {
      return forward_static_call_array (
        [static::class, '__acbfind'], func_get_args ()
      );
    }

    /**
     * [findBy description]
     * @return [type] [description]
     */
    public static function __acbfindBy () {
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $model = self::ModelName ();
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!isset (self::$obmodels [$model])) {
        return;
      }
      # Model Object
      # an instance of the module
      # connection class from the driver
      # man of Sami\Base.
      # This is an object containing the
      # database CRUD Reference methods
      # to allow creating ohter that should
      # complement that inside Sami\Base.
      $model_obj = self::$obmodels [
        # Model name
        # A reference for the
        # current model inside
        # the Sami\Base Store
        # that should make a reference
        # for the same inside the Sami\Base
        # general context
        $model
      ];
      # Whole the sent arguments
      # to the current function
      # in order getting informations
      # from the database according
      # to the given functions.
      # - Structure:
      # - Each two arguments inside
      # - the arguments list, will be
      # - considered as the key-value
      # - pattern used in php arrays.
      # - in order having a group of
      # - datas and values to filter
      # - for the data required data/s.
      $arguments = func_get_args ();
      # Arguments Count (Lenght)
      # Number of arguments sent
      # to the current function
      $argumentsCount = count (
        # The Arguments List
        # according to what was
        # sent to the current
        # function
        $arguments
      );
      # The final condition
      # to be applied for
      # the generated query by
      # the Adapter Query Builder.
      $where = array ();

      for ($i = 0; $i < $argumentsCount; $i += 2) {
        # Index of the current value
        # according to the followed
        # pattern
        $currentValueIndex = $i + 1;

        $where[ strtolower ($arguments [ $i ]) ] = (
          !isset ($arguments [$currentValueIndex]) ? null : (
            $arguments [$currentValueIndex]
          )
        );
      }

      return self::where ([$where]);
    }

    /**
     * [first description]
     * @return [type] [description]
     */
    public static function __acbfirst () {
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $model = self::ModelName ();
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!isset (self::$obmodels [$model])) {
        return;
      }
      # Model Object
      # an instance of the module
      # connection class from the driver
      # man of Sami\Base.
      # This is an object containing the
      # database CRUD Reference methods
      # to allow creating ohter that should
      # complement that inside Sami\Base.
      $model_obj = self::$obmodels [
        # Model name
        # A reference for the
        # current model inside
        # the Sami\Base Store
        # that should make a reference
        # for the same inside the Sami\Base
        # general context
        $model
      ];
      # Collect whole the got rows
      # from the current query
      $rows = self::CollectRows (
        $model_obj->read ([
          'limit()' => [1],
          'order()' => ['id' => 'asc']
        ])
      );

      if (is_array ($rows) && $rows) {
        return $rows [ 0 ];
      }
    }

    /**
     * [first description]
     * @return [type] [description]
     */
    public static function __acblast () {
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $model = self::ModelName ();
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!isset (self::$obmodels [$model])) {
        return;
      }
      # Model Object
      # an instance of the module
      # connection class from the driver
      # man of Sami\Base.
      # This is an object containing the
      # database CRUD Reference methods
      # to allow creating ohter that should
      # complement that inside Sami\Base.
      $model_obj = self::$obmodels [
        # Model name
        # A reference for the
        # current model inside
        # the Sami\Base Store
        # that should make a reference
        # for the same inside the Sami\Base
        # general context
        $model
      ];
      # Collect whole the got rows
      # from the current query
      $rows = self::CollectRows (
        $model_obj->read ([
          'limit()' => [1],
          'order()' => ['id' => 'desc']
        ])
      );

      if (is_array ($rows) && $rows) {
        return $rows [ 0 ];
      }
    }

    /**
     * [where description]
     * @return [type] [description]
     */
    public static function __acbwhere ($where = null) {
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $model = self::ModelName ();
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!isset (self::$obmodels [$model])) {
        return;
      }
      # Model Object
      # an instance of the module
      # connection class from the driver
      # man of Sami\Base.
      # This is an object containing the
      # database CRUD Reference methods
      # to allow creating ohter that should
      # complement that inside Sami\Base.
      $model_obj = self::$obmodels [
        # Model name
        # A reference for the
        # current model inside
        # the Sami\Base Store
        # that should make a reference
        # for the same inside the Sami\Base
        # general context
        $model
      ];

      if (!is_array ($where)) {
        $where = array ();
      }

      return self::CollectRows (
        $model_obj->read (['where()' => $where])
      );
    }

    /**
     * [read description]
     * @return object
     */
    public static function __acbread ($datas = []) {
      $datas = is_array ($datas) ? $datas : [];
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $model = self::ModelName ();
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!isset (self::$obmodels [$model])) {
        return;
      }
      # Model Object
      # an instance of the module
      # connection class from the driver
      # man of Sami\Base.
      # This is an object containing the
      # database CRUD Reference methods
      # to allow creating ohter that should
      # complement that inside Sami\Base.
      $model_obj = self::$obmodels [
        # Model name
        # A reference for the
        # current model inside
        # the Sami\Base Store
        # that should make a reference
        # for the same inside the Sami\Base
        # general context
        $model
      ];

      $datas = self::filterValidProps ($datas);

      $options = [];

      if (!in_array ('id', $datas)) {
        array_push ($datas, 'id');

        $options ['hide_id'] = true;
      }

      $rowList = $model_obj->read ($datas);

      # Collect whole the got rows
      # from the current query
      return self::CollectRows ($rowList, $options);
    }

    /**
     * [update description]
     * @param  array  $datas
     * @return boolean
     */
    public static function __acbupdate ($datas = array ()) {
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $model = self::ModelName ();
      $className = static::class;
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!isset (self::$obmodels [$model])) {
        return;
      }
      # Model Object
      # an instance of the module
      # connection class from the driver
      # man of Sami\Base.
      # This is an object containing the
      # database CRUD Reference methods
      # to allow creating ohter that should
      # complement that inside Sami\Base.
      $model_obj = self::$obmodels [
        # Model name
        # A reference for the
        # current model inside
        # the Sami\Base Store
        # that should make a reference
        # for the same inside the Sami\Base
        # general context
        $model
      ];

      $datas = !is_array ($datas) ? [] : $datas;

      $datas = array_merge ($datas, array (
        'updatedAt' => current_timestamp ()
      ));

      if (method_exists ($className, 'beforeUpdate')) {
        $datas = forward_static_call_array (
          [$className, 'beforeUpdate'], [$datas]
        );
      }

      $result = $model_obj->update ($datas);

      if (method_exists ($className, 'onUpdate')) {
        $datas = forward_static_call_array (
          [$className, 'onUpdate'], [$datas]
        );
      }

      return $result;
    }

    /**
     * [updateById description]
     * @param  [type] $id
     * @param  array  $set
     * @return boolean
     */
    public static function __updateById ($id = null, $set = []) {
      return self::update (array_merge ($set, ['where()' => ['id' => $id]]));
    }

    /**
     * [updateByKey description]
     * @param  [type] $id
     * @param  array  $set
     * @return boolean
     */
    public static function __updateByKey ($key = null, $set = []) {
      return self::update (array_merge ($set, ['where()' => ['key' => $key]]));
    }

    /**
     * [destroy description]
     * @param  array  $where
     * @return boolean
     */
    public static function __acbdestroy ($where = array ()) {
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $model = self::ModelName ();
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!isset (self::$obmodels [$model])) {
        return;
      }
      # Model Object
      # an instance of the module
      # connection class from the driver
      # man of Sami\Base.
      # This is an object containing the
      # database CRUD Reference methods
      # to allow creating ohter that should
      # complement that inside Sami\Base.
      $model_obj = self::$obmodels [
        # Model name
        # A reference for the
        # current model inside
        # the Sami\Base Store
        # that should make a reference
        # for the same inside the Sami\Base
        # general context
        $model
      ];

      if (method_exists($model, 'beforeDestroy')) {
        $where = forward_static_call_array (
          [$model, 'beforeDestroy'], [$where]
        );
      }

      $result = $model_obj->destroy ($where);

      if (method_exists($model, 'onUpdate')) {
        $where = forward_static_call_array (
          [$model, 'onUpdate'], [$where]
        );
      }

      return $result;
    }

    public static function __acbdelete () {
      return forward_static_call_array (
        [static::class, 'destroy'], func_get_args()
      );
    }

    /**
     * [deleteById description]
     * @param  integer $id
     * @return null
     */
    public static function __acbdeleteById ($id = 0) {
      return self::destroy ([ 'id' => $id ]);
    }

    /**
     * [deleteByKey description]
     * @param  integer $id
     * @return null
     */
    public static function __acbdeleteByKey ($key = 0) {
      return self::destroy ([ 'key' => $key ]);
    }

    public static function __acbtrunctate () {
      return self::destroy ();
    }

    public static function __acbclear () {
      return self::destroy ();
    }
  }}
}
