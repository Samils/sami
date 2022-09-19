<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Debugger
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
namespace Sammy\Packs\Sami\Debugger {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Debugger\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   * Sami\Debugger module.
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
     * @method void Log
     */
    public static function log (string $message = '') {
      if (empty ($message)) {
        return;
      }

      $logFileName = join ('', [
        'log-',
        date ('HisYmd'),
        time (),
        preg_replace ('/[^a-zA-Z0-9_\-\.\$\%]/', '', base64_encode(random_bytes(21))), '.log'
      ]);

      $format = requires ('format');

      #$messageColors = [
      #  'black',
      #  'red',
      #  'green',
      #  'yellow',
      #  'blue',
      #  'purple',
      #  'teal',
      #  'white'
      #];

      #$messageColor = $messageColors [rand (0, -1 + count ($messageColors))];

      #$message = $format->format ("{|color:$messageColor}", $message);

      $logFilePath = join (DIRECTORY_SEPARATOR, [
        realpath (null), 'log', 'idebugger', $logFileName
      ]);

      if (!is_dir (dirname ($logFilePath))) {
        return;
      }

      $logFileHandle = fopen ($logFilePath, 'w');

      fwrite ($logFileHandle, $message);

      fclose ($logFileHandle);
    }
  }}
}
