<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Application\Routes\Drawing
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
namespace Application\Routes\Drawing {
  use Sammy\Packs\Sami\Router\Resource;
  use Sammy\Packs\Sami\Router\Source;
  use Sammy\Packs\Sami\RouteFactory;
  use Sammy\Packs\Sami\Router\Path;
  use Sammy\Packs\Sami\Error;
  use Sammy\Packs\Singular;
  use Closure;
  use Sami;

  /**
   *
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
   * @Function Name: base
   * @Function Description: Define a path prefix for the current routes group
   * @Function Args: $path = ''
   */
  if (!function_exists ('Application\Routes\Drawing\base')) {
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
   * @keywords router, base, path-prefix
   */
  function base ($path = '') {
    $t = debug_backtrace();

    if (is_string ($path) && $path) {
      require (dirname(__FILE__) . '/rv/_fnc.php');

      $app = Sami::ApplicationModule ();

      $path = preg_replace ('/^(\/*)/', '/', $path);
      $path = preg_replace ('/(\/+)$/', '', $path);

      if (method_exists ($app, 'router_base')) {
        return call_user_func_array ([$app, 'router_base'], [$path]);
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
   * @Function Name: root
   * @Function Description: Create the root route (index)
   * @Function Args: $ca = null
   */
  if (!function_exists ('Application\Routes\Drawing\root')) {
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
   * @keywords router, root-route
   */
  function root ($ca = null) {
    $backTrace = debug_backtrace ();

    $rewritenBackTrace = array_merge (
      [
        array_merge (
          $backTrace [0],
          [
            'args' => array_merge (['/'], func_get_args ())
          ]
        )
      ],
      array_slice ($backTrace, 1, count ($backTrace))
    );

    return RouteFactory::Factory ('getRq', $rewritenBackTrace);
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
   * @Function Name: get
   * @Function Description: Create a @get route
   * @Function Args: $path = null
   */
  if (!function_exists ('Application\Routes\Drawing\get')) {
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
   * @keywords router, get
   */
  function get () {
    return RouteFactory::Factory ('getRq', debug_backtrace ());
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
   * @Function Name: post
   * @Function Description: Create a @post route
   * @Function Args: $path = null
   */
  if (!function_exists ('Application\Routes\Drawing\post')) {
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
   * @keywords router, post
   */
  function post () {
    return RouteFactory::Factory ('postRq', debug_backtrace ());
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
   * @Function Name: delete
   * @Function Description: Create a @delete route
   * @Function Args: $path = null
   */
  if (!function_exists ('Application\Routes\Drawing\delete')) {
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
   * @author  AuthorName
   * @keywords Function Keywords
   */
  function delete () {
    return RouteFactory::Factory ('deleteRq', debug_backtrace ());
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
   * @Function Name: group
   * @Function Description: Create a route group with a path prefix
   * @Function Args: $path = null
   */
  if (!function_exists ('Application\Routes\Drawing\group')) {
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
   * @keywords router, group
   */
  function group (string $path = null) {
    $t = debug_backtrace ();

    $args = func_get_args ();

    $sourceUrl = isset ($args [1]) && is_string ($args [1]) ? $args [1] : null;
    $body = $args [-1 + count ($args)];

    if (is_string ($path) && $body instanceof Closure) {
      #list  ($path) = RouteFactory::rewriteRoutePath ($t, $path);

      $sourceUrl = new Source ($sourceUrl, $t);
      $path = new Path ($path, $t);

      return call_user_func_array ($body, [[ 'parent' => [ 'source' => $sourceUrl, 'path' => $path ] ]]);
    }

    return Error::BadRoutePath ($t);
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
   * @Function Name: matches
   * @Function Description: Create a @get route with a regular expression as the route path
   * @Function Args: $path = null
   */
  if (!function_exists ('Application\Routes\Drawing\matches')) {
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
   * @keywords router, match
   */
  function matches () {
    return RouteFactory::Factory ('matchRq', debug_backtrace ());
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
   * @Function Name: patch
   * @Function Description: Create a @path route
   * @Function Args: $path = null
   */
  if (!function_exists ('Application\Routes\Drawing\patch')) {
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
   * @keywords router, patch
   */
  function patch () {
    return RouteFactory::Factory ('patchRq', debug_backtrace ());
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
   * @Function Name: put
   * @Function Description: Create a @put route
   * @Function Args: $path = null
   */
  if (!function_exists ('Application\Routes\Drawing\put')) {
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
   * @keywords router, put
   */
  function put ($path = null) {
    return RouteFactory::Factory ('putRq', debug_backtrace ());
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
   * @Function Name: resource
   * @Function Description: Create a resource (set of rest routes)
   * @Function Args: $path_ = null, $l = []
   */
  if (!function_exists ('Application\Routes\Drawing\resource')) {
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
   * @keywords router, resource
   */
  function resource (string $originalPath, $sourceUrl = '') {
    $backTrace = debug_backtrace ();

    /**
     * Rewrite the path string setting a slash
     * char at the start of the given path.
     *
     * If it starts with a slash, remove that before
     * adding a new one.
     */
    $path = '/' . (preg_replace ('/^\/+/', '', $originalPath));

    /**
     * default rules
     * warrant that the 'except' and 'only' are
     * inside the rules array in order avoiding
     * errors when trying to get informations
     * about them from the rules array when using
     * the rules to create or not a specific route
     * from the 'rest_routes' array.
     */
    $default_rules = [
      'only' => [],
      'except' => [],
      'middleware' => ''
    ];

    if ($basePath = RouteFactory::resourceBasePathGiven ($backTrace)) {
      $re = '/([a-zA-Z0-9_]+)((\\\\\/)?\(\[\^\\\\\/\]\+\))?$/';

      $basePathSlices = preg_split ('/[\/\\\\]+/', $basePath->getOriginalRawPath ());

      #echo "Base Path => ", $basePath, "\n";

      #echo "parent => ", $basePath->getOriginalRawPath (), "\n";

      $singular = new Singular;

      // if (preg_match ($re, $basePath, $match)) {
      //   $basePathControllerName = $match [1];

      //   $basePathControllerName = $singular($basePathControllerName);

      //   $path = join ('', ['/:', $basePathControllerName, '_id', $path]);
      // }
      //
      $basePathControllerName = $basePathSlices [-1 + count ($basePathSlices)];

      $basePathControllerName = $singular($basePathControllerName);

      $path = join ('', ['/:', $basePathControllerName, '_id', $path]);

      $originalPath = $path;
    }

    // $rules = is_array ($l) ? $l : [];

    $args = func_get_args ();

    $body = $args [-1 + count ($args)];

    $routerResource = new Resource;
    $sourceUrl = new Source (is_string ($sourceUrl) ?  $sourceUrl : '' , $backTrace);
    $path = new Path ($path, $backTrace);

    #echo "raw => ", $path->getOriginalRawPath(), "\n", 'path => ', $path, "\n\n\n";

    $app = Sami::ApplicationModule ();

    $originalPath = join ('', ['/', $originalPath]);

    $middlewarePath = $sourceUrl->getMiddlewarePath ();

    $controllerReference = RouteFactory::PathToName ($path->getOriginalRawPath (), [
      'separator' => '\\',
      'capitalized' => true
    ]);

    # getMiddlewarePath
    $restRoutes = RouteFactory::Rest ($originalPath, $controllerReference, $middlewarePath);

    if ($body instanceof Closure) {
      #list  ($path) = RouteFactory::rewriteRoutePath ($t, $path);
      call_user_func_array ($body, [[ 'parent' => [ 'source' => $sourceUrl, 'path' => $path, 'resource' => $routerResource ] ]]);
    }

    $onlyList = $routerResource->getOnlyList ();
    $exceptionsList = $routerResource->getExceptions ();

    $routesActionList = $routerResource->getExceptions ();

    $filter = (function (string $routeAction, array $routesActionList) {
      return !in_array (strtolower ($routeAction), $routesActionList);
    });

    if (count ($onlyList) >= 1) {
      $routesActionList = $routerResource->getOnlyList ();
      $filter = (function (string $routeAction, array $routesActionList) {
        return in_array (strtolower ($routeAction), $routesActionList);
      });
    }

    foreach ($restRoutes as $routeAction => $routeData) {
      if (call_user_func_array ($filter, [$routeAction, $routesActionList])) {
        list ($verb, $routePath, $routeSourceUrl) = $routeData;

        $rewritenBackTrace = array_merge (
          [
            array_merge (
              $backTrace [0],
              [
                'args' => [$routePath, $routeSourceUrl]
              ]
            )
          ],
          array_slice ($backTrace, 1, count ($backTrace))
        );

        RouteFactory::Factory ($verb, $rewritenBackTrace);
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
   * @Function Name: only
   * @Function Description: Set a list of route actions to be create in a resource
   * @Function Args:
   */
  if (!function_exists ('only')) {
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
   * @author  AuthorName
   * @keywords Function Keywords
   */
  function only () {
    $onlyList = func_get_args ();

    $t = debug_backtrace ();

    if ($core = RouteFactory::resourceCoreRefGiven ($t)) {
      /**
       * addExceptions
       */
      $core->setOnlyList ($onlyList);
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
   * @Function Name: except
   * @Function Description: Set a list of route actions to skip creating a resource
   * @Function Args:
   */
  if (!function_exists ('except')) {
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
   * @author  AuthorName
   * @keywords Function Keywords
   */
  function except () {
    $exceptions = func_get_args ();

    $t = debug_backtrace ();

    if ($core = RouteFactory::resourceCoreRefGiven ($t)) {
      /**
       * addExceptions
       */
      $core->setExceptions ($exceptions);
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
   * @Function Name: middleware
   * @Function Description: Set a middleware for a resource
   * @Function Args: $middleware = null
   */
  if (!function_exists ('middleware')) {
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
   * @author  AuthorName
   * @keywords Function Keywords
   */
  function middleware ($middleware = null) {
    $middleware = func_get_args ();

    $t = debug_backtrace ();

    if ($core = RouteFactory::resourceCoreRefGiven ($t)) {
      /**
       * addExceptions
       */
      $core->setMiddleware ($middleware);
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
   * @Function Name: routerDidFail
   * @Function Description: Register a fallBack lambda for a possible router failure
   * @Function Args: $callBack = null
   */
  if (!function_exists ('Application\Routes\Drawing\routerDidFail')) {
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
   * @keywords router, router-failure
   */
  function routerDidFail ($callBack = null) {
    if (is_callable ($callBack)) {
      return ApplicationRouterBase::routerDidFail (
        ['callBack' => $callBack]
      );
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
   * @Function Name: routerDidFailGet
   * @Function Description: Register a fallBack lambda for a possible router failure along a get request
   * @Function Args: $callBack = null
   */
  if (!function_exists ('Application\Routes\Drawing\routerDidFailGet')) {
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
   * @keywords router, router-failure
   */
  function routerDidFailGet ($callBack = null) {
    if (is_callable ($callBack)) {
      return ApplicationRouterBase::routerDidFailGet (
        ['callBack' => $callBack]
      );
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
   * @Function Name: routerDidFailPost
   * @Function Description: Register a fallBack lambda for a possible router failure along a post request
   * @Function Args: $callBack = null
   */
  if (!function_exists ('Application\Routes\Drawing\routerDidFailPost')) {
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
   * @keywords router, router-failure
   */
  function routerDidFailPost ($callBack = null) {
    if (is_callable ($callBack)) {
      return ApplicationRouterBase::routerDidFailPost (
        ['callBack' => $callBack]
      );
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
   * @Function Name: routerDidFailPut
   * @Function Description: Register a fallBack lambda for a possible router failure along a put request
   * @Function Args: $callBack = null
   */
  if (!function_exists ('Application\Routes\Drawing\routerDidFailPut')) {
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
   * @keywords router, router-failure
   */
  function routerDidFailPut ($callBack = null) {
    if (is_callable ($callBack)) {
      return ApplicationRouterBase::routerDidFailPut (
        ['callBack' => $callBack]
      );
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
   * @Function Name: routerDidFailPatch
   * @Function Description: Register a fallBack lambda for a possible router failure along a patch request
   * @Function Args: $callBack = null
   */
  if (!function_exists ('Application\Routes\Drawing\routerDidFailPatch')) {
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
   * @keywords router, router-failure
   */
  function routerDidFailPatch ($callBack = null) {
    if (is_callable ($callBack)) {
      return ApplicationRouterBase::routerDidFailPatch (
        ['callBack' => $callBack]
      );
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
   * @Function Name: routerDidFailDelete
   * @Function Description: Register a fallBack lambda for a possible router failure along a delete request
   * @Function Args: $callBack = null
   */
  if (!function_exists ('Application\Routes\Drawing\routerDidFailDelete')) {
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
   * @keywords router, router-failure
   */
  function routerDidFailDelete ($callBack = null) {
    if (is_callable ($callBack)) {
      return ApplicationRouterBase::routerDidFailDelete (
        ['callBack' => $callBack]
      );
    }
  }}


}
