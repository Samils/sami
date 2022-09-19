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
  use Sammy\Packs\Sami\Base as SamiBase;
  use FileSystem\File;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Base\Cli\Migrator\Helper\Base')) {
  /**
   * @trait Base
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
  trait Base {

    /**
     * @method mixed evaluateData
     */
    protected static function evaluateData ($value, $data = null) {

      if (is_string ($data) && $data) {
        $setterName = join ('', ['get', ucfirst ($data), 'Value']);

        if (method_exists (self::class, $setterName)) {
          return forward_static_call_array (
            [self::class, $setterName], [$value]
          );
        }
      }

      if (is_bool ($value)) {
        return $value ? 'true' : 'false';
      } elseif (is_string ($value)) {
        return "'{$value}'";
      } elseif (is_array ($value)) {
        return array_stringify ($value);
      } else {
        return (string) ($value);
      }
    }

    public static function readReference ($reference) {
      if (is_string ($reference) && $reference) {
        $references = preg_split ('/\./', $reference);

        if (count ($references) >= 2) {
          return array_reverse (array_slice ($references, 0, 2));
        }
      } elseif (is_array ($reference) &&
        isset ($reference [0]) &&
        is_string ($reference [0]) &&
        isset ($reference ['inTable']) &&
        is_string ($reference ['inTable'])) {
        return [$reference [0], $reference ['inTable']];
      }
    }

    private static function getReferenceValue ($reference) {
      $references = self::readReference ($reference);

      list ($primaryKey, $referenceTable) = $references;

      return array_stringify ([$primaryKey, 'inTable' => $referenceTable]);
    }

    /**
     * @method string StringifyModelStructure
     */
    protected static function stringifyModelStructure ($arr) {
      if (!(is_array($arr) && $arr))
        return '';

      $code_body = "function (\$t) {\n";

      foreach ($arr as $col => $datas) {
        if (!(is_array ($datas) && $datas))
          continue;

        if (isset ($datas ['@type'])) {
          $type_match_done = preg_match(
            '/^([^\(]+)/', $datas ['@type'], $type_match
          );

          $type = $type_match [0];
        } else {
          $type = 'string';
        }

        $datas_count = count ($datas);

        if ($datas_count >= 2) {
          $varName = self::formatVarName ($col);
          $code_body .= "\t\t\t\${$varName} = \$t->{$type} ('{$col}');\n";

          foreach ($datas as $data => $value) {
            if (!($data !== '@type'))
              continue;

            $val = self::evaluateData ($value, $data);

            $code_body .= "\t\t\t\${$varName}->{$data} = {$val};\n";
          }

        } else {
          $code_body .= (
            ("\t\t\t\$t->{$type} ('{$col}');\n")
          );
        }
      }

      return preg_replace ('/(\n+)$/', '', $code_body) . "\n\t\t}";
    }

    /**
     * [update_schema_version description]
     * @return [type] [description]
     */
    private static function updateSchemaVersion ($schemaVersion) {
      $schemaVersionFile = SamiBase::SchemaVersionFile ();

      $file = new File ($schemaVersionFile);

      $file->writeLines ([$schemaVersion]);
    }

    public static function SchemaVersion () {
      $schemaVersionFile = SamiBase::SchemaVersionFile ();

      $file = new File ($schemaVersionFile);

      return trim ($file->read ());
    }

    private static function formatVarName ($varName) {
      return self::any2CamelCase ($varName);
    }

    private static function any2CamelCase ($string = '') {
      /**
       * [$str description]
       * @var string
       */
      $string = (string)($string);

      $string = preg_replace_callback (
        '/(_|\-)+([a-zA-Z])/',
        function ($match) {
          return strtoupper ($match [2]);
        },
        $string
      );

      return lcfirst ($string);
    }
  }}
}
