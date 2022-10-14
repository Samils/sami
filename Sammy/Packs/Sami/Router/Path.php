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
  use Closure;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Router\Path')) {
  /**
   * @class Path
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
  class Path {
    /**
     * @var string
     *
     * route raw path
     */
    private $rawPath;
    /**
     * @var string
     *
     * route original raw path
     */
    private $originalRawPath;

    /**
     * @var string
     *
     * route name
     */
    private $name;

    /**
     * @var array
     *
     * router parameters list
     */
    private $parameters = [];

    /**
     * @var array
     *
     * router parameters keys list
     */
    private $parameterKeys = [];

    /**
     * @var string
     *
     * route name regular expression
     */
    private $routeNameRe = '/(#([a-zA-Z0-9_]+))$/i';

    /**
     * @var string
     *
     * route path pattern regular expression
     */
    private $routePatternRe = '/^([a-zA-Z0-9\/:_\-\.@\$])+$/';

    /**
     * @var string
     *
     * route parameter regular expression
     */
    private $paramRegEx = '/:{1,}([^\/\\\]+)/';

    /**
     * @var string
     */
    private static $slashesRe = '/\/(.*)\/([a-zA-Z]+)?/';

    /**
     * constructor
     */
    public function __construct (string $path, array $backTrace = []) {
      if (!self::validTrace ($backTrace)) {
        $backTrace = debug_backtrace ();
      }

      $slashRe = '/([\/\\\\]+)/';
      $parentScopePath = $this->getParentScopePath ($backTrace);

      $rawPath = $path;
      # $path = preg_replace ($slashRe, '', $path);

      if (!empty ($parentScopePath)) {
        $rawPath = join ('/', [$parentScopePath, $path]);
      }

      if (preg_match ($this->routeNameRe, $rawPath, $match)) {
        $routeName = preg_replace ('/^#/', '', $match [0]);

        $this->name = $routeName;

        $rawPath = preg_replace ($this->routeNameRe, '', $rawPath);
      }

      # \home//path\to/path => /home/path/to/path
      $this->rawPath = preg_replace ($slashRe, '/', $rawPath);
      $this->originalRawPath = $this->rawPath;

      if (preg_match_all ($this->paramRegEx, $this->rawPath, $matches) >= 1) {
        $this->rawPath = self::regExContent ($this->rawPath);

        $this->rawPath = preg_replace_callback ($this->paramRegEx, [$this, 'routeParamReplaceCallback'], $this->rawPath);

        $this->parameterKeys = $matches [1];
        $this->parameters = [];

        foreach ($this->parameterKeys as $parameterKey) {
          $this->parameters [$parameterKey] = null;
        }
      }
    }

    /**
     * @method string
     *
     * Raw path getter
     */
    public function getRawPath () {
      return $this->rawPath;
    }

    /**
     * @method string
     *
     * Original raw path getter
     */
    public function getOriginalRawPath () {
      return $this->originalRawPath;
    }

    /**
     * @method string
     *
     * Route name getter
     */
    public function getName () {
      return $this->name;
    }

    /**
     * @method string
     *
     * Route parameter name list getter
     */
    public function getParameterNames () {
      return $this->parameterKeys;
    }

    /**
     * @method string
     *
     * Route parameter value list getter
     */
    public function getParameterValues () {
      return array_values ($this->parameters);
    }

    /**
     * @method string
     *
     * Route parameter list getter
     */
    public function getParameters () {
      return $this->parameters;
    }

    /**
     * @method array|boolean
     *
     * Verify if a route path matches the route pattern
     * by matching it with this::$routePatternRe
     */
    public function matches (string $string) {
      $re = $this->asRegEx ();
      #exit ('<h1>Path => ' . $this->asRegEx () . '</h1><br /><br /><br />');

      if ($this->isRegEx ($re) &&  @preg_match ($re, $string, $match)) {

        $this->asignParametersWithMatchResult ($match);

        return $match;
      }

      return false;
    }

    /**
     * @method boolean
     *
     * verify if a $string.lower is equal than $this::rawPath.lower
     */
    public function exactMatch (string $string) {
      return (boolean)(strtolower ($string) === strtolower ($this->rawPath));
    }

    /**
     * @method boolean
     *
     * verify if the route path is a valid regular expression
     */
    public function isRegEx (string $rawPath = null) {
      $rawPath = self::stripStartSlash ($rawPath ? $rawPath : $this->rawPath);
      $rawPath = self::wrapWithSlashes ($rawPath);

      $context = new Context;

      $tmpErrorHandler = Closure::bind (function () {
        $this->error = true;
      }, $context, Context::class);

      set_error_handler ($tmpErrorHandler, E_ALL);

      @preg_match ($rawPath, 'string');

      restore_error_handler ();

      return !(boolean)($context->error);
    }

    /**
     * @method string
     *
     * return the route path as a valid regular expression
     */
    public function asRegEx () {
      $rawPath = $this->rawPath;

      if (!!(count ($this->parameters) < 1)) {
        $rawPath = self::regExContent ($rawPath);
      }

      return self::wrapWithSlashes ($rawPath);
    }

    /**
     * @method mixed
     *
     * convert the current object to string
     */
    public function __toString () {
      return $this->rawPath;
    }

    /**
     * @method void
     *
     * asing route parameters with the route matching result
     */
    private function asignParametersWithMatchResult (array $match) {
      $this->asignParameters (array_slice ($match, 2, count ($match)));
    }

    /**
     * @method void
     *
     * asing route parameters with a given array of parameter values
     */
    private function asignParameters (array $parameterValues) {
      foreach ($parameterValues as $index => $parameterValue) {
        if (isset ($this->parameterKeys [$index])) {
          $parameterKey = $this->parameterKeys [$index];

          $this->parameters [$parameterKey] = $parameterValue;
        }
      }
    }

    /**
     * @method array
     *
     * get parent scope route path
     */
    private function getParentScopePath (array $backTrace) {
      $data = '';

      foreach ($backTrace as $traceData) {
        if (is_array ($traceData)
          && isset ($traceData ['args'])
          && is_array ($traceData ['args'])
          && isset ($traceData ['args'][0])
          && is_array ($traceData ['args'][0])
          && isset ($traceData ['args'][0]['parent'])
          && is_array ($traceData ['args'][0]['parent'])
          && isset ($traceData ['args'][0]['parent']['path'])
          && $traceData ['args'][0]['parent']['path'] instanceof Path) {
          return call_user_func ([$traceData ['args'][0]['parent']['path'], 'getOriginalRawPath']);
        }
      }

      return '';
    }

    /**
     * @method string
     */
    private function routeParamReplaceCallback () {
      return '([^\\/]+)';
    }

    private static function validTrace ($trace) {
      return ( boolean ) (
        is_array ($trace)
      );
    }

    private static function regExContent (string $string) {
      $specialCharsList = '/[\/\^\$\[\]\{\}\(\)\\\\.]/';

      $callback = function ($match) {
        return '\\' . $match [0];
      };

      return preg_replace_callback ($specialCharsList, $callback, $string);
    }

    private static function wrapWithSlashes (string $string) {
      if (!!preg_match (self::$slashesRe, $string)) {
        $string = preg_replace ('/^\//', '', $string);
        $string = preg_replace ('/\/([mui]+)?$/', '', $string);
      }

      return join ('', ['/^(', $string, ')$/i']);
    }

    private static function stripStartSlash (string $string) {
      if (preg_match (self::$slashesRe, $string)) {
        return $string;
      }

      return preg_replace ('/^\//', '', $string);
    }
  }}
}
