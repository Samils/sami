<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base\Cli\Migrator
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
namespace Sammy\Packs\Sami\Base\Cli\Migrator {
  use Sammy\Packs\Sami\CommandLineInterface\Template;
  use Sammy\Packs\Sami\CommandLineInterface\Console;
  use Sammy\Packs\Sami\Base\Table;
  use Sami\Base\Schema;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Base\Cli\Migrator\SchemaFileGenerator')) {
  /**
   * @trait SchemaFileGenerator
   * Base internal trait for the
   * Sami\Base\Cli\Migrator module.
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
  trait SchemaFileGenerator {
    /**
     * @method void generateSchemaFile
     *
     * Generate the 'db/schema.php' file.
     *
     * Generate the database map file for holding the
     * structure of it in a ...
     *
     * @param int $schemaVersion
     *
     * A timestamp defining the version of the
     * current database schema file
     *
     * @return void
     */
    public static function GenerateSchemaFile ($schemaVersion = null) {
      $schemaFileLines = [];

      if (is_null ($schemaVersion)) {
        $schemaVersion = self::SchemaVersion ();
      }

      $tables = Table::All ();

      foreach ($tables as $tableName => $structure) {

        $schemaPrimaryTables = Schema::GetPrimaryList ();

        if (is_array ($schemaPrimaryTables)
          && in_array ($tableName, $schemaPrimaryTables)) {
          continue;
        }

        $structure_str = self::stringifyModelStructure ($structure);

        $schemaFileLines = array_merge ($schemaFileLines, [
          join ('', [
            "\t\tcreate_table ('{$tableName}', ",
            $structure_str,
            ");\n"
          ])
        ]);
      }

      Console::Log ("\n\nGenerating database map...\n\n");
      self::updateSchemaVersion ($schemaVersion);

      Template::Generate ('schema-file-lines', [
        'target' => 'db',
        'props' => [
          'name' => 'schema',
          'version' => $schemaVersion,
          'body' => join ("\n", $schemaFileLines)
        ]
      ]);
    }

    /**
     * @method void generateSchemaFileIfNotExists
     *
     * Generate the 'db/schema.php' file.
     *
     * Generate the database map file if it does not exists.
     *
     * @param int $schemaVersion
     *
     * A timestamp defining the version of the
     * current database schema file
     *
     * @return void
     */
    public static function GenerateSchemaFileIfNotExists ($schemaVersion = null) {
      if (!is_file ('db/schema.php')) {
        self::GenerateSchemaFile ($schemaVersion);
      }
    }
  }}
}
