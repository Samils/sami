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
namespace Sammy\Packs\Sami {
  /**
   * Request Datas
   */
  $module->exports = array (
    'route' => RequestDatas::RoutePath (),
    'query_string' => RequestDatas::QueryString (),
    'method' => join ('', ['@', RequestDatas::RequestMethod ()])
  );
}
