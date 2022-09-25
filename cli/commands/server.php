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
  use Sammy\Packs\Sami\Debugger;
  use Sammy\Packs\Sami\CommandLineInterface\Console;
  /**
   * Server Command
   */
  $module->exports = [
    'name' => 'server',
    'description' => 'Run The Samils Development Server',
    'aliases' => ['s'],
    'handler' => function ($parameters, $options) {
      $props = $options->only ('port');

      $port = '7000';

      if (is_int ($props ['port'])) {
        $port = $props ['port'];
      }

      $path = requires ('path');
      $format = requires ('format');
      $ipconfig = requires ('ipconfig');


      $ipConfig = $ipconfig->getIpConfig ();

      $ipV4Addresses = [];

      if (is_array ($ipConfig)
        && isset ($ipConfig ['iPv4Address'])
        && is_array ($ipConfig ['iPv4Address'])
        && $ipConfig ['iPv4Address']) {
        $ipV4Addresses = $ipConfig ['iPv4Address'];
      }

      $welcome_message = join ("\n", ['',
        '- Samils Development Server',
        '- {|color:green}',
        '', ''
      ]);

      if (count ($ipV4Addresses) >= 1) {
        $add_welcome_message = [
          'On your Network:', '', ''
        ];

        foreach ($ipV4Addresses as $ipV4Address) {
          array_push ($add_welcome_message, " - http://{$ipV4Address}:{$port}");
        }

        $welcome_message .= join ("\n", array_merge ($add_welcome_message, ['', '', '', '']));
      }

      #  ("\n \n") .
      #  ("\n - \033[1;32mRunning on http:/") .
      #  ("/localhost:{$port}.\033[0m\n\n")
      #);
      $message = $format->format ($welcome_message, "Running on http://localhost:{$port}");

      Debugger::log ($message);

      print ($message);

      $rootDir = $path->join ('~', 'public');

      $ipList = ["php -S 127.0.0.1:{$port} {$rootDir}/index.php"];

      foreach ($ipV4Addresses as $ip) {
        array_push ($ipList, "php -S {$ip}:{$port} {$rootDir}/index.php");
      }

      $command = join (' | ', $ipList);

      @system ($command);

      exit (0);
    }
  ];
}
