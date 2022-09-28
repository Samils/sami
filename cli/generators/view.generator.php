<?php

$module->exports = [
  'name' => 'view',
  'description' => 'Generate a new view file',
  'aliases' => ['v'],
  'templates' => ['view' => 'view.template.cap'],

  'view.target' => 'app/views',
  'view.rename' => function ($name) {
    $name = preg_split ('/([\\\\\/]+)/', $name);

    $nameSliceMapper = function ($slice) {
      return camel2snakecase ($slice);
    };

    $name = join (DIRECTORY_SEPARATOR, array_map ($nameSliceMapper, $name));

    return $name;
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
  }
];
