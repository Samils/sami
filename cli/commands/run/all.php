<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Cli
 * - Autoload, application dependencies
 *
 * MIT License
 *
 * Copyright (c) 2020 Ysare
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace Sammy\Packs\Sami\Cli {
  use Sammy\Packs\Sami\CommandLineInterface\Console;
  /**
   * Server Command
   */
  $module->exports = [
    'name' => 'run:all',
    'description' => 'Run The Given command list',
    'aliases' => ['run-all'],
    'handler' => function ($parameters, $options) {

      $commandList = $parameters->all ();

      $moduleConfs = requires ('~/module.json');

      $opts = $options->only ('p');

      #$moduleScriptConfigurationsSet = ( boolean ) (
      #  is_array($moduleConfs) &&
      #  isset ($moduleConfs['scripts']) &&
      #  is_array ($moduleConfs['scripts'])
      #);

      #$scripts = $moduleConfs['scripts'];

      $commandSeparator = $opts ['p'] ? '|' : '&&';

      $commandSynth = '';

      foreach ($commandList as $command) {
        $command = trim ($command);

        $commandSynth .= join (' ', [
          $commandSeparator,
          'php samils',
          $command,
          ''
        ]);
      }

      $commandSynth = preg_replace ('/^(\s*(\\||&&))\s*/', '',
        $commandSynth
      );

      @system ($commandSynth);
    }
  ];
}
