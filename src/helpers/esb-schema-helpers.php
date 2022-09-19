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
  use Sammy\Packs\Sami\Base\Table;
  use Sammy\Packs\Sami\Base\Table\Column;
  /**
   * Samils\Functions
   * @version 1.0
   * @author Sammy
   *
   * @keywords Samils, ils, ils-global-functions
   * ------------------------------------
   * - Autoload, application dependencies
   *
   * Make sure the command base internal function is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   * ----
   * @Function Name: create_table
   * @Function Description: Create a new table inside a schema context
   * @Function Args: $name = '', $opts = null
   */
  if (!function_exists ('create_table')) {
  /**
   * @version 1.0
   *
   * THE CURRENT ILS FUNCTION IS PROVIDED
   * TO AID THE DEVELOPMENT PROCESS IN ORDER
   * IT GET IN THE SAME WAY WHEN MOVING IT FROM
   * ANOTHER TO ANOTHER ENVIRONMENT.
   *
   * Note: on condition that this is an automatically
   * generated file, it should not be directly changed
   * without saving whole the changes into the original
   * repository source.
   *
   * @author Agostinho Sam'l
   * @keywords schema, schema-table, create-table
   */
  function create_table ($name = '', $opts = null) {
    if (!!(is_string ($name) && !empty ($name))) {
      Migration::ConfigTrace (debug_backtrace ());

      $singular = requires ('singular');

      $name = strtolower ($singular->parse ($name));

      $body = func_get_arg (func_num_args () - 1);

      if (is_callable ($body)) {
        $tableObject = new Table ($name);

        call_user_func ($body, $tableObject);

        $opts = is_array ($opts) ? $opts : [];

        $tableProps = $tableObject->getProperties ();

        Table::Define ($name, $opts, $tableProps);
      }
    }
  }}

  /**
   * Samils\Functions
   * @version 1.0
   * @author Sammy
   *
   * @keywords Samils, ils, ils-global-functions
   * ------------------------------------
   * - Autoload, application dependencies
   *
   * Make sure the command base internal function is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   * ----
   * @Function Name: add_column
   * @Function Description: Add a new column into a given table
   * @Function Args: $table, $column, $type , $props = null
   */
  if (!function_exists ('add_column')) {
  /**
   * @version 1.0
   *
   * THE CURRENT ILS FUNCTION IS PROVIDED
   * TO AID THE DEVELOPMENT PROCESS IN ORDER
   * IT GET IN THE SAME WAY WHEN MOVING IT FROM
   * ANOTHER TO ANOTHER ENVIRONMENT.
   *
   * Note: on condition that this is an automatically
   * generated file, it should not be directly changed
   * without saving whole the changes into the original
   * repository source.
   *
   * @author Agostinho Sam'l
   * @keywords table, table-column, add-column
   */
  function add_column ($table, $column, $type , $props = null) {
    $singular = requires ('singular');

    $table = strtolower ($singular->parse ($table));

    Migration::ConfigTrace (debug_backtrace ());

    $props = is_array ($props) ? $props : [];

    if (!Table::Exists ($table)) {
      exit ('No Table ' . $table);
    }

    if (!!is_right_var_name ($column)) {
      $type = Table::rewriteType ($type);

      $props = array_merge ($props, ['@type' => $type]);

      return Table::Merge ($table, $column, $props);
    }

    exit ('bad name for a column - ' . $column);
  }}

  /**
   * Samils\Functions
   * @version 1.0
   * @author Sammy
   *
   * @keywords Samils, ils, ils-global-functions
   * ------------------------------------
   * - Autoload, application dependencies
   *
   * Make sure the command base internal function is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   * ----
   * @Function Name: change_column
   * @Function Description: Change a table.column properties definitions and give a new name to it
   * @Function Args: $table, $column, $newName, $type
   */
  if (!function_exists ('change_column')) {
  /**
   * @version 1.0
   *
   * THE CURRENT ILS FUNCTION IS PROVIDED
   * TO AID THE DEVELOPMENT PROCESS IN ORDER
   * IT GET IN THE SAME WAY WHEN MOVING IT FROM
   * ANOTHER TO ANOTHER ENVIRONMENT.
   *
   * Note: on condition that this is an automatically
   * generated file, it should not be directly changed
   * without saving whole the changes into the original
   * repository source.
   *
   * @author Agostinho sam'l
   * @keywords table-column, change-column
   */
  function change_column ($table, $column, $newName, $type) {
    $singular = requires ('singular');

    $table = strtolower ($singular->parse ($table));

    Migration::ConfigTrace (debug_backtrace ());

    if (!Table::Exists ($table)) {
      exit ('No Table ' . $table);
    }

    $props = func_get_arg (func_num_args () - 1);

    $type = Table::rewriteType ($type);

    if (is_callable ($props)) {
      $col = new Column ([], $type);

      call_user_func ($props, $col);

      $props = $col->getProps ();
    } elseif (!is_array ($props)) {
      $props = array ();
    }

    $sizePropSet = ( boolean )(
      isset ($props ['size']) &&
      !is_nan ($props ['size'])
    );

    $type .= !$sizePropSet ? '(40)' : '('.$props ['size'].')';
    $props = array_merge ($props, ['@type' => $type]);

    Table::ChangeColumn ($column, $newName, $table, $props);
  }}

  /**
   * Samils\Functions
   * @version 1.0
   * @author Sammy
   *
   * @keywords Samils, ils, ils-global-functions
   * ------------------------------------
   * - Autoload, application dependencies
   *
   * Make sure the command base internal function is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   * ----
   * @Function Name: modify_column
   * @Function Description: Change a table.column properties definitions
   * @Function Args: $table, $column, $type
   */
  if (!function_exists ('modify_column')) {
  /**
   * @version 1.0
   *
   * THE CURRENT ILS FUNCTION IS PROVIDED
   * TO AID THE DEVELOPMENT PROCESS IN ORDER
   * IT GET IN THE SAME WAY WHEN MOVING IT FROM
   * ANOTHER TO ANOTHER ENVIRONMENT.
   *
   * Note: on condition that this is an automatically
   * generated file, it should not be directly changed
   * without saving whole the changes into the original
   * repository source.
   *
   * @author Agostinho sam'l
   * @keywords table-column, modify-column
   */
  function modify_column ($table, $column, $type) {
    $singular = requires ('singular');

    $table = strtolower ($singular->parse ($table));

    Migration::ConfigTrace (debug_backtrace ());

    if (!Table::Exists ($table)) {
      exit ('No Table ' . $table);
    }

    $props = func_get_arg (func_num_args () - 1);

    $type = Table::rewriteType ($type);

    if (is_callable ($props)) {
      $col = new Column ([], $type);

      call_user_func ($props, $col);

      $props = $col->getProps ();
    } elseif (!is_array ($props)) {
      $props = array ();
    }

    $sizePropSet = ( boolean )(
      isset ($props ['size']) &&
      !is_nan ($props ['size'])
    );

    $type .= !$sizePropSet ? '(40)' : '('.$props ['size'].')';
    $props = array_merge ($props, ['@type' => $type]);

    Table::ChangeColumn ($column, $column, $table, $props);
  }}

  /**
   * Samils\Functions
   * @version 1.0
   * @author Sammy
   *
   * @keywords Samils, ils, ils-global-functions
   * ------------------------------------
   * - Autoload, application dependencies
   *
   * Make sure the command base internal function is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   * ----
   * @Function Name: drop_column
   * @Function Description: Drop a column from a given table
   * @Function Args: $table, $column
   */
  if (!function_exists ('drop_column')) {
  /**
   * @version 1.0
   *
   * THE CURRENT ILS FUNCTION IS PROVIDED
   * TO AID THE DEVELOPMENT PROCESS IN ORDER
   * IT GET IN THE SAME WAY WHEN MOVING IT FROM
   * ANOTHER TO ANOTHER ENVIRONMENT.
   *
   * Note: on condition that this is an automatically
   * generated file, it should not be directly changed
   * without saving whole the changes into the original
   * repository source.
   *
   * @author Agostinho Sam'l
   * @keywords table-column, drop-column
   */
  function drop_column ($table, $column) {
    $singular = requires ('singular');

    $table = strtolower ($singular->parse ($table));

    Migration::ConfigTrace (debug_backtrace ());

    if (!Table::Exists ($table)) {
      exit ('No Table ' . $table);
    }

    Table::DropColumn ($table, $column);
  }}

  /**
   * Samils\Functions
   * @version 1.0
   * @author Sammy
   *
   * @keywords Samils, ils, ils-global-functions
   * ------------------------------------
   * - Autoload, application dependencies
   *
   * Make sure the command base internal function is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   * ----
   * @Function Name: rename_column
   * @Function Description: Raname a new column from a given table
   * @Function Args: $table, $column, $newName
   */
  if (!function_exists ('rename_column')) {
  /**
   * @version 1.0
   *
   * THE CURRENT ILS FUNCTION IS PROVIDED
   * TO AID THE DEVELOPMENT PROCESS IN ORDER
   * IT GET IN THE SAME WAY WHEN MOVING IT FROM
   * ANOTHER TO ANOTHER ENVIRONMENT.
   *
   * Note: on condition that this is an automatically
   * generated file, it should not be directly changed
   * without saving whole the changes into the original
   * repository source.
   *
   * @author Agostinho Sam'l
   * @keywords table-column, rename-column
   */
  function rename_column ($table, $column, $newName) {
    $singular = requires ('singular');

    $table = strtolower ($singular->parse ($table));

    Migration::ConfigTrace (debug_backtrace ());

    if (!Table::Exists ($table)) {
      exit ('No Table ' . $table);
    }

    if (!!is_right_var_name ($newName)) {
      return Table::RenameColumn ($table, $column, $newName);
    }

    exit ('Bad name for a column name!! - ' . $column);
  }}

}
