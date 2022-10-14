<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Router
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
namespace Sammy\Packs\Sami\Router {
  use Sammy\Packs\Sami\RouteFactory;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Router\Source')) {
  /**
   * @class Source
   * Base internal class for the
   * Sami\Router module.
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
  class Source {
    /**
     * @var ApplicationRoutes
     * - A set of list of the application
     * - routes
     */
    private $props = [
      'middleware' => [
        'name' => null,
        'action' => null
      ],
      'controller' => null,
      'action' => null
    ];

    /**
     * @var string
     *
     * Route raw source path url
     */
    private $sourceUrl;

    /**
     * @var array
     *
     * Route source path url datas
     * [
     *   middlewareName => string
     *   middlewareAction => string
     *   controllerName => string
     *   controllerAction => string
     * ]
     */
    private $sourceUrlDatas = [];

    /**
     * @var string
     *
     * A regular expression for router source url
     *
     * Array
     * (
     *  [0] => auth:jwt@pages/home
     *  [1] => auth:jwt
     *  [2] => auth  { middlewareName }
     *  [3] => :jwt
     *  [4] => jwt   { middlewareAction }
     *  [5] => pages { controllerName }
     *  [6] => /home
     *  [7] => home  { controllerAction }
     * )
     */
    private $sourceUrlRe = '/^(([a-zA-Z0-9_]+)?(:([a-zA-Z0-9_]+))?)?(@([a-zA-Z0-9_\\\\]+))?(\/([a-zA-Z0-9_]+))?$/i';

    /**
     * constructor
     */
    public function __construct ($sourceUrl, array $backTrace = []) {
      if (is_string ($sourceUrl)) {
        $this->sourceUrl = $sourceUrl;
      }

      $this->parseSourceURL ();

      $parentScopeSourceUrlDatas = $this->getParentScopeSourceUrlDatas ($backTrace);

      if ($parentScopeSourceUrlDatas) {
        /**
         * Map the parent scope source url datas
         * and merge it in the current source url datas
         */
        foreach ($this->getSourceUrlDatas () as $key => $value) {
          if (!$value || empty ($value)) {
            $this->sourceUrlDatas [$key] = $parentScopeSourceUrlDatas [$key];
          }
        }
      }

      $this->asignSourceUrlDatas ($this->sourceUrlDatas);
    }

    /**
     * @method void
     *
     * parse the source url stored in ::$sourceUrl property
     */
    public function parseSourceURL () {
      if (is_string ($this->sourceUrl)
        && preg_match ($this->sourceUrlRe, $this->sourceUrl, $match)) {
        $sourceUrlDatas = $this->asignFromSourceUrl ($match);

        $this->sourceUrlDatas = $sourceUrlDatas;
      }
    }

    /**
     * @method array
     *
     * route source path url data getter
     */
    public function getSourceUrlDatas () {
      if (is_array ($this->sourceUrlDatas)) {
        return $this->sourceUrlDatas;
      }

      return $this->sourceUrlDatas = [];
    }

    /**
     * @method string
     *
     * get route source middleware path
     * pattern => {middleware}:{action}
     *
     * eg: auth:base
     */
    public function getMiddlewarePath () {
      $middlewarePath = join (':', array_values ($this->middleware));
      $middlewarePath = preg_replace ('/:+$/', '', $middlewarePath);

      return $middlewarePath;
    }

    /**
     * @method array
     *
     * Asign an array from the source url
     */
    public function asignFromSourceUrl (array $sourceUrlDatas) {
      $data = [];

      $sourceUrlDataRewriteMap = [
        '2' => 'middlewareName',
        '4' => 'middlewareAction',
        '6' => 'controllerName',
        '8' => 'controllerAction',
      ];

      foreach ($sourceUrlDataRewriteMap as $dataIndex => $dataKeyName) {
        $dataIndex = (int)($dataIndex);

        $dataValue = null;

        if (isset ($sourceUrlDatas [$dataIndex])) {
          $dataValue = $sourceUrlDatas [$dataIndex];
        }

        $data [$dataKeyName] = $dataValue;
      }

      return $data;
    }

    public function __toString () {
      return json_encode ($this->props);
    }

    /**
     * @method mixed
     *
     * getter
     */
    public function __get (string $property) {
      if (!isset ($this->props)) {
        if (isset ($this->sourceUrlDatas [$property])) {
          return $this->sourceUrlDatas [$property];
        } else {
          return null;
        }
      } elseif (isset ($this->props [$property])) {
        return $this->props [$property];
      }
    }

    /**
     * @method array
     *
     * get parent scope source url datas
     */
    private function getParentScopeSourceUrlDatas (array $backTrace) {
      $data = [];

      foreach ($backTrace as $traceData) {
        if (is_array ($traceData)
          && isset ($traceData ['args'])
          && is_array ($traceData ['args'])
          && isset ($traceData ['args'][0])
          && is_array ($traceData ['args'][0])
          && isset ($traceData ['args'][0]['parent'])
          && is_array ($traceData ['args'][0]['parent'])
          && isset ($traceData ['args'][0]['parent']['source'])
          && $traceData ['args'][0]['parent']['source'] instanceof Source) {
          return call_user_func ([$traceData ['args'][0]['parent']['source'], 'getSourceUrlDatas']);
        }
      }

      return $data;
    }

    /**
     * @method void
     *
     * asign asignSourceUrlDatas
     */
    private function asignSourceUrlDatas (array $sourceUrlDatas) {

      $defaultSourceUrlDatas = [
        'middlewareName' => '',
        'middlewareAction' => '',
        'controllerName' => '',
        'controllerAction' => ''
      ];

      $sourceUrlDatas = array_merge ($defaultSourceUrlDatas, $sourceUrlDatas);

      $this->props = [
        'middleware' => [
          'name' => $sourceUrlDatas ['middlewareName'],
          'action' => $sourceUrlDatas ['middlewareAction']
        ],
        'controller' => RouteFactory::PathToName ($sourceUrlDatas ['controllerName']),
        'action' => $sourceUrlDatas ['controllerAction']
      ];
    }

    /**
     * @method
     */
    private static function validBackTrace (array $backTrace) {
      if (is_array ($backTrace) && isset ($backTrace ['file'])) {
        return $backTrace;
      }

      $backTrace = debug_backtrace ();

      return array_slice ($backTrace, 1, count ($backTrace));
    }
  }}
}
