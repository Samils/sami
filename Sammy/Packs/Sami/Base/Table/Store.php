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
  use Sammy\Packs\Sami\Base as SamiBase;
  use Sammy\Packs\Sami\Base\Cli\Migrator;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Base\Table\Store')) {
  /**
   * @trait Store
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
  trait Store {
    /**
     * [$Store description]
     * @var array
     */
    private static $Store = [];

    /**
     * [$Tables description]
     * @var array
     */
    private static $Tables = [];

    /**
     * @var array
     *
     * created table names list
     */
    private static $createdTableNames = [];

    /**
     * @var array
     *
     * table options
     */
    private static $tableOptions = [];

    /**
     * [Define description]
     * @param string $name  [description]
     * @param array  $datas [description]
     */
    public static function Define ($name = '', $options = []) {
      $props = func_get_arg (-1 + func_num_args ());

      if (is_string ($name) && is_array ($props) &&
        in_array (strtolower ($name), self::$Tables)) {
        self::$tableOptions [strtolower ($name)] = array_merge (
          ['options' => $options],
          ['trace' => debug_backtrace ()]
        );

        self::$Store [ strtolower ($name) ] = $props;
      }
    }

    /**
     * [Merge description]
     * @param string $table [description]
     * @param string $col   [description]
     * @param array  $props [description]
     */
    public static function Merge ($table = '', $col = '', $props = []) {
      $table = strtolower ($table);
      if (self::Exists ($table) && is_right_var_name ($col)) {

        $colsType = self::columnTypes ();

        if (!(is_array ($colsType) &&
          isset ($colsType [$props ['@type']]))) {
          return;
        }

        $column = new Column ($props,
          $props['@type'] . $colsType [$props ['@type']]
        );
        self::$Store [$table][strtolower ($col)] = (
          $column->getProps ()
        );
      }
    }

    /**
     * [Exists description]
     * @param string $name [description]
     */
    public static function Exists ($name = '') {
      if (is_string ($name) &&
        !empty ($name) &&
        isset (self::$Store [strtolower ($name)])) {
        return self::$Store [strtolower ($name)];
      }

      return false;
    }

    public static function Read ($tableName = null) {
      $tables = self::$Store;

      if ($table = self::Exists ($tableName)) {
        return $table;
      }
    }

    public static function All () {
      return self::$Store;
    }

    public static function ClearStore () {
      if (self::_calledFromMigrator ()) {
        self::$Store = [];
      }
    }

    /**
     * [DropColumn description]
     * @param string $table  [description]
     * @param string $column [description]
     */
    public static function DropColumn ($table = '', $column = '') {
      if (!self::Exists ($table)) {
        return;
      }

      $table = strtolower ($table);
      $column = strtolower ($column);

      if (isset (self::$Store [$table][$column])) {
        unset (self::$Store [$table][$column]);
      }
    }

    /**
     * [ChangeColumn description]
     * @param string $on    old name
     * @param string $nn    new name
     * @param string $table the table where finding the colulmn to change
     */
    public static function ChangeColumn ($oldName = null, $newName = null, $table = null) {
      $props = func_get_arg (func_num_args () - 1);

      if (!is_array ($props)) {
        $props = array ();
      }

      $table   = strtolower ($table);
      $newName = strtolower ($newName);
      $oldName = strtolower ($oldName);

      if (!self::Exists ($table)) {
        exit ($table . ' Nao esiste'. "\n");
      }

      if (isset (self::$Store [$table][$oldName])) {
        unset (self::$Store [$table][$oldName]);

        self::$Store [$table][$newName] = $props;
      }
    }

    public static function RenameColumn ($table = null, $oldName = null, $newName = null) {
      if (!self::Exists ($table)) {
        exit ($table . ' Nao esiste'. "\n");
      }

      if (isset(self::$Store [$table][$oldName])) {
        $props = array_merge (self::$Store [$table][$oldName]);
        unset (self::$Store [$table][$oldName]);

        self::$Store [$table][$newName] = $props;
      }
    }


    protected static function validateRef () {
      if (!(php_sapi_name () === 'cli')) {
        return;
      }

      $backTrace = debug_backtrace ();
      $trace = requires ('trace-datas')(
        $backTrace [2]
      );

      if (!!(Migrator::class === $trace->class ||
        self::class === $trace->class ||
        static::class === $trace->class)) {
        $conn = SamiBase::getAdapterInstance ();
        return is_object ($conn) ? $conn : false;
      }
    }

    public static function GetReferalTables ($referenceTable) {
      $tableList = self::All ();

      $referals = [];
      #print_r($tableList); exit (0);
      foreach ($tableList as $tableName => $tableColumnList) {
        /**
         * Map the table column list and try matching
         * a reference property pointning to the current
         * $referenceTable
         */
        foreach ($tableColumnList as $columnName => $columnProps) {
          if (is_array ($columnProps) &&
            isset ($columnProps ['reference'])) {
            $columnReference = Migrator::readReference ($columnProps ['reference']);

            if (is_array ($columnReference) &&
              isset ($columnReference [1]) &&
              strtolower ($columnReference [1]) === strtolower ($referenceTable)) {
              array_push ($referals, strtolower ($tableName));
            }
          }
        }
      }

      return $referals;
    }

    public static function GetReferenceTables ($tableName) {
      $tableData = self::Read ($tableName);

      if (!$tableData) {
        return [];
      }

      $referenceTableList = [];

      foreach ($tableData as $prop => $value) {
        if (is_array ($value) && isset ($value ['reference'])) {
          $reference = Migrator::readReference ($value ['reference']);

          if (is_array ($reference) && isset ($reference [1])) {
            array_push ($referenceTableList, strtolower ($reference [1]));
          }
        }
      }

      return $referenceTableList;
    }

    public static function DropReferalTables ($referenceTable) {
      $referalTables = self::GetReferalTables ($referenceTable);

      #echo "Table Name => $referenceTable\n\n";
      #print_r ($referalTables);
      #echo "\n\n\n";

      self::DropList ($referalTables);

      return $referalTables;
    }

    public static function Drop ($table) {
      if ($conn = self::validateRef ()) {
        $conn->dropTable ($table);
      }
    }

    public static function DropList ($tableList) {
      if (is_array ($tableList) && $tableList) {
        foreach ($tableList as $i => $table) {
          self::Drop ($table);
        }
      }
    }

    public static function Created ($tableName) {
      return in_array ($tableName, self::$createdTableNames);
    }

    public static function Create ($table, $body) {
      if ($conn = self::validateRef ()) {
        $conn->model ($table, true, $body);

        array_push (self::$createdTableNames, $table);
      }
    }
  }}
}
