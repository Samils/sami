<?php

# ils generate model User
# ils generate model User --skip-migration

$module->exports = [
  'include' => [
    'procedure'
  ],

  'templates' => [
    'model',
    'seeder',
    'factory',
    'migration'
  ],

  'aliases' => ['m'],

  'model.target' => 'app/models',
  'seeder.target' => 'db/seeders',
  'factory.target' => 'db/factory',
  'migration.target' => 'db/migrations',

  'migration.rename' => function ($migrationName) {
    $migrationName = camel2snakecase ($migrationName);

    $name = join ('_', ['create', $migrationName]);

    return join ('_', [timestamp (), strtolower ($name)]);
  },

  'migration.props' => function ($props) {
    $migrationName = snake2camelcase ($props ['name']);

    $name = join ('', ['Create', $migrationName]);

    return ['className' => $name];
  },

  'model.rename' => function ($name) {
    return ucfirst ($name);
  },

  'seeder.rename' => function ($name) {
    return ucfirst ($name) . 'Seeder';
  },

  'factory.rename' => function ($name) {
    return ucfirst ($name) . 'Factory';
  },

  'seeder.props' => function ($props) {
    return ['className' => $props ['name']];
  },

  'factory.props' => function ($props) {
    return ['varName' => $props ['name']];
  }
];
