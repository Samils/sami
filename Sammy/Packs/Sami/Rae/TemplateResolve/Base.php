<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Rae\TemplateResolve
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\Sami\Rae\TemplateResolve {
  use Sammy\Packs\Samils\ApplicationServerHelpers;
  use Sammy\Packs\Samils\ApplicationServer\ErrorHandler;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   */
  if (!trait_exists ('Sammy\Packs\Sami\Rae\TemplateResolve\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   * Sami\Rae\TemplateResolve module.
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
     * [resolve description]
     * @param  string $template
     * @return string
     */
    public final function resolve ($template = '') {
      $template = $this->pathName ($template);
        # View Engine Datas
      $ved = ApplicationServerHelpers::conf (
        'view-engine'
      );

      if ( is_object ($ved) ) {
        $fe = $ved->fileExtensions;

        # make sure '$fe' var is an
        # array in order mapping it
        $fe = is_array ($fe) ? $fe : [$fe];
        $fe_len = count ($fe);

        for ( $i = 0; $i < $fe_len; $i++ ) {
          /**
           * Make sure the current file
           * extension in the '$fe' array
           * is a string that should be a
           * supported extension for the
           * curret application view-engine.
           */
          if ( !is_string ( $fe[ $i ] ) )
            continue;

          $view_path = $ved->viewsDir . ( DS .
            $template . preg_replace ('/^\.*/', '.',
              $fe[ $i ]
            )
          );

          if ( is_file ( $view_path ) ) {
            return [ $view_path, 'viewsDir' => $ved->viewsDir ];
          } else {
            $view_path = $ved->viewsDir . ( DS .
              $template . DS . 'index' . preg_replace ('/^\.*/', '.',
                $fe[ $i ]
              )
            );

            if ( is_file ( $view_path ) ) {
              return [$view_path, 'viewsDir' => $ved->viewsDir];
            }
          }
        }
      }

      $error = new ErrorHandler ("No Template for: '{$template}'");

      $traceDatas = requires ('trace-datas')();
      $error->title = join ('::', [static::class, 'Error - No template']);

      $error->handle ([
        'title' => $error->title,
        'paragraphes' => $traceDatas,
        'source' => $traceDatas
      ]);
    }

    /**
     * [pathName description]
     * @param  string $template
     * @return string
     */
    public final function pathName ($template = '') {
      $template = str ($template);

      $arrPathName = [];
      $template = preg_replace ('/[\\\\\/]/', DIRECTORY_SEPARATOR, $template);
      /**
       * lower
       */
      $template = lower (camel2snakecase ($template));

      $templateSlices = preg_split ('/[\\\\\/]/', $template);

      foreach ($templateSlices as $templateSlice) {
        if (!preg_match ('/^:/', $templateSlice)) {
          array_push ($arrPathName, $templateSlice);
        }
      }

      return join (DIRECTORY_SEPARATOR, $arrPathName);
    }
  }}
}
