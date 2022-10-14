<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\Sami\Rae {
  use Sammy\Packs\Func;
  use Sammy\Packs\Sami\Error;
  use Sammy\Packs\HTTP\Request;
  use Sammy\Packs\HTTP\Response;
  use Sammy\Packs\Samils\ApplicationServerHelpers;

  use Sammy\Packs\Samils\ViewEngineSetup\setup_view_engine;

  $module->exports = new Func (function ($args) {
    # Request
    # Sammy\Packs\HTTP\Request Object
    $request = new Request;
    # Response
    # Sammy\Packs\HTTP\Response object
    $response = new Response;
    $routeSource = $args ['source'];
    $middlewareDatas = [];

    if (!isset ($args ['middlewareDatas'])) {
      $middlewareDatas = $args ['middlewareDatas'];
    }

    $controllerResolve = new ControllerResolve;
    $controllerActionHandler = new ControllerActionHandler;
    $uncontrolledActionHandler = new UncontrolledActionHandler;

    #if (!preg_match ('/^(@+)/', $routeSource)) {
    #  $uncontrolledActionHandler->handle ($routeSource);
    #}

    $responseponseDataObject = null;
    #$routeSource = preg_replace('/^(@+)/', '', $routeSource);
    #$strTemplateSlices = preg_split ('/\/+/', $routeSource);
    $controller = $routeSource->controller;

    $action = $routeSource->action ? $routeSource->action : 'index';

    $controllerObject = $controllerResolve->resolve ($controller);
    $request->setProperty ('controller', $controllerObject);

    $responseponseDataObject = $controllerActionHandler->handle (
      $controllerObject, $action, $middlewareDatas
    );

    if (function_exists (setup_view_engine::class)) {
      call_user_func_array (setup_view_engine::class, [$controllerObject]);
    }

    if (in_array ('V', ApplicationServerHelpers::conf ('flux'))) {

      $templateResolve = new TemplateResolve;

      $templatePath = join ('/', [$routeSource->controller, $routeSource->action]);

      $templatePath = preg_replace ('/[\/\\\\]+/', '/', $templatePath);

      $viewTemplateDatas = $templateResolve->resolve ($templatePath);
      $templateDatas = null;

      if (is_array ($viewTemplateDatas)) {
        $templateDatas = array (
          'template' => $viewTemplateDatas,
          'responseData' => $responseponseDataObject
        );
      }

      if ( !is_array ($templateDatas) ) {
        Error::TemplateMissing ($templatePath);
      }

      return $templateDatas;
    }
  });
}
