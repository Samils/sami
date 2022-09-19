<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami
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
namespace Sammy\Packs\Sami {
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\RequestDatas')) {
  /**
   * @class RequestDatas
   * Base internal class for the
   * Sami module.
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
  class RequestDatas {
    use RequestDatas\Base;
    use RequestDatas\Route;

    /**
     * @var array request raw datas
     */
    private static $requestRawDatas;

    /**
     * @method array AcceptMethods
     *
     * Return whole the supported http request
     * methods [in an API or in a common web application].
     *
     * @return array
     */
    public static function AcceptMethods () {
      return [
        'get',
        'post',
        'put',
        'delete',
        'patch'
      ];
    }

    /**
     * @method boolean AcceptedMethod
     *
     * Verify if the given '$method' is an accepted
     * method based on the 'AccepetMethods' list.
     *
     * @return bollean
     */
    public static function AcceptedMethod ($method = null) {
      return in_array (lower ($method), self::AcceptMethods ());
    }

    /**
     * @method string RequestMethod
     *
     * Get the current request method.
     * This should be any one given if supported.
     *
     * But there is a way for making browsers devices
     * compatibles with the API request methods list;
     * a 'request.data_method' property should be sent
     * in the request body in order overriding the request
     * method name to be used as the one.
     *
     * '_POST' array should contain a 'request' property
     * whish should contain a 'data_method' property being
     * the used request method.
     *
     * @return string
     */
    public static function RequestMethod () {
      $server = self::GetRequestRawDatas ();
      $defaultMethod = lower ($server ['REQUEST_METHOD']);

      # Make sure '_POST' array containt a 'request'
      # property and it is an array containing a
      # 'data_method' property as a string to considere
      # it as the current request method.
      $customMethodSent = ( boolean ) (
        isset ($_POST ['request']) &&
        is_array ($_POST ['request']) &&
        isset ($_POST ['request']['data_method']) &&
        is_string ($_POST ['request']['data_method']) &&
        self::AcceptedMethod ($_POST ['request']['data_method'])
      );

      if ($customMethodSent) {
        return lower ($_POST ['request']['data_method']);
      }

      return $defaultMethod;
    }

    /**
     * @method array QueryString
     *
     * Get the complet request query string
     * in an array.
     *
     * Also read as array the query properties sent
     * as 'prop.key=>value' pairs.
     *
     * @return array
     */
    public static function QueryString () {
      $server = self::GetRequestRawDatas ();

      $qs = null;

      if (isset ($server ['QUERY_STRING'])
        && is_string ($server ['QUERY_STRING'])) {
        $qs = (string)($server ['QUERY_STRING']);
      }

      $queryString = [];
      $qs_arr = preg_split ( '/&+/', $qs );
      $qs_arr_count = count ($qs_arr);

      for ($i = 0; $i < $qs_arr_count; $i++) {
        $key_re = '/^([^=]+)=*/';

        if (preg_match ($key_re, $qs_arr [$i], $key_arr)) {
          $val = preg_replace ($key_re, '', $qs_arr [$i]);
          $queryString [trim ($key_arr [1])] = $val;
        }
      }

      return $queryString;
    }
  }}
}
