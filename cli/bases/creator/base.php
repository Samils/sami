<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Cli
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\Sami\Cli {

    if (!trait_exists('Sammy\\Packs\\Sami\\Cli\\Creator')) {
    trait Creator {
        use Creator\Directory;
        /**
         * [_cmd_create description]
         * @param  [type] $g    Generator
         * @param  [type] $args Generator arguments
         * @return [type]       [description]
         */
        protected function _cmd_create ($g, ...$args) {
            # Turn generator name to
            # lower case
            $g = \lower($g);
            # Method name that should
            # be calling the generator
            # inside the 'cli' class
            $meth = ('create_' .
                $g
            );

            if (method_exists($this, $meth)) {
                return call_user_func_array ([$this, $meth],
                    $args
                );
            }

            $g_ = 'creators';

            $this->conf[$g_] = isset($this->conf[$g_]) ? (
                is_array($this->conf[$g_]) ? $this->conf[$g_] : []
            ) : [];

            if (isset($this->conf[$g_][$g])) {
                $str_args = join (' ', $args);

                $gen = $this->conf[$g_][
                    $g
                ];

                if (is_string($gen)) {

                    $bind = \php\requires('../arg-bind');

                    $generator_cmd = $bind->bind($args, $this->conf[$g_][
                        $g
                    ]);

                    system($generator_cmd);

                    return (
                        true
                    );
                } elseif (is_array($gen)) {
                    foreach ($gen as $i => $cmd) {
                        if (!(is_int($i) && is_string($cmd)))
                            continue;

                        $bind = \php\requires('../arg-bind');

                        $generator_cmd = $bind->bind($args, $cmd);
                        system($generator_cmd);
                    }
                    return (
                        true
                    );
                }
            }

            echo ( "\nError -> " .
               ("\033[0;31mUnknown creator $g\n\033[0m")
            );
        }
    }}
}

