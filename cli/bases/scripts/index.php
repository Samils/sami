<?php
# Scripts
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
	/**
	 * [file_exec description]
	 * @param  string $file
	 * @param  array  $args
	 * @return null
	 */
	if (!function_exists ('Sammy\\Packs\\Sami\\Cli\\file_exec')) {
	function file_exec ($file = '', $args = []) {
	    include $file;
	}}
	/**
	 * Make sure the Scripts trait is
	 * not defined in the php global
	 * scope yet.
	 */
	if (!trait_exists('Sammy\\Packs\\Sami\\Cli\\Scripts')) {
	/**
	 * Scripts
	 */
	trait Scripts {
        /**
         * [tryRunningScript description]
         * @param  string $script
         * @param  array  $args
         * @return null
         */
        public function tryRunningScript ($script, $args = []) {
        	/**
        	 * [$moduleConfs description]
        	 * @var array
        	 */
        	$moduleConfs = requires ('~/module.json');

        	$moduleScriptConfigurationsSet = ( boolean ) (
        		is_array($moduleConfs) &&
        		isset ($moduleConfs['scripts']) &&
        		is_array ($moduleConfs['scripts']) &&
        		isset ($moduleConfs['scripts'][$script])
        	);

        	if ( $moduleScriptConfigurationsSet ) {
        		$command = $moduleConfs['scripts'][ $script ];

        		if ( is_string ($command) ) {
        			$this->runnScript ($command, $args);
        		} elseif ( is_array ($command) ) {
        			$this->runnScripts ($command, $args);
        		}

        		exit (0);
        	}

          $fileExtensionRe = '/(\.php)$/i';
        	$scriptPath = path ("@bin/{$script}");

        	if (!preg_match ($fileExtensionRe, $scriptPath)) {
            $scriptPath .= '.php';
        	}

        	if ( is_file ($scriptPath) ) {
        		exit ( file_exec ($scriptPath, $args) );
        	}
        }
        /**
         * [runnScript description]
         * @param  string $command
         * @param  array  $args
         * @return null
         */
        private function runnScript ($command = '', $args = []) {
        	if (!(is_string($command) && $command))
        		return;

        	$splCommand = preg_split ( '/\s+/', $command );

        	if ( $splCommand ) {
        		$command = $splCommand [0];

        		$commandArgs = array_merge (
        			array_slice ($splCommand, 1, count($splCommand)), (
        				$args
        			)
        		);

        		return call_user_func_array ([$this, 'execute'],
        			array_merge ([$command], $commandArgs)
        		);
        	}
        }
        /**
         * [runnScripts description]
         * @param  array $commandList
         * @param  array  $args
         * @return null
         */
        private function runnScripts ($commandList = '', $args = []) {
        	if (!(is_array($commandList) && $commandList))
        		return;

        	foreach ($commandList as $i => $command) {
        		$this->runnScript ($command, $args);
        	}
        }
	}}
}
