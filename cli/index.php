<?php

$commandLineInterface = requires ('command-line-interface');

$cli = $commandLineInterface ();

$moduleConfig = requires ('~/module.json');

if (is_array ($moduleConfig) &&
  isset ($moduleConfig ['scripts'])) {
  $cli->registerScriptList ($moduleConfig ['scripts']);
}

if (defined ('conf') &&
  is_array (conf) &&
  isset (conf ['cli']) &&
  is_array (conf ['cli'])) {
  $cli->config (conf ['cli']);
}

$cli->beforeRun (function () {
  #echo $this->commandsDir, "\n\n\n";
});

$module->exports = $cli;
