<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\ParamContextBootstrapper
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
namespace Sammy\Packs\Sami\ParamContextBootstrapper {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\ParamContextBootstrapper\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   * Sami\ParamContextBootstrapper module.
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
    /**
     * @var boolean $done
     */
    private static $done = false;

    /**
     * @method void BootstrappParamContext
     *
     * @param Param $paramContext
     *
     */
    public static function BootstrapParamContext ($paramContext = null) {
      if (self::$done) return;

      /**
       *
       * The current module's going to create
       * and at live execution time a global
       * class that'll contain the request
       * parameters as constants on it; and
       * according to the parameter content,
       * it'll treat as they was sent and
       * implitly attribute a type for each
       * parameter value, in spite of the
       * original type for each value be
       * allways string they'll be used as
       * they was sent from the current request.
       * --- ---
       * Preview:
       * --- ---
       * class params {
       *  const id = 1;
       *  const action = 'create';
       * }
       * -
       * It also'll provide a global constant
       * that'll contain the parameter names
       * refering the acosiated value inside the
       * '$params' object.
       * With the difference that this constant
       * will not filter the parameter names matching
       * with the variable names pattern, will store whole
       * the params inside that as an index of the 'params'
       * contant array.
       * --- --- eg:
       * params['id'] # Getting the parameter 'id' value
       * --- ---
       */

      # Params
      # The parameters list of whole
      # sent when importing the current
      # module, wich has to contain at the
      # first position the Param instance that
      # stores whole the parameters and values
      # sent by the current request.
      # It'll be used to configure a 'params'
      # class in the php global scope in order
      # storing a global way to have access to the
      # parameters sent by the http request.
      #
      # Look for the first position in the
      # '$args' array, if there is not any
      # element, take a null value to avoid
      # having errors when trying to get the
      # properties and values for the '$params'
      # variable.
      $params = $paramContext;
      # clcd -> Class Code
      # Initializing a class code with a class
      # definition signature, declaring the
      # 'params' class and then fill it with
      # each param name and value as contant
      # and value.
      $clcd = 'if (!class_exists (\'params\')) {class params {use Sammy\Packs\Sami\ParamContextBootstrapper\Base;';
      # Getting whole the parameter names
      # inside the 'params' object in order
      # creating a constant for each inside the
      # 'params' class and have it as a constant
      # inside its scope.
      $param_names = array_keys ($params);
      # Count the '$param_names' array to
      # avoid doing that inside the loop
      # and have the length of the '$param_names'
      # array stored in the '$param_names_count'
      # variable.
      $param_names_count = count (
        # The array containg whole the
        # request parameter names.
        !is_array ($param_names) ? [] : $param_names
      );
      # ParamsArr -> Parameters Array
      # A store to fill a contant that
      # is going to make reference for
      # whole the sent parameter names and
      # values inside the '$params' object.
      # It'll store each key and value
      # according to the '$params' object
      # content.
      $paramsArr = array ();
      # Map the '$param_names' array to get each
      # param name inside it in order getting the
      # values one per one and configure the 'params'
      # class and the '$paramsArr' array step by step
      # until the end of the names list.
      # Finding a param name it'll check if the
      # current name matches the php variable names
      # pattern, if not it'll avoid creating a constant
      # with that name inside the 'params' class; otherwise
      # , it'll set it as a constant for the 'params' class.
      # But it will allways add it as element for the
      # '$paramsArr' array in order having that inside the
      # 'params' array.
      for ($i = 0; $i < $param_names_count; $i++) {
        # Param name
        # The current parameter name
        # inside the '$param_names
        # array according to the iterator.
        # This is the 'key', the constant
        # name inside the 'params' class
        # and the property (key) name inside
        # the 'params' array.
        # It'll have to be a right var name
        # in order being used as a constant
        # name for the 'params' class; otherwise,
        # it'll be found inside the 'params' array
        $param = $param_names [
          # Iterator
          # The Current position inside
          # the '$param_names' array.
          $i
        ];
        # Filter the current parameter
        # value, in order having it as
        # it was sent from the request.
        # If it is a numeric value, store
        # as number (flot or integer);

        # Store the '$param_value' as a
        # numeric value if it is a numeric
        # value.
        if (is_numeric ($params [$param])) {
          # Store the '$param_value'
          # as a numeric value
          # in order having it as
          # a number and make the
          # number operators available
          # for the same
          $param_value = $params [
            # The current parameter
            # name insi de the '$param_names'
            # array.
            $param
          ];
        } else {
          # Otherwise (It's not a string); store
          # the parameter value as a string, in order
          # avoiding to have a filter for an unknown
          # value type.
          $param_value = '\'' . (str ($params [$param]) . '\'');
        }
        # Avoid configuring a constant for
        # the 'params' class if '$param' string
        # is not a right variable name (that means
        # , it does not match to the php variable pattern).
        # In order matching to the pattern, it has to be a
        # string(!) and match to the variable name pattern.
        if (is_right_var_name ($param)) {
          # If matches, prepare to configure a constant
          # inside the 'params' class with the same name
          # as the parameter name with the same value as the
          # sent from the request.
          $clcd .= 'const ' . $param . ' = ' . (
            $param_value . ';'
          );
        }

        $paramsArr [ $param ] = (
          $params [$param]
        );
      }

      $requestInput = requires ('request-input');

      $input = $requestInput->getRequestInput ();

      if (!is_array ($input)) {
        $input = [];
      }

      $postDatas = (array) ($_POST);
      # clcd -> Class Code
      # End the class definition
      # setting a '}' char at the end
      # of the class code.
      $clcd .= '}}';
      # After doing that, end executing
      # the class generated code in order
      # having the class available for using
      # inside the application modules.

      defined ('params') or define ('params',  array_merge (
        $paramsArr, $postDatas, $input
      ));

      eval ($clcd);

    }

    /**
     * @method void get param
     */
    public static function get (string $param) {
      $paramReference = join ('::', [static::class, $param]);

      if (defined ($paramReference)) {
        return constant ($paramReference);
      }
    }
  }}
}
