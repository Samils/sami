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

  $module->exports = new Func (function ($args) {
    # Request
    # Sammy\Packs\HTTP\Request Object
    $req = new Request;
    # Response
    # Sammy\Packs\HTTP\Response object
    $res = new Response;
    $template = $args['Template'];
    $middlewareDatas = [];

    if (!isset ($args ['middlewareDatas'])) {
      $middlewareDatas = $args ['middlewareDatas'];
    }

    $controllerResolve = new ControllerResolve;
    $controllerActionHandler = new ControllerActionHandler;
    $uncontrolledActionHandler = new UncontrolledActionhandler;

    if (!preg_match ('/^(@+)/', $template)) {
      $uncontrolledActionHandler->handle ($template);
    }

    $responseDataObject = null;
    $template = preg_replace('/^(@+)/', '', $template );
    $strTemplateSlices = preg_split('/\/+/', $template);
    $controller = $strTemplateSlices [ 0 ];

    if (!isset ($strTemplateSlices [1])) {
      # set default action as 'index'
      # if there is not specified any
      # for being called from the
      # current request
      $action = 'index';
    } else {
      $action = $controllerActionHandler->actionName ($strTemplateSlices);
    }

    $controllerObject = $controllerResolve->resolve ($controller);
    $req->setProperty ( 'controller', $controllerObject );

    $responseDataObject = $controllerActionHandler->handle (
      $controllerObject, $action, $middlewareDatas
    );

    if (in_array ('V', ApplicationServerHelpers::conf ('flux'))) {

      $templateResolve = new TemplateResolve;
      #exit ($template);

      $viewTemplateDatas = $templateResolve->resolve ($template);
      $templateDatas = null;

      if ( is_array ($viewTemplateDatas) ) {
        $templateDatas = array (
          'template' => $viewTemplateDatas,
          'responseData' => $responseDataObject
        );
      }

      if ( !is_array ($templateDatas) ) {
        Error::TemplateMissing ($template);
      }

      return $templateDatas;
    }
  });
}
