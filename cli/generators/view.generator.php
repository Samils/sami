<?php

$module->exports = [
  'name' => 'view',
  'description' => 'Generate a new view file',
  'aliases' => ['v'],
  'templates' => ['view' => 'view.template.cap'],

  'view.target' => 'app/views',
  'view.rename' => function ($name) {
    return ucfirst ($name);
  },

  'view.props' => function ($props) {
    $names = preg_split ('/\/+/', $props ['name']);

    $componentName = $names [-1 + count ($names)];

    if (preg_match ('/^index$/i', $componentName) &&
        isset ($names [-2 + count ($names)])) {
      $componentName = $names [-2 + count ($names)];
    }

    return ['componentName' => ucfirst ($componentName)];
  }
];
