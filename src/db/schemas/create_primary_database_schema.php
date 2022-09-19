<?php

namespace Sami\Base {
  use Sammy\Packs\Sami\Base\Table;

  Schema::AddTable ('schemamigration', ['map' => false], function () {
    create_table ('schemamigration', function (Table $table) {
      $table->tinyText ('migration_timestamp');
      $table->tinyText ('migration_file_name');
      $table->string ('migration_last_modify');
      $table->string ('migration_table_name');
    });
  });
}
