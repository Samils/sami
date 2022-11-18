<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Router
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
namespace Sammy\Packs\Sami\Router {
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Router\ParamList')) {
  /**
   * @class ParamList
   * Base internal class for the
   * Sami\Router module.
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
  class ParamList {
    /**
     * @var array
     *
     * param list
     */
    private $props = array ();

    public function __construct (array $props) {
      $this->setProps ($props);
    }

    public function __get (string $prop) {
      $prop = self::formatPropertyName ($prop);

      if (isset ($this->props [$prop])) {
        return $this->props [$prop];
      }
    }

    public function __isset (string $prop) {
      $prop = self::formatPropertyName ($prop);

      return isset ($this->props [$prop]);
    }

    protected function setProps (array $props) {
      foreach ($props as $prop => $value) {
        $this->setProp ($prop, $value);
      }
    }

    protected function setProp (string $prop, $value = null) {
      $prop = self::formatPropertyName ($prop);

      $this->props [$prop] = $value;
    }

    private static function formatPropertyName (string $propertyName) {
      return preg_replace ('/[^a-zA-Z0-9_]+/', '', strtolower ($propertyName));
    }
  }}
}
