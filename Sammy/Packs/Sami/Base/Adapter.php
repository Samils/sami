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
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Base\Adapter')) {
  /**
   * @class Adapter
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
  abstract class Adapter {
    /**
     * @var PDO $conn
     *
     * Database connection object.
     */
    protected $conn;

    /**
     * @method PDO connect
     *
     * Create the connection object.
     *
     * @param array $connectionDatas
     *
     * A map of the connection datas.
     *
     * @return object
     */
    public abstract function connect (array $connectionDatas = []);

    /**
     * @method PDO model
     *
     * Create a model reference table in the database.
     *
     * @param string $table
     *
     * The table name in the database.
     *
     * @param boolean $forceSync
     *
     * A value indicating if the table creation will override
     * an existing one or not.
     * If the value is set to True, it will override the existing
     * table and recreate it using the given configurations and
     * table structure.
     *
     * @param array  $cols
     *
     * A map of whole the table columns containing it types,
     * configurations and specifications for each one.
     *
     * @return PDO
     */
    public abstract function model (string $table = '', bool $forceSync = false, array $cols = []);
  }}
}
