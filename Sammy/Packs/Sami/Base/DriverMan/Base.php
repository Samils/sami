<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base\DriverMan
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
namespace Sammy\Packs\Sami\Base\DriverMan {
  use Samils\Application\Configure;
  use Sammy\Packs\Sami\Base\Table;
  use PDO as DataObject;
  use Sami\Base\Schema;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Base\DriverMan\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   * Sami\Base\DriverMan module.
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
     * [$DriverManDatas description]
     * @var array
     */
    private static $DriverManDatas = array (
      '@alternates' => array (),
      '@datas' => array ()
    );

    /**
     * [$dbcd_cache description]
     * @var boolean
     */
    private static $dbcd_cache = false;

    public function __construct () {
      $dbConnectionDatasCache = Configure::get ('database_connection_datas_cache');
      self::$dbcd_cache = $dbConnectionDatasCache ? $dbConnectionDatasCache : false;
      # ...
    }

    protected function createPrimaryTables ($adapter) {
      $primaryTables = Schema::GetPrimaryList ();

      foreach ($primaryTables as $table) {
        if ($props = Table::Read ($table)) {
          $adapter->model ($table, false, $props);
        }
      }
    }

    protected function createSchemaMigrationTable ($conn) {
      if ($conn instanceof DataObject) {
        $conn->exec (
          'create table if not exists `schemamigration` (' .
          'id int(11) not null auto_increment primary key' .
          ', `key` VARCHAR(25) not null' .
          ', migration_timestamp VARCHAR(300) not null' .
          ', migration_file_name VARCHAR(100) not null' .
          ', migration_last_modify VARCHAR(35) null default NULL' .
          ', migration_table_name varchar(200) not null' .
          ', updatedat DATETIME not null default CURRENT_TIMESTAMP' .
          ', createdat DATETIME not null default CURRENT_TIMESTAMP' .
          ')' .
          ';'
        );
      }
    }
  }}
}
