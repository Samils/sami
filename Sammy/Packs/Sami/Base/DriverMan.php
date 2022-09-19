<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base
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
namespace Sammy\Packs\Sami\Base {
  use Sammy\Packs\Samils\ApplicationServerHelpers;
  use Sammy\Packs\Sami\Error;
  use PDO;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Base\DriverMan')) {
  /**
   * @class DriverMan
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
  class DriverMan {
    use DriverMan\Base;

    private $connectionDatas;
    /**
     * [tryConnection description]
     * @param  array  $connDatas [description]
     * @return object
     */
    public function tryConnection ($connDatas = [], $opts = null) {
      # Stop function execution if there is
      # not any sent data for being applied
      # in the driver in order connecting to the
      # database.
      # Stop the scrip because there is a
      # propability for bugging the application
      # before ariving in the view.
      # The connection informations must to be
      # given in order trying to connect to the
      # database.
      if (!(is_array ($connDatas) && $connDatas)) {
        return Error::NoConnectionDatas ();
      }

      # Get Whole the sent connection datas
      # and store that inside the the '$DriverManDatas'
      # array property in order sending them to the
      # adapter.
      # Taking that '@' is the alternate name identifier,
      # skip if the name has got an at char at the beggining
      # of the property name in order storing it as a connection
      # alternate.
      foreach ($connDatas as $data => $value) {

        $isAlternate = ( boolean ) (
          is_int ($data) &&
          is_array ($value) &&
          isset ($value ['alternate']) &&
          is_string ($value ['alternate'])
        );

        if ( !$isAlternate ) {
          self::$DriverManDatas ['@datas'][$data] = $value;
        }
      }

      # Get Whole the sent connection datas
      # and store that inside the the '$DriverManDatas'
      # array property in order sending them to the
      # adapter.
      # Taking that '@' is the alternate name identifier,
      # skip if the name has got an at char at the beggining
      # of the property name in order storing it as a connection
      # alternate.
      foreach ($connDatas as $data => $value) {

        $isAlternate = ( boolean ) (
          is_int ($data) &&
          is_array ($value) &&
          isset ($value ['alternate']) &&
          is_string ($value ['alternate'])
        );

        if ( $isAlternate ) {
          $alternateKey = $value ['alternate'];
          self::$DriverManDatas ['@alternates'][$alternateKey] = (
            array_merge (self::$DriverManDatas[ '@datas' ],
              $value
            )
          );
        }
      }
      # $stoneCA
      # Stone Connection Alternate
      # A random name with a simple
      # pattern on it.
      $stoneCA = '__TryStone' . timestamp () . (
        'Connection'
      );
      # Auto configure the stone database
      # in order using it as the last
      # alternate for connecting the database.
      # This should be a file based database
      # in order making sure the connection will
      # be done when arriving until this alternate
      self::$DriverManDatas ['@alternates'][$stoneCA] = [
        'adapter' => 'stone',
        'database' => 'Stone' . environment(),
        'pool' => true,
        'timeout' => 1000
      ];

      $opts = is_array ($opts) ? $opts : [];

      $props = isset ($opts ['props']) ? $opts ['props'] : [
        'alternates' => false
      ];

      # self::$DriverManDatas[ '@alternates' ]
      # Connection Datas
      $cd = ( # Get connection datas
        self::$DriverManDatas ['@datas']
      );

      $this->connectionDatas = $cd;

      if (!(isset ($cd ['adapter']))) {
        Error::NoAdapter ();
      }

      # Cache adapter object after doing
      # it in the first time
      $adapter = requires ($cd ['adapter']);

      #exit ($cd['adapter']);
      #$app = requires ('@mysql');
      #echo gettype($app), ' --- ', gettype($adapter);
      #exit (0)
      #;

      if (!$adapter = $this->validAdapter ($adapter)) {
        Error::NoAdapter ($cd ['adapter']);
      }

      $databaseConfigFile = ApplicationServerHelpers::DataBaseConfigFile ();

      $fs = requires ('fs');

      $dbFile = $fs->useFile ($databaseConfigFile);

      $arrayFile = requires ('strarray');
      $cdatas = $arrayFile->open ('./DriverMan/cache/cd');

      #$cacheFile = $fs->useFile (__DIR__ . '/DriverMan/cache/cd.json');

      #$cdatas->lastModify = $cacheFile->lastModifyDate;

      if ($cdatas->connection_datas &&
          $cdatas->last_modidy &&
          $cdatas->last_modidy == $dbFile->lastModify) {
        $cd = $cdatas->connection_datas;
      }

      #echo '<pre>';
      #print_r(self::$DriverManDatas);

      #exit (0);

      $adapter->setProp ($cd);

      $connection = $adapter->connect ();

      if (is_object ($connection) &&
          $connection instanceof PDO) {
        $cdatas->last_modidy = $dbFile->lastModify;
        $cdatas->connection_datas = $cd;
        # Create the bases of the databe
        # having the connection done
        $this->createPrimaryTables ($adapter);
        return $adapter;
      }

      $alts = self::$DriverManDatas [ '@alternates' ];

      if (isset ($props ['alternates']) &&
          $props ['alternates'] === true) {
        foreach ($alts as $key => $alternate) {
          $adapter = requires ($alternate ['adapter']);

          if (!$adapter = $this->validAdapter ($adapter)) {
            Error::NoAdapter ($alternate ['adapter']);
          }

          #echo '<pre>';
          #print_r($alternate);
          #echo '</pre><br /><br />';

          $connection = $adapter->connect ($alternate);

          if (is_object ($connection) &&
              $connection instanceof PDO){
            $cdatas->last_modidy = $dbFile->lastModify;
            $cdatas->connection_datas = $alternate;

            # Create the bases of the databe
            # having the connection done
            $this->createPrimaryTables ($adapter);
            return $adapter;
          }
        }
      }

      #echo '<pre>'; print_r($connection);

      #exit (gettype($connection));

      Error::NoConnection ( $connection );
    }


    protected function validAdapter ($adapter) {
      $validAdapter = function ($adapter) {
        $validAdapter = ( boolean ) (
          is_object ($adapter) &&
          $adapter instanceof Adapter
        );

        return $validAdapter ? $adapter : false;
      };

      if ($validAdapter ($adapter)) {
        return true;
      } elseif (is_callable ($adapter)) {
        $adapter = call_user_func ($adapter, $this->connectionDatas);
        return call_user_func ($validAdapter, $adapter);
      }

      return false;
    }
  }}
}
