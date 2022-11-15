<?php

use Sammy\Packs\Sami\CommandLineInterface\Arguments;

$module->exports = [
  'name' => 'view',
  'description' => 'Generate a new view file',
  'aliases' => ['v'],
  'templates' => function ($parameters, $options) {
    $templates = ['view' => 'view.template.cap'];

    $customOptions = $options->only ('style');

    if ($customOptions ['style']) {
      $templates ['style'] = 'style.template.css';
    }

    return $templates;
  },

  'view.target' => 'app/views',
  'style.target' => 'app/views',

  'view.rename' => function ($name) {
    $name = preg_split ('/([\\\\\/]+)/', $name);

    $nameSliceMapper = function ($slice) {
      return camel2snakecase ($slice);
    };

    $name = array_map ($nameSliceMapper, $name);

    $options = Arguments::GetOptions ();

    $customOptions = $options->only ('style');

    if ($customOptions ['style']
      && !(strtolower ($name [-1 + count ($name)]) === 'index')) {
      array_push ($name, 'index');
    }

    $name = join (DIRECTORY_SEPARATOR, $name);

    return strtolower ($name);
  },

  'style.rename' => function ($name) {
    $name = preg_split ('/([\\\\\/]+)/', $name);

    $nameSliceMapper = function ($slice) {
      return camel2snakecase ($slice);
    };

    $name = array_map ($nameSliceMapper, array_merge ($name, ['styles']));

    $name = join (DIRECTORY_SEPARATOR, $name);

    return strtolower ($name);
  },

  'view.props' => function ($props) {
    $names = preg_split ('/([\\\\\/]+)/', $props ['name']);

    $viewName = $names [-1 + count ($names)];

    $viewName = preg_replace ('/\-+/', '_', $viewName);

    if (preg_match ('/^index$/i', $viewName)
      && isset ($names [-2 + count ($names)])) {
      $viewName = $names [-2 + count ($names)];
    }

    return ['viewName' => snake2camelcase ($viewName)];
  },

  'style.props' => function ($props) {
    $names = preg_split ('/([\\\\\/]+)/', $props ['name']);

    $viewName = $names [-1 + count ($names)];

    $viewName = preg_replace ('/\-+/', '_', $viewName);

    if (preg_match ('/^index$/i', $viewName)
      && isset ($names [-2 + count ($names)])) {
      $viewName = $names [-2 + count ($names)];
    }

    return ['viewName' => snake2camelcase ($viewName)];
  }
];
