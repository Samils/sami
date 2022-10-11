<?php

use Sammy\Packs\Sami\CommandLineInterface\Arguments;

$module->exports = [
  'templates' => ['controller'],

  'aliases' => ['c'],

  'controller.target' => 'app/controllers',

  'controller.rename' => function ($name) {
    $name = camel2snakecase ($name);

    $re = '/_controller$/i';
    $name = preg_replace ($re, '', $name);

    return join ('_', [$name, 'controller']);
  },

  'controller.props' => function ($props) {
    $name = snake2camelcase ($props ['name']);

    $re = '/Controller$/i';
    $name = preg_replace ($re, '', $name);
    $namespace = null;

    $className = join ('', [$name, 'Controller']);

    $classNameSlices = preg_split ('/[\/\\\\]/', $className);

    $classNameSlices = array_map (function ($slice) {
      return snake2camelcase ($slice);
    }, $classNameSlices);

    $classNameSlicesLen = count ($classNameSlices);

    if ($classNameSlicesLen >= 2) {
      $namespace = join ('\\', array_slice ($classNameSlices, 0, -1 + $classNameSlicesLen));
    }

    $parameters = Arguments::GetParameters ();

    $methods = $parameters->slice (2);

    return [
      'namespace' => $namespace,
      'className' => $classNameSlices [-1 + $classNameSlicesLen],
      'methods' => $methods
    ];
  }
];
