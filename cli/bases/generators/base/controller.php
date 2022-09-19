<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Cli\Generator
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\Sami\Cli\Generator {
    if (!trait_exists('Sammy\\Packs\\Sami\\Cli\\Generator\\Controller')) {
    trait Controller {
        /**
         * [generate_controller description]
         * @param  [type] $name [description]
         * @param  [type] $args [description]
         * @return [type]       [description]
         */
        function generate_controller ($name = null, ...$args) {
            $controller_path = (
                '@controllers/'
            );

            $controllerFileContent = array (
                '<?php'
            );

            $controllerFileDir = '';

            if (preg_match ('/(\\\|\/)/', $name)) {
                $name = preg_replace ('/\\\+/', '/',
                    trim($name)
                );

                $namePaths = preg_split ('/\/+/',
                    $name
                );

                $nameBeyondOwnName = array_splice( $namePaths,
                    0, (count($namePaths) - 1)
                );

                $controllerNameSpace = join ($nameBeyondOwnName,
                    '\\'
                );

                $controllerDirectoryPath = join ($nameBeyondOwnName,
                    '/'
                );

                $name = $namePaths [
                    (count($namePaths) - 1)
                ];

                $controller_path .= (
                    $controllerDirectoryPath . ('/')
                );

                $controllerFileDir = (
                    $controllerDirectoryPath
                );

                \Saml::mkDir ($controller_path);

                $controllerFileContent = array_merge (
                    $controllerFileContent, (
                        array (
                            ("namespace {$controllerNameSpace};"),
                            ("/**"),
                            (" * Include the SamiController".
                                (" class in the context")
                            ),
                            (" */"),
                            ("use \SamiController;\n")
                        )
                    )
                );
            }

            if (!(is_right_var_name ($name))) {
                $name = \str ($name);
                exit ("Error creating Controller\n - bad name => {$name}");
            }

            # Remove any conrespondence of _controller
            # at the end of the controller name in
            # order avoiding to have controller name
            # out the ils name patterns.
            $controllerFileName = preg_replace (
                '/_*(c(ontroller|trl))(\.php)?$/i', ''
                , $name
            ) . '_controller.php';

            $controllerFilePath = \path\find ('@controllers',
                $controllerFileName
            );

            if ($controllerFilePath) {
                exit ("Controller {$name} already exists");
            }

            $controllerFile = new \File ($controller_path .
                $controllerFileName
            );

            $controllerClassName = preg_replace (
                '/_*(c(ontroller|trl))$/i', '', (
                    $name
                )
            );

            $controllerFileContent = array_merge (
                $controllerFileContent, (
                    array (
                        ("class {$controllerClassName}Controller") .
                        (" extends SamiController {")
                    )
                )
            );

            echo ("\n\033[42mCreate\033[0m \033[0;32m"
                . '@controllers/'
                . "{$controllerFileDir}/"
                . "{$controllerFileName}\033[0m\n"
            );

            if (is_array($args) && $args) {
                # Each argument is the action
                # name being used to fill up
                # the controller scope
                foreach ($args as $i => $arg) {
                    if (!is_string($arg))
                        continue;

                    preg_match ('/^([^:]+)/', $arg,
                        $actionName
                    );

                    $actionName = \str($actionName[0]);

                    $controllerFileContent = array_merge($controllerFileContent,
                        array ( '',
                            ("\tfunction {$actionName} () {"),
                            ("\t}")
                        )
                    );

                    echo ("   \033[42mAdd\033[0m \033[0;32m"
                        . "{$actionName}\033[0m\n"
                    );
                }
            }

            $controllerFileContent = array_merge($controllerFileContent,
                array ( '}' )
            );

            $controllerFile->writeLines (
                $controllerFileContent
            );

            if (is_array($args) && $args) {
            }
        }
    }}
}
