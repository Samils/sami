<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Cli\StaticGenerator
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
namespace Sammy\Packs\Sami\Cli\StaticGenerator {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope before creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Cli\StaticGenerator\FileConfigurator')) {
  /**
   * @trait FileConfigurator
   * Base internal trait for the
   * Sami\Cli\StaticGenerator module.
   * -
   * This is (in the ils environment)
   * an instance of the php module,
   * which should contain the module
   * core functionalities that should
   * be extended.
   * -
   * For extending the module, just create
   * an 'exts' directory in the module directory
   * and boot it by using the ils directory boot.
   * -
   *
   * Todos:
   *
   *  applyFileConfigList
   *  applyFileConfig
   *
   *  configFile{config}
   *   e.g: configFileDefaultPrefix, configFilePrefix
   */
  trait FileConfigurator {
    /**
     * @method string
     */
    public static function applyFileConfigList (string $filePath, array $configList = []) {
      /**
       * map each configuraion set in the $configList array
       * and apply it by handling it's configurator method;
       * skip if the configurator does not exist.
       *
       * at the end of the flux, return the result having whole
       * the configurations applied.
       */
      foreach ($configList as $config => $configValue) {
        $config = snake2camelcase (preg_replace ('/\-+/', '_', $config));

        $configuratorMethodName = join ('', ['configFile', $config]);

        if (method_exists (static::class, $configuratorMethodName)) {
          $filePath = forward_static_call_array ([static::class, $configuratorMethodName], [$filePath, $configValue]);
        }
      }

      return $filePath;
    }

    /**
     * @method string
     *
     * set the default path sufix to the given static path
     */
    protected static function configFileDefaultSufix (string $filePath, $defaultSufix) {
      $defaultSufixRe = self::wrapInRegEx ($defaultSufix);

      if (!(is_string ($defaultSufix) && $defaultSufix) || preg_match ($defaultSufixRe, $filePath)) {
        return $filePath;
      }

      return join ('', [$filePath, $defaultSufix]);
    }

    /**
     * @method string
     *
     * set the default path sufix to the given static path
     */
    protected static function configFileSufix (string $filePath, $sufix) {

      if (!(is_string ($sufix) && $sufix)) {
        return $filePath;
      }

      return join ('', [$filePath, $sufix]);
    }

    /**
     * @method string
     *
     * set the default path prefix to the given static path
     */
    protected static function configFileDefaultPrefix (string $filePath, $defaultPrefix) {
      $defaultPrefixRe = self::wrapInEndRegEx ($defaultPrefix);

      if (!(is_string ($defaultPrefix) && $defaultPrefix) || preg_match ($defaultPrefixRe, $filePath)) {
        return $filePath;
      }

      return join ('', [$defaultPrefix, $filePath]);
    }

    /**
     * @method string
     *
     * set the default path prefix to the given static path
     */
    protected static function configFilePrefix (string $filePath, $prefix) {

      if (!(is_string ($prefix) && $prefix)) {
        return $filePath;
      }

      return join ('', [$prefix, $filePath]);
    }

    /**
     * @method sring
     *
     * wrap a given path string in regular expression after converting it
     * to one
     */
    private static function wrapInRegEx (string $path) {
      $path = path_to_regex ($path);

      return join ('', ['/(', $path, ')$/i']);
    }

    /**
     * @method sring
     *
     * wrap a given path string in regular expression after converting it
     * to one
     */
    private static function wrapInEndRegEx (string $path) {
      $path = path_to_regex ($path);

      return join ('', ['/^(', $path, ')/i']);
    }
  }}
}
