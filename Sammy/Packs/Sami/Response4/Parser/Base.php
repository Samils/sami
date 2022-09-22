<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Response4\Parser
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
namespace Sammy\Packs\Sami\Response4\Parser {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Response4\Parser\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   * Sami\Response4\Parser module.
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
     * @method boolean mayParseResponse
     * Verify if a given response data in a mimeType
     * should be parsed by the current parser object.
     */
    public function mayParseResponse ($responseMimeType) {
      if (!is_array ($this->mimeTypes)) return false;
      /**
       * map each supported mime type in the '$mimeTypes'
       * array in the object context in order knowing if
       * one of the regular expressions in that array matches
       * with the given response data mime type.
       *
       * Each '$supportedMimeType' should be a regular expression
       * in the '$mimeTypes' array in the object context, for trying
       * to match it with the '$responseMimeType' parameter.
       */
      foreach ($this->mimeTypes as $mimeType) {
        if (@preg_match ($mimeType, $responseMimeType)) {
          return true;
        }
      }
      /**
       * Endly, return a false value.
       * On condition that, none of the supported
       * mime types has matched the given
       * '$resposeMimeType'
       */
      return false;
    }
  }}
}
