<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Rae
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
namespace Sammy\Packs\Sami\Rae {
  use Sammy\Packs\Sami\Error;
  use Sammy\Packs\HTTP\Request;
  use Sammy\Packs\HTTP\Response;
  use Sammy\Packs\Sami\MiddleHandler;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists('Sammy\Packs\Sami\Rae\ControllerActionHandler')){
  /**
   * @class ControllerActionHandler
   * Base internal class for the
   * ControllerActionHandler module.
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
  class ControllerActionHandler {
    /**
     * @method void handle
     */
    public function handle ($controllerObject, $action, $middlewareDatas) {
      $controller = $controllerObject->name;

      if (method_exists ($controllerObject, $action)) {
        $middle = new MiddleHandler;

        $req = new Request;
        $res = new Response;

        $middle->handle (
          [ $controller, [['before_any'], [$action, 'before_']] ],
          [ $req, $res ]
        );

        # Call the controller action
        $responseDataObject = call_user_func_array (
          [ $controllerObject, $action ], array_merge (
            [$req, $res], $middlewareDatas
          )
        );

        $middle->handle (
          [ $controller, [['after_any'], [$action, 'after_']] ],
          [ $req, $res ]
        );

        $response4 = requires ('sami/response4');
        $response4->sendResponse4Request ($req, $responseDataObject);

      } else {
        Error::NoAction ($controller, $action);
      }

      return $responseDataObject;
    }

    public function actionName ($reference = null) {
      if (!!is_string ($reference)) {
        $reference = preg_split ('/\/+/', $reference);
      }

      $referenceLen = count ($reference);

      for ($i = ($referenceLen - 1); $i >= 1; $i--) {
        $actionName = trim ((string)($reference [ $i ]));

        if (!preg_match ('/^:/', $actionName)) {
          return $actionName;
        }
      }

      return $reference [ -1 + $referenceLen ];
    }
  }}
}
