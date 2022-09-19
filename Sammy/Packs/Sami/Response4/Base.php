<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Response4
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
namespace Sammy\Packs\Sami\Response4 {
  use Sammy\Packs\Sami\Response4\Parsers\JSON;
  use Sammy\Packs\Sami\Response4\Parsers\HTML;
  use Sammy\Packs\Sami\Response4\Parsers\XML;
  use Sammy\Packs\HTTP\Response;
  use Sammy\Packs\HTTP\Request;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Response4\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   * Sami\Response4 module.
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
     * @method void sendResponse4Request
     *
     * Send a request for a given request based on
     * the accept header sent from the request.
     *
     * @param Sammy\Packs\HTTP\Request $req
     * @param mixed $responseData
     */
    public function sendResponse4Request (Request $req, $responseData = null) {
      $accepHeader = strtolower ((string)$req->getHeader ('accept'));

      $acceptedContentTypes = preg_split ('/\s*,\s*/', $accepHeader);

      $responseParsers = [
        HTML::class,
        JSON::class,
        XML::class
      ];

      foreach ($responseParsers as $responseParser) {
        $parser = new $responseParser;

        if (self::validResponseParser ($parser)) {
          foreach ($acceptedContentTypes as $contentType) {
            if ($parser->mayParseResponse ($contentType)) {
              return call_user_func_array (
                [$parser, 'handle'],
                [new Response, $responseData]
              );
            }
          }
        }
      }
    }

    protected static function validResponseParser ($parser) {
      return ( boolean )(
        is_object ($parser) &&
        in_array (IResponseParser::class, class_implements (get_class ($parser))) &&
        property_exists (get_class ($parser), 'mimeTypes') &&
        is_array ($parser->mimeTypes)
      );
    }
  }}
}
