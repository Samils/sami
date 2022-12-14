<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Runner
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
namespace Sammy\Packs\Sami\Runner {
  use Param;
  use Closure;
  use Sammy\Packs\Sami\Error;
  use Sammy\Packs\HTTP\Request;
  use Sammy\Packs\HTTP\Response;
  use Sammy\Packs\Sami\RouteDatas;
  use Sammy\Packs\Sami\Router\ParamList;
  use Sammy\Packs\Sami\ParamContextBootstrapper;
  use Sammy\Packs\Samils\ApplicationServerHelpers;
  use Sammy\Packs\Samils\Controller\Base as Controller;

  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Runner\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   * Sami\Runner module.
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
     * @var Controller $app
     */
    private static $app;

    /**
     * @method void runApp
     */
    public function runApp (Controller $app = null) {
      $middlewareDatas = array ();
      $requestDatas = requires ('@HOME/@rd');

      $this->setApp ($app);

      # Route Template
      list ($routeTemplateDatas, $route) = RouteDatas::GetRouteTemplateDatas ($requestDatas);

      if ( !$routeTemplateDatas ) {
        Error::NoRoute ($requestDatas ['method'], $requestDatas ['route']);
      }

      $routeTrace = [];

      if (isset ($routeTemplateDatas ['trace'])) {
        $routeTrace = $routeTemplateDatas ['trace'];
      }

      $request = new Request;
      $response = new Response;

      $routeSource = $routeTemplateDatas ['template'];

      $middlewarePath = join (':', array_values ($routeSource->middleware));
      $middlewarePath = preg_replace ('/:+$/', '', $middlewarePath);

      if (!empty ($middlewarePath)) {
        $middle = requires ('@HOME/middle');

        $middlewareDatas = $middle->resolve (
          $middlewarePath,
          [$request, $response],
          ['trace' => $routeTrace]
        );
      }

      if (!is_array ($middlewareDatas)) {
        $middlewareDatas = [$middlewareDatas];
      }

      $routePathObject = $routeTemplateDatas ['route'];

      $routePathParameters = $routePathObject->getParameters ();

      $request->params = new ParamList ($routePathParameters);;

      // # reference datas
      // $referenceDatas = [
      //   'template' => null,
      //   'params' => null,
      //   'matches' => null
      // ];

      // $routeTemplateDatas ['template'] = isset ($routeTemplateDatas ['template']) ? $routeTemplateDatas ['template'] : null;

      // $paramContext = new Param (null, $routePathObject->getParamNames ());
      // # Switch 'template' property
      // # from the '$rt' variable
      // # in order getting the given
      // # reference for the current route
      // if (is_array ($routeTemplateDatas ['template'])) {
      //   $referenceDatas ['template'] = $routeTemplateDatas ['template']['template'];

      //   if (isset ($routeTemplateDatas ['match']) && $routeTemplateDatas ['match']) {
      //     $referenceDatas ['matches'] = !isset ($routeTemplateDatas ['matches']) ? null : ($routeTemplateDatas ['matches']);
      //   }
      // } elseif (is_string ($routeTemplateDatas ['template']) || is_func ($routeTemplateDatas ['template'])) {
      //   $referenceDatas ['template'] = $routeTemplateDatas ['template'];
      // } elseif ($routeTemplateDatas ['template'] instanceof Param) {
      //   $paramContext = $routeTemplateDatas ['template'];
      //   $referenceDatas ['template'] = $paramContext->getTemplate ();
      //   $referenceDatas ['params'] = $paramContext;
      // }

      ParamContextBootstrapper::BootstrapParamContext ($routePathParameters);

      # Verify if the 'matches' index
      # is inside the '$referenceDatas' array
      # in order setting as a property for
      # the 'req' object sent to the action
      # being called from the request response
      // if (isset ($referenceDatas ['matches'])) {
      //   $request->setProperty ('matches', $referenceDatas ['matches']);
      // }
      //
      //
      # Route action execute
      # Execute the route action
      # and returns the template
      # (view) absolute path to be
      # rendered.
      $Rae = requires ('@HOME/@rae');

      $rae = $Rae ([
        'source' => $routeSource,
        'middlewareDatas' => $middlewareDatas
      ]);

      # View Engine Datas
      $viewEngineDatas = ApplicationServerHelpers::conf ('view-engine');

      # View Engine
      $viewEngine = $viewEngineDatas->viewEngine;

      $viewEngine::RenderDOM (
        $rae ['template'][0] ,
        array_merge (
          $rae ['template'],
          [
            'layout' => 'application',
            'action' => $routeSource->action,
            'responseData' => $rae ['responseData']
          ],
          $rae
        )
      );

      # Verify if the 'params' index
      # is inside the '$referenceDatas' array
      # in order setting as a property for
      # the 'req' object sent to the action
      # being called from the request response
      // if (isset ($referenceDatas ['params'])) {
      //   $request->setProperty ('params', $referenceDatas ['params']);
      // }

      // if (is_func ($referenceDatas ['template'])) {
      //   $func = $referenceDatas ['template'] instanceof \Func ? (
      //     $referenceDatas ['template']
      //   ) : func ($referenceDatas ['template']);
      //   $f = $func->getCallback ();

      //   $f1 = Closure::bind ($f, $app, get_class ($app));

      //   call_user_func_array ($f1, array_merge ([$request, $response], $middlewareDatas));
      // } else {

      // }
    }

    /**
     * @method void setApp
     */
    private function setApp (Controller $app) {
      self::$app = $app;
    }

    public function getApp () {
      return self::$app;
    }
  }}
}
