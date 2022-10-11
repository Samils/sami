<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base\Cli\Migrator\Helper
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
namespace Sammy\Packs\Sami\Base\Cli\Migrator\Helper {
  use Application\Model\SchemaMigration;
  use Sammy\Packs\Sami\Base as SamiBase;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Base\Cli\Migrator\Helper\Prepare')) {
  /**
   * @trait Prepare
   * Base internal trait for the
   * Sami\Base\Cli\Migrator\Helper module.
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
  trait Prepare {
    /**
     * [MigrationPrepare description]
     * @param array  &$tables2change
     * @param [type] $migration
     */
    private static function prepare ($tables, $migration, $t) {

      # Call a function everything bellow
      # passing: $tables2change, $migration
      $format = requires ('format');

      $str = (
        ("\n{|color:yellow}{}\033[0m\n")
      );

      # migration file name
      $mfn = $migration->getFileName ();
      # migration last modify
      $mld = filemtimestamp ($migration->getFile ());

      preg_match ('/^([0-9]{1,14})/i', $mfn,
        # Get the migration timestamp
        # from the correspondent file
        # name in order knowing when was
        # the migration created.
        # store this in an array and
        # get the value bellow.
        $migration_ts
      );

      $mg_get = SchemaMigration::where ([
        'migration_file_name' => $mfn
      ]);

      $conn = SamiBase::getAdapterInstance ();
      # Verify if the current migration was
      # changed recently.
      # Check if the date in the database
      # matches the change date of the
      # migration file; if it matches supose the
      # migration was not changed and keep the
      # table like it is but other wise do the
      # contrary, updating the table in the db.

      if (!(is_array ($mg_get) && count ($mg_get) >= 1)) {
        $tables->add ($migration->getTableName ());

        $mg = new SchemaMigration ([
          'migration_file_name' => $mfn,
          'migration_timestamp' => (
            !isset($migration_ts [0]) ? '' : (
              $migration_ts [0]
            )
          ),
          'migration_last_modify' => $mld,
          'migration_table_name' => $migration->getTableName()
        ]);

        $mg->save ();

        self::updateSchemaVersion ($t);
      } else {
        $mg = $mg_get [0];
        # Compare the migration last modify
        # date from the database with the
        # information comming fromthe file

        if ($mld === $mg->migration_last_modify && $conn->tableExists ($migration->getTableName ())) {
          return;
        } else {
          $tables->add ($migration->getTableName ());

          SchemaMigration::update ([
            'migration_last_modify' => $mld,

            'where()' => ['migration_file_name' => $mfn]
          ]);

          self::updateSchemaVersion ($t);
        }
      }

      echo $format->format ($str, 'Preparing ',$migration->getFileName ());
      self::logMigrationDatas ($migration, $mg);
    }

    private static function logMigrationDatas ($migration, $mg) {
      echo "\n", get_class ($migration), "\n - Table => ", $migration->getTableName (), "\n - Last Modify => ", self::formatTimestamp ($mg->migration_last_modify), "\n\n";
    }

    private static function formatTimestamp ($timestamp) {
      $date = substr ($timestamp, 0, 8);

      $year = substr ($date, 0, 4);
      $month = substr ($date, 4, 2);
      $day = substr ($date, 6, 2);

      $time = substr ($timestamp, 8, 6);

      $times = preg_replace_callback (
        '/([0-9]){2}/',
        function ($match) {
          return join ('', [':', $match [0]]);
        },
        $time
      );

      return join (' ', [
        join (':', [$day, $month, $year]),
        preg_replace ('/^:+/', '', $times)
      ]);
      #return $timestamp;
    }
  }}
}
