<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sami\Base
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
namespace Sami\Base {
  use FileSystem\File;
  use Sammy\Packs\Singular;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sami\Base\Migration')) {
  /**
   * @class Migration
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
  class Migration {
    /**
     * [$trace description]
     * @var array
     */
    private $trace = [];

    public final function __construct () {}

    public final function setTrace ($trace) {
      if (!!(is_array ($trace) && $trace)) {
        $this->trace = $trace [0];
      }
    }

    public final function getFile () {
      if (isset ($this->trace ['file'])) {
        return (string) ($this->trace ['file']);
      }
    }

    public final function getTableName () {
      if (isset ($this->trace ['args']) &&
          count ($this->trace['args'])) {
        $singular = new Singular;

        return $singular->parse ($this->trace ['args'][0]);
      }
    }

    public final function getFileName () {
      return File::Name ($this->getFile ());
    }

    public final static function ConfigTrace ($backTrace) {
      $trace1 = isset ($backTrace[1]) ? $backTrace[1] : [];

      if (isset ($trace1 ['class'])) {
        # Class Name
        $cl = $trace1 ['class'];

        if (in_array (__CLASS__, class_parents ($cl))) {
          $migration_object = isset ($trace1 ['object']) ? $trace1 ['object'] : (
            new $cl
          );
          # Interact with the migration
          # object
          $migration_object->setTrace ($backTrace);
        }
      }
    }
  }}
}
