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
  use Sammy\Packs\Func;

  Base::SetUpSchema ();

  defined ('SCHEMA_VERSION_FILE') or define (
    'SCHEMA_VERSION_FILE', __DIR__ . '/.schema-version'
  );

	$module->exports = new Func (function ($args = []) {
    return new Base ($args);
  });
}
