<?php

namespace Sami\Base {
  use Sammy\Packs\Sami\Base\Table;

  Schema::AddTable ('sometablehere', ['map' => false], function () {
    create_table ('sometablehere', function (Table $table) {
      $table->string ('name');
      $table->string ('email');
      $table->integer ('age');
      $table->date ('birthday');
    });
  });
}
