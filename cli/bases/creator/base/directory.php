<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\Cli\Creator
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\Sami\Cli\Creator {
    if (!trait_exists('Sammy\\Packs\\Sami\\Cli\\Creator\\Directory')) {
    trait Directory {
    	/**
    	 * [create_directory description]
    	 * @param  string $path [description]
    	 * @return string
    	 */
    	function create_directory ($path = '') {

    		echo ("\n\033[42mCreate\033[0m \033[0;32m"
    		    . "{$path}\033[0m\n"
    		);

    		return \Saml::mkDir (
    			\str($path)
    		);
    	}
    	/**
    	 * [create_dir description]
    	 * @param  string $path [description]
    	 * @return string
    	 */
    	function create_dir ($path = '') {
    		return call_user_func_array ([$this, 'create_directory'],
    			func_get_args()
    		);
    	}
    }}
}
