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
  use Samils\Handler\Error;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Base\Model\Helper\Validation')) {
  /**
   * @trait Validation
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
  trait Validation {
    /**
     * [validates description]
     * @return mixed
     */
    private static function validateReference () {
      $backTrace = debug_backtrace ();

      # Complete Trace
      # A boolean value indicating if
      # the function back trace is
      # complete (is the reference is the
      # expected for using a SamiBase helper).
      $CompleteTrace = ( boolean ) (
        (
          # Make sure the current back trace
          # contains a fisrt position and it
          # is not a null or a not array value.
          isset ($backTrace [4]) &&
          # Make sure the fisrt position is not
          # another value type beyond of array,
          # and then, verify if the same as the
          # expected property name.
          is_array ($backTrace [4]) &&
          # Verify is the 'function' property is
          # inside the array at the 0 position.
          isset ($backTrace [4]['class']) &&
          # Make sure the reference class in the
          # stack trace is an instance or child class
          # os the SamiBase Core Class in order using
          # the current helper on it;
          # Application will stop and throw an error
          # in negative case.
          # ---
          # THE CURRENT HELPER FUNCTION IS ONLY AVAILABLE
          # FOR USING INSIDE SAMI BASE MODELS; AND SHOULD
          # NOT BE USED OUT OF THEM.
          # ---
          in_array ('Sami\\Base', class_parents (
            $backTrace [4][ 'class' ]
          ))
        ) || (
          isset ($backTrace[1]) &&
          is_array ($backTrace[1]) &&
          isset ($backTrace[1]['class']) &&
          ($backTrace[1]['class'] === self::class ||
          $backTrace[1]['class'] === static::class)
        )
      );

      if ( !$CompleteTrace ) {
        self::uncoughtReference ($backTrace);
      }

      return true;
    }

    /**
     * [validates description]
     * @return mixed
     */
    public static function UncoughtReference ($backTrace) {
      $error = new Error;

      $error->title = join ('::', [
        'Sami\Base\Error',
        '::UncoughtReference'
      ]);

      $error->message = join (' ', [
        'Calling a SamiBase Model',
        'Helper out of a Model context.'
      ]);

      $traceDatas = requires ('trace-datas')($backTrace);

      $error->handle ([
        'title' => 'Sami\\Base\\Error',
        'descriptions' => array (
          '<br />',
          ' - THE CALLED HELPER FUNCTION IS ONLY AVAILABLE' . (
            ' FOR USING INSIDE SAMI BASE MODELS;'
          ),
          ' - THEN, IT SHOULD NOT BE USED OUT OF THEM.'
        ),
        'paragraphes' => $traceDatas,
        'source' => $traceDatas
      ]);
    }

    /**
     * [validates description]
     * @return mixed
     */
    public static function Validates () {
      # Validate the function call
      # reference
      if (static::validateReference ()) {
        # The called class
        # Contains the model
        # reference inside the
        # model base store
        $modelName = strtolower (static::class);
        # Stop function execution if
        # The current model was not
        # previously stored and configured
        if (!isset (self::$obmodels [$modelName])) {
          return self::UncoughtReference (debug_backtrace ());
        }
        # Store the object model for the
        # current inside the 'model' var.
        $model = self::$obmodels [
          # The current model
          # index, inside the
          # base object model
          $modelName
        ];
        # ...
        # List of the sent arguments
        # to the function context
        $args = func_get_args ();
        # List of the attributes to
        # validates with the given
        # rules
        $attrs = array_slice ($args, 0, -1 + count ($args));
        # Attributes rules
        $rules = array_last_i ($args);

        $attrsCount = count ($attrs);

        for ($i = 0; $i < $attrsCount; $i++) {
          if ( !is_string ($attrs [$i])) {
            continue;
          }

          $model->config_attr ($attrs [ $i ], $rules);
        }
      }
    }

    /**
     * [validates description]
     * @return mixed
     */
    public static function ValidatePresenceOf () {
      # Validate the function call
      # reference
      if (static::validateReference ()) {
        # The called class
        # Contains the model
        # reference inside the
        # model base store
        $modelName = strtolower (static::class);
        # Stop function execution if
        # The current model was not
        # previously stored and configured
        if (!isset (self::$obmodels [$modelName])) {
          return self::UncoughtReference (debug_backtrace ());
        }
        # ...
        $args = func_get_args ();
        $argsCount = count ($args);

        for ($i = 0; $i < $argsCount; $i++) {
          # Make sure the current argument
          # is a string
          if (!is_string ($args [$i]) && $args [$i]) {
            continue;
          }

          static::validates ($args [$i], ['presence' => true]);
        }
      }
    }

    /**
     * [validates description]
     * @return mixed
     */
    public static function ValidateUniquenessOf () {
      # Validate the function call
      # reference
      if (static::validateReference ()) {
        # The called class
        # Contains the model
        # reference inside the
        # model base store
        $modelName = strtolower (static::class);
        # Stop function execution if
        # The current model was not
        # previously stored and configured
        if (!isset (self::$obmodels [$modelName])) {
          return self::UncoughtReference (debug_backtrace ());
        }
        # ...
        $args = func_get_args ();
        $argsCount = count ($args);

        for ($i = 0; $i < $argsCount; $i++) {
          # Make sure the current argument
          # is a string
          if (!is_string ($args [$i]) && $args [$i]) {
            continue;
          }

          static::validates ( $args [$i], ['unique' => true]);
        }
      }
    }

    /**
     * [validates description]
     * @return mixed
     */
    public static function HasMany () {
      # Validate the function call
      # reference
      if (static::validateReference ()) {
        # The called class
        # Contains the model
        # reference inside the
        # model base store
        $modelName = strtolower (static::class);
        # Stop function execution if
        # The current model was not
        # previously stored and configured
        if (!isset (self::$obmodels [$modelName])) {
          return self::UncoughtReference (debug_backtrace ());
        }
        # ...
        $args = func_get_args ();
        $argsCount = count ($args);

        for ($i = 0; $i < $argsCount; $i++) {
          # Make sure the current argument
          # is a string
          if (!is_string ($args [$i]) && $args [$i]) {
            continue;
          }

          #static::validates ( $args [$i], ['unique' => true]);
        }
      }
    }

    /**
     * [validates description]
     * @return mixed
     */
    public static function HasOne () {
      # Validate the function call
      # reference
      if (static::validateReference ()) {
        # The called class
        # Contains the model
        # reference inside the
        # model base store
        $modelName = strtolower (static::class);
        # Stop function execution if
        # The current model was not
        # previously stored and configured
        if (!isset (self::$obmodels [$modelName])) {
          return self::UncoughtReference (debug_backtrace ());
        }
        # ...
        $args = func_get_args ();
        $argsCount = count ($args);

        for ($i = 0; $i < $argsCount; $i++) {
          # Make sure the current argument
          # is a string
          if (!is_string ($args [$i]) && $args [$i]) {
            continue;
          }

          #static::validates ( $args [$i], ['unique' => true]);
        }
      }
    }

    /**
     * [Has description]
     * @return mixed
     */
    public static function Has () {
      # Validate the function call
      # reference
      if (static::validateReference ()) {
        # The called class
        # Contains the model
        # reference inside the
        # model base store
        $modelName = strtolower (static::class);
        # Stop function execution if
        # The current model was not
        # previously stored and configured
        if (!isset (self::$obmodels [$modelName])) {
          return self::UncoughtReference (debug_backtrace ());
        }
        # ...
        $args = func_get_args ();
        $argsCount = count ($args);

        for ($i = 0; $i < $argsCount; $i++) {
          # Make sure the current argument
          # is a string
          if (!is_string ($args [$i]) && $args [$i]) {
            continue;
          }

          #static::validates ( $args [$i], ['unique' => true]);
        }
      }
    }

    /**
     * [BelongsTo description]
     * @return mixed
     */
    public static function BelongsTo () {
      # Validate the function call
      # reference
      if (static::validateReference ()) {
        # The called class
        # Contains the model
        # reference inside the
        # model base store
        $modelName = strtolower (static::class);
        # Stop function execution if
        # The current model was not
        # previously stored and configured
        if (!isset (self::$obmodels [$modelName])) {
          return self::UncoughtReference (debug_backtrace ());
        }
        # ...
        $args = func_get_args ();
        $argsCount = count ($args);

        for ($i = 0; $i < $argsCount; $i++) {
          # Make sure the current argument
          # is a string
          if (!is_string ($args [$i]) && $args [$i]) {
            continue;
          }

          #static::validates ( $args [$i], ['unique' => true]);
        }
      }
    }

    /**
     * [BelongsToMany description]
     * @return mixed
     */
    public static function BelongsToMany () {
      # Validate the function call
      # reference
      if (static::validateReference ()) {
        # The called class
        # Contains the model
        # reference inside the
        # model base store
        $modelName = strtolower (static::class);
        # Stop function execution if
        # The current model was not
        # previously stored and configured
        if (!isset (self::$obmodels [$modelName])) {
          return self::UncoughtReference (debug_backtrace ());
        }
        # ...
        $args = func_get_args ();
        $argsCount = count ($args);

        for ($i = 0; $i < $argsCount; $i++) {
          # Make sure the current argument
          # is a string
          if (!is_string ($args [$i]) && $args [$i]) {
            continue;
          }

          #static::validates ( $args [$i], ['unique' => true]);
        }
      }
    }
  }}
}
