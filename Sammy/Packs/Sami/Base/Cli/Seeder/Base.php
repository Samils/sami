<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Base\Cli\Seeder
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
namespace Sammy\Packs\Sami\Base\Cli\Seeder {
  use Sami\Base\Seeder;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Base\Cli\Seeder\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   * Sami\Base\Cli\Seeder module.
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
     * @method array All
     */
    private static function All () {
      $globalClassList = get_declared_classes ();

      $seederList = [];

      if (is_array ($globalClassList) &&
        count ($globalClassList)) {
        /**
         * Map whole the declared classes and
         * store each one exenting from the
         * base seeder class
         */
        foreach ($globalClassList as $className) {
          if (self::validSeeder ($className)) {
            array_push ($seederList, $className);
          }
        }
      }

      return $seederList;
    }

    /**
     * @method boolean validSeeder
     */
    private static function validSeeder ($seeder) {
      if (is_string ($seeder) && $seeder) {
        /**
         * @var array seederClassNameAlternates
         *
         */
        $seederClassNameAlternates = [
          preg_replace ('/(Seeder)?$/i', 'Seeder', $seeder),
          $seeder
        ];

        foreach ($seederClassNameAlternates as $seederClassName) {
          $seederClassNameRef = join ('\\', [
            'Sami\Base', $seederClassName
          ]);

          if (class_exists ($seederClassNameRef) &&
            in_array (Seeder::class, class_parents ($seederClassNameRef))) {
            return $seederClassNameRef;
          }
        }
      }
    }
  }}
}
