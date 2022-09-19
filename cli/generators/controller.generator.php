<?php

use Sammy\Packs\Sami\CommandLineInterface\Arguments;

$module->exports = [
  'templates' => ['controller'],

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

    $className = join ('', [ucfirst ($name), 'Controller']);

    $parameters = Arguments::GetParameters ();

    $methods = $parameters->slice (2);

    return [
      'className' => $className,
      'methods' => $methods
    ];
  }
];
