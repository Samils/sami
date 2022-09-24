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
  use App\Model\SchemaMigration as MigrationsSchema;
  use php\module;

  use function Samils\dir_boot;

  # TODO:
  #  Create a validator for references when using
  #  some sami\base methods that should not be used
  #  outside the library or by any other any unknown
  #  reference.
  # END

  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Base')) {
  /**
   * @class Base
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
  class Base {

    /**
     * @var boolean
     */
    private static $databaseConnected = false;

    /**
     * @var boolean
     */
    private static $SamiBaseFirstInstance = true;

    /**
     * @var array
     *
     * Database connection datas
     * sent by application-server
     * according to the current environment.
     * Including the conection alternates
     */
    private static $DatabaseConnectionDatas = null;

    /**
     * [$Conn description]
     * @var object
     */
    private static $conn;
    private static $sel;
    private static $config;

    public function __construct ($args) {
      self::$DatabaseConnectionDatas = (array)(
        !isset ($args ) ? [] : $args
      );

      $SamiBaseDataBaseSettings = ( boolean )(
        isset ($args ) &&
        is_array ($args ) &&
        isset ($args ['config']) &&
        is_array ($args ['config']) &&
        isset ($args ['config']['database']) &&
        is_array ($args ['config']['database'])
      );

      if ( $SamiBaseDataBaseSettings ) {
        self::$config = $args [ 'config' ];
        self::$DatabaseConnectionDatas['database'] = array_merge (
          self::$DatabaseConnectionDatas ['database'],
          $args ['config']['database']
        );
      }

      /**
       * [$databaseConnected description]
       * @var boolean
       */
      self::$SamiBaseFirstInstance = false;
      self::$sel = $this;
    }

    public function connect () {
      if (self::$databaseConnected) {
        return;
      }
      # Driver man
      # The sami-base module that manages
      # the comunication with a specific
      # driver in order getting informatios
      # from the database.
      $driverMan = new Base\DriverMan;
      # Now, try a connection to the
      # database according to the given
      # driver.
      # Send the database connection datas
      # to the driver man and wait for a
      # response in order procesing the
      # correct informations.
      # And then, store the connection
      # object inside the '$conn' var
      # in order avoiding to repeat the
      # same process without any major
      # reason in the life.
      self::$conn = $driverMan->tryConnection (
        self::$DatabaseConnectionDatas ['database'],
        ['props' => self::$DatabaseConnectionDatas ['props']]
      );

      self::configureApplicationModels ();

      /**
       * [$databaseConnected description]
       * @var boolean
       */
      self::$databaseConnected = !false;
    }

    public function conn () {
      return call_user_func_array ([$this, 'connect'], func_get_args ());
    }

    public static function SchemaVersionFile () {
      return __DIR__ . '/.schema-version';
    }

    public static function SchemaVersion () {
      $fs = requires ('fs');

      $schemaVersionFilePath = self::SchemaVersionFile ();
      $schemaVersionFile = $fs->useFile ($schemaVersionFilePath);

      return trim ($schemaVersionFile->read ());
    }

    public static function SetUpSchema () {
      $schemaFile = path ('@db/schema.php');

      if (is_file ($schemaFile)) {
        include_once ($schemaFile);
      }

      self::LoadPrimaryDatabaseSchema ();

      if (in_array (php_sapi_name (), ['cli'])) {
        dir_boot (path ('@db/migrations'));
      }
    }

    public static function getAdapterInstance () {
      return self::$conn;
    }

    public static function baseConfig () {
      self::loadSamiBaseModelFiles ();
    }

    public static function baseConnect () {
      if (is_object (self::$sel)) {
        self::$sel->connect ();
      }
    }

    private static function loadSamiBaseModelFiles () {
      # Boot 'app/models' directory in
      # order having whole the models
      # previously defined before setting
      # the correspondent configurations for
      # each of them according to the defined
      # migrations inside the migrations map
      # in the 'db/schema.php' file.
      dir_boot (path ('@models'));

      $path = requires ('path');

      $root = module::getModuleRootDir (__DIR__);

      $modelsPath = $path->resolve ($root, 'src', 'App', 'Model');

      dir_boot ($modelsPath);
    }

    private static function configureApplicationModels () {
      # Link Each migration to the corresponednt
      # model...
      # ...
      $tables = Base\Table::All ();

      foreach ($tables as $table => $props) {
        if ($model = self::modelClassExists ($table)) {
          $model::InitModelConfigurations ($props);
        }
      }
    }

    private static function modelClassExists ($model) {
      $modelClassNames = [
        $model,
        join ('\\', ['App', 'Model', $model]),
        join ('\\', ['Application', 'Model', $model])
      ];

      foreach ($modelClassNames as $modelClassName) {
        if (!!(class_exists ($modelClassName) &&
          in_array ('Sami\\Base', class_parents ($modelClassName)))) {
          return $modelClassName;
        }
      }

      return false;
    }

    public static function LoadPrimaryDatabaseSchema () {
      $path = requires ('path');

      $root = module::getModuleRootDir (__DIR__);

      $schemasPath = $path->resolve ($root, 'src', 'db', 'schemas');

      $schemasFileList = glob (join (DIRECTORY_SEPARATOR, [$schemasPath, '*.php']));

      $schemasFileListCount = count ($schemasFileList);

      for ($i = 0; $i < $schemasFileListCount; $i++) {
        include_once $schemasFileList [$i];
      }
    }
  }}
}
