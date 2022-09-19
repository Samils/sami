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
  use Sammy\Packs\Sami\RouteFactory;
  use Sammy\Packs\Sami\Error;
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
    $path = '/';
    $t = debug_backtrace ();

    list  ($path, $ca) = RouteFactory::rewriteRoutePath ($t, $path, $ca);

    $app = Sami::ApplicationModule ();

    if (method_exists ($app, 'getRq')) {
      return call_user_func_array (
        [$app, 'getRq'], [$path, $ca, $t]
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
  function group ($path = null) {
    $t = debug_backtrace ();

    $body = array_last_i (func_get_args ());

    if (is_string ($path) && $body instanceof Closure) {
      list  ($path) = RouteFactory::rewriteRoutePath ($t, $path);

      return call_user_func_array ($body, [[ 'rb' => $path ]]);
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
  function resource ($path_ = null, $l = []) {
    $t = debug_backtrace ();
    /**
     * Rewrite the path string setting a slash
     * char at the start of the given path.
     *
     * If it starts with a slash, remove that before
     * adding a new one.
     */
    $path = '/' . (preg_replace ('/^\/+/', '', $path_));

    $rules = is_array ($l) ? $l : [];

    if (is_string ($path_) && is_right_var_name ($path_)) {
      list  ($path) = RouteFactory::rewriteRoutePath ($t, $path);

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
      /**
       * rules
       * Use the default rules is the given rules
       * are not contained inside an array
       * in order keeping the default values
       * for 'except' and 'only' properties
       * wich are empty arrays
       */
      $rules = is_array ($rules) ? $rules : $default_rules;
      $rules = array_merge ($default_rules, $rules);

      /**
       * Make sure the 'only' property is an
       * array, if it is not, considere an empty
       * array as the default value for it.
       */
      if (!is_array ($rules ['only'])) {
        /**
         * Considere an empty _array as
         * the default value for the 'only'
         * property on condition that it was not
         * sent or it is not a valid array.
         */
        $rules ['only'] = [];
      }

      /**
       * Make sure the 'except' property is an
       * array, if it is not, considere an empty
       * array as the default value for it.
       */
      if (!is_array ($rules ['except'])) {
        /**
         * Considere an empty _array as
         * the default value for the 'except'
         * property on condition that it was not
         * sent or it is not a valid array.
         */
        $rules ['except'] = [];
      }

      /**
       * Make sure the 'middleware' property is an
       * string, if it is not, considere an empty
       * string as the default value for it.
       */
      if (!is_string ($rules ['middleware'])) {
        /**
         * Considere an empty string as
         * the default value for the 'middleware'
         * property on condition that it was not
         * sent or it is not a valid string.
         */
        $rules ['middleware'] = '';
      }

      $app = Sami::ApplicationModule ();

      if (isset ($rules ['module']) &&
        Sami::IsControllerObject ($rules ['module'])) {
        $app = $rules ['module'];
      }

      if ($base = RouteFactory::resourceBaseRefGiven ($t)) {
        $basePath = preg_replace ('/^(\/+)/', '',
          preg_replace ('/(\/+)$/', '', $base)
        );

        $basePathName = RouteFactory::PathToName ($basePath, [
          'underscored' => true
        ]);

        $path = join ('', [
          '/' . $basePath . '/:'.$basePathName.'_id/',
          preg_replace ('/^\/+/', '', $path_)
        ]);
      }

      $routerResource = new Resource;
      $routerResource->setBase ($path);
      $routerResource->setModule ($app);

      $routerResourceBody = array_last_i (func_get_args ());

      $rules ['except'] = array_merge ($rules['except'], $routerResource->getExceptions ());

      $rules ['only'] = array_merge ($rules ['only'], $routerResource->getOnlyList ());

      if ($core = RouteFactory::resourceCoreRefGiven ($t)) {
        /**
         * addExceptions
         */
        if (!$rules ['middleware']) {
          $routerResource->setMiddleware (
            $core->getMiddleware ()
          );
        }
      }

      if ($routerResource->getMiddleware ()) {
        $rules ['middleware'] = $routerResource->getMiddleware ();
      } else {
        $routerResource->setMiddleware ($rules ['middleware']);
      }

      $restRoutes = RouteFactory::Rest ($path, $rules ['middleware']);

      if ($routerResourceBody instanceof Closure) {
        /**
         * Call
         */
        call_user_func_array ($routerResourceBody, [
          [
            'base' => $path,
            'routerResourceCore' => $routerResource
          ]
        ]);
      }

      #echo '<pre>';
      #print_r($restRoutes);
      #echo ('</pre><br /><br /><br />');

      if (count($routerResource->getOnlyList ()) >= 1) {
        # Run away the rules to be used
        # in he current resource
        foreach ($routerResource->getOnlyList () as $i => $action) {
          #if (!(is_string($action) && $action)) {
          # exit('Action incorrect');
          #}
          $action = trim (strtolower ($action));

          if (isset ($restRoutes [$action])) {
            # action
            $actionDatas  = $restRoutes [ $action ];

            if (method_exists ($app, $actionDatas [0])) {
              call_user_func_array (
                [$app, $actionDatas [0]],
                [$actionDatas [1], $actionDatas [2], $t]
              );
            }
          }
        }
      } else {
        /**
         * Map whole the rest routes and
         * skip the created exceptions.
         */
        foreach ($restRoutes as $action => $actionDatas) {
           if (!in_array ($action, $routerResource->getExceptions ())) {
            if (method_exists ($app, $actionDatas [0])) {
              /**
               * Create Route
               */
              call_user_func_array (
                [$app, $actionDatas [0]],
                [$actionDatas [1], $actionDatas [2], $t]
              );
            }
          }
        }
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
