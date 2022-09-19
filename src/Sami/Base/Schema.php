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
  use Sammy\Packs\Sami\Base\Cli\Migrator\TableList;
  use Sammy\Packs\Sami\Base as ESB;
  use Sammy\Packs\Func;
  use Closure;

  use function Sammy\Packs\Sami\Base\schema_version;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sami\Base\Schema')) {
  /**
   * @class Schema
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
  class Schema {
    /**
     * @var array primaryList
     */
    private static $primaryList = [];

    /**
     * @method void Define
     *
     * Create the schema for mapping the database
     * tables properties and it configurations stored
     * inside the schema global context.
     * So, the safe datas could be used to automatically
     * configure the application models acording to the
     * database structure.
     *
     * @param array $schemaDatas
     *
     * A map of the created schema datas.
     * Such as the general timestamp for the same,
     * saving the last time whole the schema migrations
     * where updated (runned).
     *
     * @param Closre $schemaDefinitionCallback
     *
     * A lambda called to run whole the schema
     * model actions.
     *
     * @return void
     */
    public static function Define ($schemaDatas = []) {
      if (!(is_array ($schemaDatas) &&
          isset ($schemaDatas ['version']) &&
          self::validVersion ($schemaDatas ['version']))) {
        exit ('No version for schema definition ' . __FILE__);
      }

      self::runCallback ();
    }


    public static function AddTable ($tableName, $options = []) {
      if (!(is_array ($options) &&
        isset ($options ['map']) &&
        is_bool ($options ['map']) &&
        !$options ['map'])) {
        $tableList = new TableList;

        $tableList->add ($tableName);
      } else {
        self::$primaryList [] = $tableName;
      }

      self::runCallback ();
    }

    /**
     * @method array PrimaryList
     */
    public static function GetPrimaryList () {
      return self::$primaryList;
    }

    /**
     * @method void runCallback
     */
    private static function runCallback () {
      $backTrace = debug_backtrace ();

      $trace = $backTrace [0];

      if (isset ($backTrace [1])) {
        $trace = $backTrace [1];
      }

      if (isset ($trace ['args']) &&
        is_array ($trace ['args']) &&
        count ($trace ['args']) >= 1) {
        $args = $trace ['args'];

        $lastArg = $args [-1 + count ($args)];

        if ($lastArg instanceof Closure) {
          $callback = new Func ($lastArg);

          $callback->apply (new static, []);
        }
      }
    }

    protected static function validVersion ($version) {
      return true;
      #return (string)$version == ESB::SchemaVersion ();
    }
  }}
}
