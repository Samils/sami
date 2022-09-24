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
  use Sammy\Packs\Sami\Error;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Base\CoreModel')) {
  /**
   * @class CoreModel
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
  abstract class CoreModel {
    use Model\Data;
    use Model\Hook;
    use Model\Sync;
    use Model\Helper;
    use Model\Instance;

    /**
     * @var array $obmodels
     *
     * A list of SamiBase model data objects.
     */
    private static $obmodels = array ();

    /**
     * [InitModelConfigurations description]
     * @param array $props [description]
     */
    public static function InitModelConfigurations ($props = []) {
      $model = self::ModelName ();

      self::$obmodels [$model] = new Model\ContextObject ($model, $props);

      $modelObject = new static;

      if (method_exists ($modelObject, 'constructor')) {
        call_user_func ([$modelObject, 'constructor']);
      }
    }

    private static function ModelName () {
      $className = strtolower (get_called_class ());

      $classNameSlices = preg_split ('/\\\+/', $className);

      return $classNameSlices [-1 + count ($classNameSlices)];
    }

    private static function ModelObject () {
      $model = self::ModelName ();

      if (isset (self::$obmodels [ $model ])) {
        return self::$obmodels [ $model ];
      }
    }

    /**
     * [CallStatic description]
     * @return [type] [description]
     */
    public static function __callStatic ($meth, $args) {
      $meth = str ($meth);
      # The called class
      # Contains the model
      # reference inside the
      # model base store
      $className = static::class;
      $model = self::ModelName ();
      # Stop function execution if
      # The current model was not
      # previously stored and configured
      if (!self::tryConnecting ($model)) {
        return false;
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

      # CallStatic function
      $reFindBy = '/^(findBy([a-zA-Z0-9_]+))/';
      $reRead = '/^read([a-zA-Z0-9_]+)$/i';

      if (preg_match ($reFindBy, $meth, $match)) {
        $fieldName = lower (preg_replace ('/^(findBy)/', '', $meth));

        $filedValue = !isset ($args [0]) ? null : $args [0];

        $modelFields = self::ModelAttributes ();

        if (in_array ($fieldName, $modelFields)) {
          return self::findBy ($fieldName, $filedValue);
        }
      } elseif (preg_match ($reRead, $meth, $match)) {
        $filedNames = self::strSplitByAndKey ($match [1]);

        $datas = $args ? $args [0] : [];
        $datas = is_array ($datas) ? $datas : [];

        return self::read (array_merge ($datas, $filedNames));
      }

      /// Get for a called hook
      $classBaseMethName = '__acb' . strtolower ($meth);

      if (method_exists ($className, $classBaseMethName)) {
        return @forward_static_call_array (
          [$className, $classBaseMethName], $args
        );
      }
      ///
      Error::NoMethod ($className, $meth, debug_backtrace ());
    }

    protected static function strSplitByAndKey ($string) {
      $string = lower (preg_replace ('/And/', '-', $string));

      return preg_split ('/\-+/', $string);
    }

    private static function CollectRows ($rows, $datas = null) {
      if (!(is_object ($rows))) {
        return;
      }

      $datas = is_array ($datas) && $datas ? $datas : null;

      $rows_array = array ();

      while ($row = $rows->fetch ()) {
        array_push ($rows_array,
          new static ( \Saml::Object2Array ($row) )
        );
      }

      return ( $rows_array );
    }

    private static function filterValidProps ($props) {
      if (!(is_array ($props) && $props)) {
        return null;
      }

      $it = new static;
      $datas = array_keys ($it->getProps ());
      $validProps = [];

      foreach ($props as $key => $prop) {
        if (is_int ($key) && is_string ($prop)) {
          $prop = strtolower ((string)$prop);

          if (in_array ($prop, $datas)) {
            array_push ($validProps, $prop);
          }
        } else {
          $validProps [$key] = $prop;
        }
      }

      return $validProps;
    }
  }}
}
