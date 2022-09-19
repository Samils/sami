<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami
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
namespace Sammy\Packs\Sami {
  use Samils\Handler\Error as SamilsErrorHandler;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Sami\Error')) {
  /**
   * @class Error
   * Base internal class for the
   * Sami module.
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
  class Error {
    use Error\Base;
    /**
     * @method void NoRoute
     */
    public static function NoRoute ($requestMethod, $route) {
      $error = new SamilsErrorHandler;

      $error->status = 404;
      $error->key = 'error';
      $error->title = 'Sami::Error - No Route';
      $error->message = join ('', [
        'No route matches for <span class="red"> ',
        $route, '</span>', ' on ', $requestMethod
      ]);

      $error->handle ([ 'title' => 'Sami::Error' ]);
    }


    public static function TemplateMissing ($template) {
      $error = new SamilsErrorHandler;

      $error->title = 'Template Missing';
      $error->message = 'Error, Missing Template';

      $templateResolve = new Rae\TemplateResolve;

      $pathRe = '/('.path2re(DIRECTORY_SEPARATOR).'|\/)+/';
      $template = $templateResolve->pathName ($template);
      $templateStrSlices = preg_split ($pathRe,
        $template
      );

      if ( !(count ($templateStrSlices) >= 2) ) {
        $template .= (DIRECTORY_SEPARATOR . 'index');
      }

      /**
       * Error
       */
      $error->handle ([
        'title' => 'Sami\\ViewEngine::Error',

        'paragraphes' => array (
          'No \'<code class="yellow">'.$template.'</code>\' template found'
        )
      ]);
    }

    /**
     * @method void handle
     *
     */
    public static function NoAction ($controller, $action) {
      $error = new SamilsErrorHandler;
      $error->title = 'Routing Error - Action';
      $error->message = join ('', [
        'Unknown action \'<code class="blue">',
        $action, '</code>\' for \'',
        $controller, '\' controller'
      ]);

      $error->handle ( ['title' => 'Routing Error' ] );
    }

    public static function UnredableTemplate ($template) {
      $error = new SamilsErrorHandler;
      $error->title = 'Sami\\Routes::Error - #300';
      $error->message = (
        'Sami\\Router is unable to read ' .
        'the route template'
      );

      $route = new RouteDatas;

      $traceDatas = requires ('trace-datas')($route->trace);

      $error->handle ([
        'title' => 'Routing Error',
        'descriptions' => array (
          'Try using \'<code class="blue">@' .
          '' . str ($template) . '</code>\' as the route target.<br /><br />'
        ),
        'dumps' => array (
          'Sent Parameters' => array (
            'template' => $template
          )
        ),

        'source' => $traceDatas,
        'paragraphes' => $traceDatas
      ]);
    }

    public static function BadRoutePath ($backTrace = null) {
      $error = new SamilsErrorHandler;
      $error->title = 'Sami\\Routes::Error - BadRoutePath';
      $error->message = join ('', [
        'Route path is out of pattern.'
      ]);

      $args = [];

      if (isset ($backTrace [0]) &&
        is_array ($backTrace [0]) &&
        isset ($backTrace [0]['args']) &&
        is_array ($backTrace [0]['args'])) {
        $args = $backTrace [0]['args'];
      }

      $traceDatas = requires ('trace-datas')($backTrace);

      $error->handle ([
        'title' => 'Routing Error',
        'descriptions' => [
          '<br />',
          'Rewrite it to the correct pattern',
          'avoiding to use non alpha numeric chars.'
        ],

        'dumps' => array (
          'Sent Parameters' => array (
            'template' => $args
          )
        ),

        'source' => $traceDatas,
        'paragraphes' => $traceDatas
      ]);
    }

    public static function NoMethod ($class = null, $meth = null) {
      $backTrace = array_last_i (func_get_args ());

      if (is_string ($class) && is_array ($backTrace)) {
        $error = new SamilsErrorHandler;
        $error->title = 'Sami::Error - Undefined method';

        $error->message = join ( '', [
          'Undefined method \'<span class="red">',
          str ($meth), '</span>\' for \'',
          str ($class), '\'.'
        ]);

        $traceDatas = requires ('trace-datas')($backTrace);

        $error->handle ([
          'title' => 'Sami::Error - NoMethod',
          'paragraphes' => $traceDatas,
          'source' => $traceDatas
        ]);
      }
    }

    public static function NoAdapter ($adapter = null) {
      $error = new SamilsErrorHandler;

      if (!is_string ($adapter)) {
        $adapter = 'null';
      }

      $error->title = 'Sami\\Base::Error - No adapter';
      $error->message = (
        'There is an error connecting to the ' .
        'database.<br />' . (
          'No adapter \''.$adapter.'\' for interacting' .
          ' the driverd<br /><br />'
        )
      );

      $trace = debug_backtrace ();
      $sources = array ();

      foreach ($trace as $i => $currentTrace) {
        $traceDatas = requires ('trace-datas')($currentTrace);
        $sources [] = $traceDatas;
      }

      $error->handle ([
        'title' => 'Sami\\Base::Error',
        'source' => $sources
      ]);
    }

    public static function NoConnection ($errorDatas) {
      $error = new SamilsErrorHandler;

      if (!is_array ($errorDatas)) {
        return $errorDatas;
      }

      $errorObject = $errorDatas ['errorObject'];

      $error->title = 'Sami\\Base::Error - No Connection';
      $error->message = (
        'There is an error connecting to the ' .
        'database.<br /><br />' . (
          utf8_encode ($errorObject->getMessage ())
        ) . '<br />'
      );

      $trace = debug_backtrace ();
      $sources = array ();

      foreach ($trace as $i => $currentTrace) {
        $traceDatas = requires ('trace-datas')($currentTrace);
        $sources [] = $traceDatas;
      }

      $error->handle ([
        'title' => 'Sami\\Base::Error',
        'source' => $sources
      ]);

    }

    public static function NoConnectionDatas () {
      $error = new SamilsErrorHandler;

      $error->title = 'Sami\\Base::Error - No Connection Datas';
      $error->message = join ( '', [
        'There is an error connecting to the ',
        'database.<br /><br /> There are some missing datas such as the adapter and the driver to use it and a server address to access it.<br /><br />'
      ]);

      $error->handle ([
        'dumps' => [
          'Craete a config/database.json file as:' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'user' => 'root',
            'pass' => 'your local database password'
          ],
        ],
        'title' => 'Sami\\Base::Error - No Connection Datas'
      ]);
    }
  }}
}
