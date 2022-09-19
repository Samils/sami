<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base\Cli
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
namespace Sammy\Packs\Sami\Base\Cli {
  use Sammy\Packs\Sami\CommandLineInterface\Template;
  use Sammy\Packs\Sami\CommandLineInterface\Console;
  use Application\Model\SchemaMigration;
  use Sammy\Packs\Sami\Base\Table;
  use Sammy\Packs\Sami\Base;
  use Sami\Base\Migration;

  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Base\Cli\Migrator')) {
  /**
   * @class Migrator
   * Base internal class for the
   * Sami\Base\Cli module.
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
  class Migrator {
    use Migrator\Base;
    use Migrator\Helper\Base;
    use Migrator\Helper\Prepare;
    use Migrator\SchemaFileGenerator;

    /**
     * [migrate description]
     * @return [type] [description]
     */
    public static function Migrate () {
      # Get whole the declared classes until
      # the current moment, in order filtering
      # the migrations classes to manually
      # configure for using it after that.
      $classes = get_declared_classes ();

      # Tables to chacnge
      # , An array containg a list
      # of table names that'll be
      # changed; or wich some of migrations
      # has been changed in order updating it.
      # It is used because of the tables and
      # migrations list be used in different
      # loops and these has not got the same
      # datas.
      $tables2change = new Migrator\TableList;

      $t = timestamp ();

      # Configure the Schema_Migrations
      # class. it enable to use the same
      # as a model for getting informations
      # about any shema migration containg
      # inside it.
      # This is a feature used to know
      # wich migrations was updated and what
      # time was they exactly updated in order
      # comparing it with the migration file
      # last modify timestamp.
      # The reason is knowing what tables
      # should or not be updated.
      #SchemaMigration::Configure ();

      Base::LoadPrimaryDatabaseSchema ();
      # Run away the '$classes' array
      # to get whole the class reference
      # inside the php global scope.
      foreach ($classes as $class) {
        $classParents = class_parents ($class);
        # Skip if the current class is not
        # an instance of 'Sami\Base\Migration'
        # class, because it has not to be a
        # migration and should not be usefull at
        # this time.
        if (!in_array (Migration::class, $classParents)) {
          continue;
        }

        # Instance the migration class
        # to get whole of its public
        # properties and methods in order
        # getting informations about the
        # current migration according to the
        # called function inside its change
        # method closure body.
        # This informations sould containg
        # the migration timestamp, file name,
        # table name and other infromations that
        # should be usefull when migrating the
        # database to know what tables to update
        # or keep as they are at the momment because
        # os missing updates.
        $migration = new $class (
          # Send a null value to the migration
          # instance to avoid usig the sent
          # parameter as a migration data that
          # should configure it inside the schema
          # structure.
          null
        );

        # For running a migration, it's to
        # contain a method who does it inside
        # the same, verify is the $migration
        # object contains a 'change' method.
        # Otherwise, look for an up method
        # and a down method in order doing
        # the migration fall back if something
        # go wrong with the table creation.
        if (method_exists ($migration, 'change')) {
          # Execute the change method to run
          # the migration and draw the table
          # structure in the database.
          # In this method is done the main
          # action about the table creation or
          # alteration in case of no errors or
          # exceptions found when doing that.
          # args: array $migration_datas
          # That is a trace data from the migration
          # file, used to locate the migration and
          # get informations about the same such as
          # the timestamp (when was the migration created),
          # the migration file name and the table relationed
          # to that migration.
          # It says, when something changes in the migration
          # context, the called action'll assume and do the
          # given task to the same, other wise it means there
          # is something wrong with the called action, so, do
          # the contrary in order getting the previous state of
          # the table in the database and redo that late.
          call_user_func_array ([$migration, 'change'], array (
            # Send to the migration change method
            # an array that'll contain a reference
            # about the called action inside the
            # 'change'.
            # This is done to know what to do when
            # trying to do the fall back in case of
            # errors or exception while calling the
            # main action for the migration context.
            # It alse'll contain informations such as
            # the trace and the error or exception
            # datas, that'll help ils showing out that
            # log in the out std.
            []
          ));

          # Prepare the migration to or not to run.
          # The current preparation includes a verification
          # about the migration creation and modification
          # timestamp.
          # These informations will be used to
          # know if the current migration was
          # already runned or not in order avoiding
          # to run the same migration more than one time
          # before a new update on it in the databse;
          # if it verify that the current migration
          # was already runned it just avoid and stop
          # executing the function to skip and go
          # to the next migration in the list, otherwise,
          # run it and store the migration timestamp and last
          # modify timestamp of the migration file in the
          # 'schema_migrations' table in the application
          # database
          self::prepare ($tables2change, $migration, $t);
        } elseif (method_exists ($migration, 'up')) {
          # Execute the up method to run
          # the migration and draw the table
          # structure in the database.
          # In this method is done the main
          # action about the table creation or
          # alteration in case of no errors or
          # exceptions found when doing that.
          # args: array $migration_datas
          # That is a trace data from the migration
          # file, used to locate the migration and
          # get informations about the same such as
          # the timestamp (when was the migration created),
          # the migration file name and the table relationed
          # to that migration.
          # It says, when the migration start being runned
          # , it is up and the 'up' method'll be called to
          # execute the action that it's to, if something
          # go wrong, look for a down method in order doing
          # the fall back but if there is not a down method
          # keep and do not do anything.
          call_user_func_array ([$migration, 'up'], array (
            # Send to the migration change method
            # an array that'll contain a reference
            # about the called action inside the
            # 'change'.
            # This is done to know what to do when
            # trying to do the fall back in case of
            # errors or exception while calling the
            # main action for the migration context.
            # It alse'll contain informations such as
            # the trace and the error or exception
            # datas, that'll help ils showing out that
            # log in the out std.
            []
          ));

          # Prepare the migration to or not to run.
          # The current preparation includes a verification
          # about the migration creation and modification
          # timestamp.
          # These informations will be used to
          # know if the current migration was
          # already runned or not in order avoiding
          # to run the same migration more than one time
          # before a new update on it in the databse;
          # if it verify that the current migration
          # was already runned it just avoid and stop
          # executing the function to skip and go
          # to the next migration in the list, otherwise,
          # run it and store the migration timestamp and last
          # modify timestamp of the migration file in the
          # 'schema_migrations' table in the application
          # database
          self::prepare ($tables2change, $migration, $t);
        }
      }

      $tables = (array) (Table::All ());

      # Get a list of whole the created
      # tables from migrations and the schema
      # base context.

      #print_r($tables2change->all ());

      #exit (0);

      #$schemaFilePath = path ('@db/schema.php');

      #$schemaFileLines = \php\requires('./schemaFileLines',
      #  $t
      #);


      # Todo DropReferalTables():
      # Get whole the table names that creates reference
      # with the current one  being migrated in order storing
      # its datas and dropping it from the database before
      # migrating the current table to the database.
      # End Todo
      # Table::DropList (array_reverse (array_keys ($tables)));

      $tableList2Change = $tables2change->all ();

      if (!(count ($tableList2Change) >= 1)) {

        Console::Warning ("\n", 'Whole the migrations up to date.!');

        self::GenerateSchemaFileIfNotExists ($t);

        return;
      }

      foreach ($tables as $table => $structure) {
        /**
        $structure_str = self::stringifyModelStructure (
          $structure
        );

        $schemaFileLines = array_merge ($schemaFileLines, [
          join ('', [
            "\t\tcreate_table ('{$table}', ",
            $structure_str,
            ");\n"
          ])
        ]);
        */

        # ... Create the table
        # Before creating (updating) the
        # table structure in the database,
        # verify is a migration relationed
        # to it was lately added or changed
        # in order warrating that only the
        # changed migrations are runned to
        # update the database structure.
        if (in_array (strtolower ($table), $tableList2Change)) {
          # Get whole the table names that creates
          # reference with the current one
          # being migrated in order storing
          # its datas and dropping it from
          # the database before migrating
          # the current table to the database.
          $referalTables = Table::DropReferalTables ($table);

          $tableList2Change = array_merge (
            $tableList2Change,
            $referalTables
          );

          #print_r($referalTables);
          #echo "\n\n\n", $table, "\n\n\n";
          Table::Create ($table, $structure);
        }
      }

      self::GenerateSchemaFile ($t);

      /**
      Console::Log ("\n\nGenerating database map...\n\n");
      self::updateSchemaVersion ($t);

      Template::Generate ('schema-file-lines', [
        'target' => 'db',
        'props' => [
          'name' => 'schema',
          'version' => $t,
          'body' => join ("\n", $schemaFileLines)
        ]
      ]);
      */

      # Update Schema File
      #$schema->writeLines ($schemaFileLines);
    }
  }}
}
