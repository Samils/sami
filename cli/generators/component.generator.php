<?php

$module->exports = [
  'name' => 'component',
  'description' => 'Generate a new component file',
  'aliases' => ['cc'],
  'templates' => ['component' => 'component.template.cap'],

  'component.target' => 'app/views/components',
  'component.rename' => function ($name) {
    return ucfirst ($name);
  },

  'component.props' => function ($props) {
    $names = preg_split ('/([\\\\\/]+)/', $props ['name']);

    $componentName = $names [-1 + count ($names)];

    if (preg_match ('/^index$/i', $componentName) &&
        isset ($names [-2 + count ($names)])) {
      $componentName = $names [-2 + count ($names)];
    }

    return ['componentName' => ucfirst ($componentName)];
  }
];
