<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base\Table
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
namespace Sammy\Packs\Sami\Base\Table {
  use Sammy\Packs\Sami\Error;
  use Sami\Base\Migration;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Base\Table\Helper')) {
  /**
   * @trait Helper
   * Base internal trait for the
   * Sami\Base\Table module.
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
  trait Helper {

    public static function rewriteType ($type) {
      $types_rewites = [
        'string' => 'varchar',
        'str' => 'varchar',
        'bool' => 'boolean',
        'integer' => 'int'
      ];

      $type = strtolower ($type);

      if (isset ($types_rewites [$type])) {
        $type = $types_rewites [$type];
      }

      return $type;
    }

    private static function columnTypes () {
      return [
        'varchar' => '(40)',
        'char' => '(40)',
        'string' => '(40)',
        'str' => '(40)',
        'tinyint' => '',
        'smallint' => '',
        'mediumint' => '',
        'int' => '(11)',
        'bigint' => '',
        'decimal' => '',
        'float' => '',
        'double' => '',
        'real' => '',
        'boolean' => '',
        'bool' => '',
        'bit' => '',
        'serial' => '',
        'date' => '',
        'datetime' => '',
        'timestamp' => '',
        'time' => '',
        'year' => '',
        'tinytext' => '',
        'text' => '',
        'mediumtext' => '',
        'longtext' => '',
        'binary' => '',
        'varbinary' => '',
        'tinyblob' => '',
        'blob' => '',
        'mediumblob' => '',
        'longblob' => ''
      ];
    }

    # public

    public function string () {
      return call_user_func_array ([$this, 'varchar'], func_get_args ());
    }

    public function str () {
      return call_user_func_array ([$this, 'varchar'], func_get_args ());
    }

    public function integer () {
      return call_user_func_array ([$this, 'int'], func_get_args ());
    }

    public function bool () {
      return call_user_func_array ([$this, 'boolean'], func_get_args ());
    }

    /**
     * @method Table references
     */
    public function references ($tableName = null) {
      if (!(is_string ($tableName) && $tableName)) {
        $error = new Error ('Invalid table name');
        return $error->handle ();
      }

      $colName = join ('_', [$tableName, 'id']);

      $col = $this->int ($colName);
      $col->reference (['id', 'inTable' => $tableName]);

      return $col;
    }

    public static function CreatedFromAMigration ($tableName) {
      $tableName = strtolower ($tableName);

      if (self::Exists ($tableName)) {
        $tableTrace = self::$tableOptions [$tableName]['trace'];

        return (boolean)(
          is_array ($tableTrace)
          && isset ($tableTrace [2])
          && is_array ($tableTrace [2])
          && isset ($tableTrace [2]['class'])
          && in_array (Migration::class, class_parents ($tableTrace [2]['class']))
        );
      }
    }

    public static function CreatedFromMap ($tableName) {
      $tableName = strtolower ($tableName);

      $index = 3;

      if (self::Exists ($tableName)) {
        $tableTrace = self::$tableOptions [$tableName]['trace'];

        #echo "Table Nme => $tableName\n\n\n\n";
        #print_r (array_slice ($tableTrace, 0, 5));
        #echo "\n\n\n\n\n\n\n";

        return (boolean)(
          is_array ($tableTrace)
          && isset ($tableTrace [$index])
          && is_array ($tableTrace [$index])
          && isset ($tableTrace [$index]['class'])
          && $tableTrace [$index]['class'] === Schema::class
        );
      }

    }
  }}
}
