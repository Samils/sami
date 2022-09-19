<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Module\Scope
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
namespace Sammy\Packs\Sami\Module\Scope {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Module\Scope\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   * Sami\Module\Scope module.
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
     * [$ApplicationModuleBase description]
     * @var array
     */
    protected static $ApplicationModuleBase = [];

    /**
     * [NoModuleError description]
     * @param  array  $trace [description]
     * @param  string  $moduleName [<description>]
     * @return void
     */
    protected static function NoModuleError ($trace = array (), $moduleName) {
      if (!(is_array($trace) && $trace))
        return;

      $error = new \Samils\Handler\Error;

      $file = !isset($trace['file']) ? '' : (
        $trace['file']
      );

      $line = !isset($trace['line']) ? '' : (
        $trace['line']
      );
      $error->title = 'ApplicationModule\Base::Error - No module';
      $error->message = (
        'No module \''.$moduleName.'\' was found ' .
        'and it can not be registered inside the ' .
        'module base scope.'
      );

      \Samils\Handler\Error (['err' => $error,
        'paragraphes' => array (
          "File => {$file}",
          "Line => {$line}"
        ),

        'lines_high' => array ($line),

        'sources' => array (
          'Extraed Source' => \Saml::FileExtractSource ($file,
            array ($line, 6)
          )
        )
      ]);
    }
  }}
}
