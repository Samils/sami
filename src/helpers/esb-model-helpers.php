<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sami\Base
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

use Sami\Base as SamiBase;

if (!function_exists ('accessible_attributes')) {
/**
 * @function accessible_attributes
 * Base global function for the
 * Sami\Base model helper.
 * -
 * This is (in the ils environment)
 * an instance of the php module,
 * wich should contain the module
 * core functionalities that should
 * be extended.
 * -
 * For extending the module, just create
 * an 'exts' directory in the module directory
 * and boot it by using the ils directory boot.
 * -
 * @param array $args
 * list of sent arguments to the
 * current SamiBase Helper function.
 */
function accessible_attributes ($args) {
  $backTrace = debug_backtrace ();
  # Complete Trace
  # A boolean value indicating if
  # the function back trace is
  # complete (is the reference is the
  # expected for using a SamiBase helper).
  $CompleteTrace = ( boolean ) (
    # Make sure the current back trace
    # contains a fisrt position and it
    # is not a null or a not array value.
    isset ($backTrace [0]) &&
    # Make sure the current back trace
    # contains a second position and it
    # is not a null or a not array value.
    isset ($backTrace [1]) &&
    # Make sure the fisrt position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [0]) &&
    # Make sure the second position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [1]) &&
    # Verify is the 'function' property is
    # inside the array at the 0 position.
    isset ($backTrace [0]['function']) &&
    # Verify is the 'class' property is
    # inside the array at the 1 position.
    isset ($backTrace [1]['class'])
  );
  # Make sure the reference class in the
  # stack trace is an instance or child class
  # os the SamiBase Core Class in order using
  # the current helper on it;
  # Application will stop and throw an error
  # in negative case.
  # ---
  # THE CURRENT HELPER FUNCTION IS ONLY AVAILABLE
  # FOR USING INSIDE SAMI BASE MODELS; AND SHOULD
  # NOT BE USED OUT OF THEM.
  # ---
  if ($CompleteTrace && in_array (SamiBase::class, class_parents($backTrace [1]['class']))) {
    $calledFunction = snake2camelcase ($backTrace [0]['function']);
    $referenceClass = $backTrace [1]['class'];
    # Verify if the called function is already declared
    # in the referenceClass in order call it statically.
    # ---
    # NOTE: THE METHOD WITH THE SAME NAME AS THE CURRENT
    # HELPRE INSIDE THE SAMIBASE CLASS SHOULD NOT BE CALLED
    # OUT OF A CHILD CLASS OR SOME OF THE SAMI BASE HELPERS
    # ---
    # Make sure a method names as the current helper is declared
    # in the Helper class.
    if (method_exists ($referenceClass, $calledFunction)) {
      # Make a static call to the called method inside
      # the refernce class sending the received arguments
      # on its scope and return the result to the helper
      # called scope.
      return forward_static_call_array (
        # Statc Method Reference
        [$referenceClass, $calledFunction], (
          # A list of whole the received
          # arguments to the current helper
          # function scope.
          func_get_args ()
        )
      );
    }
  }

  SamiBase::UnCoughtReference ($backTrace);
}}

if (!function_exists ('belongs_to')) {
/**
 * @function belongs_to
 * Base global function for the
 * Sami\Base model helper.
 * -
 * This is (in the ils environment)
 * an instance of the php module,
 * wich should contain the module
 * core functionalities that should
 * be extended.
 * -
 * For extending the module, just create
 * an 'exts' directory in the module directory
 * and boot it by using the ils directory boot.
 * -
 * @param array $args
 * list of sent arguments to the
 * current SamiBase Helper function.
 */
function belongs_to ($args) {
  $backTrace = debug_backtrace ();
  # Complete Trace
  # A boolean value indicating if
  # the function back trace is
  # complete (is the reference is the
  # expected for using a SamiBase helper).
  $CompleteTrace = ( boolean ) (
    # Make sure the current back trace
    # contains a fisrt position and it
    # is not a null or a not array value.
    isset ($backTrace [0]) &&
    # Make sure the current back trace
    # contains a second position and it
    # is not a null or a not array value.
    isset ($backTrace [1]) &&
    # Make sure the fisrt position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [0]) &&
    # Make sure the second position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [1]) &&
    # Verify is the 'function' property is
    # inside the array at the 0 position.
    isset ($backTrace [0]['function']) &&
    # Verify is the 'class' property is
    # inside the array at the 1 position.
    isset ($backTrace [1]['class'])
  );
  # Make sure the reference class in the
  # stack trace is an instance or child class
  # os the SamiBase Core Class in order using
  # the current helper on it;
  # Application will stop and throw an error
  # in negative case.
  # ---
  # THE CURRENT HELPER FUNCTION IS ONLY AVAILABLE
  # FOR USING INSIDE SAMI BASE MODELS; AND SHOULD
  # NOT BE USED OUT OF THEM.
  # ---
  if ($CompleteTrace && in_array (SamiBase::class, class_parents($backTrace [1]['class']))) {
    $calledFunction = snake2camelcase ($backTrace [0]['function']);
    $referenceClass = $backTrace [1]['class'];
    # Verify if the called function is already declared
    # in the referenceClass in order call it statically.
    # ---
    # NOTE: THE METHOD WITH THE SAME NAME AS THE CURRENT
    # HELPRE INSIDE THE SAMIBASE CLASS SHOULD NOT BE CALLED
    # OUT OF A CHILD CLASS OR SOME OF THE SAMI BASE HELPERS
    # ---
    # Make sure a method names as the current helper is declared
    # in the Helper class.
    if (method_exists ($referenceClass, $calledFunction)) {
      # Make a static call to the called method inside
      # the refernce class sending the received arguments
      # on its scope and return the result to the helper
      # called scope.
      return forward_static_call_array (
        # Statc Method Reference
        [$referenceClass, $calledFunction], (
          # A list of whole the received
          # arguments to the current helper
          # function scope.
          func_get_args ()
        )
      );
    }
  }

  SamiBase::UnCoughtReference ($backTrace);
}}

if (!function_exists ('belongs_to_many')) {
/**
 * @function belongs_to_many
 * Base global function for the
 * Sami\Base model helper.
 * -
 * This is (in the ils environment)
 * an instance of the php module,
 * wich should contain the module
 * core functionalities that should
 * be extended.
 * -
 * For extending the module, just create
 * an 'exts' directory in the module directory
 * and boot it by using the ils directory boot.
 * -
 *
 * -
 * @param array $args
 * list of sent arguments to the
 * current SamiBase Helper function.
 */
function belongs_to_many ($args) {
  $backTrace = debug_backtrace ();
  # Complete Trace
  # A boolean value indicating if
  # the function back trace is
  # complete (is the reference is the
  # expected for using a SamiBase helper).
  $CompleteTrace = ( boolean ) (
    # Make sure the current back trace
    # contains a fisrt position and it
    # is not a null or a not array value.
    isset ($backTrace [0]) &&
    # Make sure the current back trace
    # contains a second position and it
    # is not a null or a not array value.
    isset ($backTrace [1]) &&
    # Make sure the fisrt position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [0]) &&
    # Make sure the second position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [1]) &&
    # Verify is the 'function' property is
    # inside the array at the 0 position.
    isset ($backTrace [0]['function']) &&
    # Verify is the 'class' property is
    # inside the array at the 1 position.
    isset ($backTrace [1]['class'])
  );
  # Make sure the reference class in the
  # stack trace is an instance or child class
  # os the SamiBase Core Class in order using
  # the current helper on it;
  # Application will stop and throw an error
  # in negative case.
  # ---
  # THE CURRENT HELPER FUNCTION IS ONLY AVAILABLE
  # FOR USING INSIDE SAMI BASE MODELS; AND SHOULD
  # NOT BE USED OUT OF THEM.
  # ---
  if ($CompleteTrace && in_array (SamiBase::class, class_parents($backTrace [1]['class']))) {
    $calledFunction = snake2camelcase ($backTrace [0]['function']);
    $referenceClass = $backTrace [1]['class'];
    # Verify if the called function is already declared
    # in the referenceClass in order call it statically.
    # ---
    # NOTE: THE METHOD WITH THE SAME NAME AS THE CURRENT
    # HELPRE INSIDE THE SAMIBASE CLASS SHOULD NOT BE CALLED
    # OUT OF A CHILD CLASS OR SOME OF THE SAMI BASE HELPERS
    # ---
    # Make sure a method names as the current helper is declared
    # in the Helper class.
    if (method_exists ($referenceClass, $calledFunction)) {
      # Make a static call to the called method inside
      # the refernce class sending the received arguments
      # on its scope and return the result to the helper
      # called scope.
      return forward_static_call_array (
        # Statc Method Reference
        [$referenceClass, $calledFunction], (
          # A list of whole the received
          # arguments to the current helper
          # function scope.
          func_get_args ()
        )
      );
    }
  }

  SamiBase::UnCoughtReference ($backTrace);
}}

if (!function_exists ('has')){
/**
 * @function has
 * Base global function for the
 * Sami\Base model helper.
 * -
 * This is (in the ils environment)
 * an instance of the php module,
 * wich should contain the module
 * core functionalities that should
 * be extended.
 * -
 * For extending the module, just create
 * an 'exts' directory in the module directory
 * and boot it by using the ils directory boot.
 * -
 *
 * -
 * @param array $args
 * list of sent arguments to the
 * current SamiBase Helper function.
 */
function has ($args) {
  $backTrace = debug_backtrace ();
  # Complete Trace
  # A boolean value indicating if
  # the function back trace is
  # complete (is the reference is the
  # expected for using a SamiBase helper).
  $CompleteTrace = ( boolean ) (
    # Make sure the current back trace
    # contains a fisrt position and it
    # is not a null or a not array value.
    isset ($backTrace [0]) &&
    # Make sure the current back trace
    # contains a second position and it
    # is not a null or a not array value.
    isset ($backTrace [1]) &&
    # Make sure the fisrt position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [0]) &&
    # Make sure the second position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [1]) &&
    # Verify is the 'function' property is
    # inside the array at the 0 position.
    isset ($backTrace [0]['function']) &&
    # Verify is the 'class' property is
    # inside the array at the 1 position.
    isset ($backTrace [1]['class'])
  );
  # Make sure the reference class in the
  # stack trace is an instance or child class
  # os the SamiBase Core Class in order using
  # the current helper on it;
  # Application will stop and throw an error
  # in negative case.
  # ---
  # THE CURRENT HELPER FUNCTION IS ONLY AVAILABLE
  # FOR USING INSIDE SAMI BASE MODELS; AND SHOULD
  # NOT BE USED OUT OF THEM.
  # ---
  if ($CompleteTrace && in_array (SamiBase::class, class_parents($backTrace [1]['class']))) {
    $calledFunction = snake2camelcase ($backTrace [0]['function']);
    $referenceClass = $backTrace [1]['class'];
    # Verify if the called function is already declared
    # in the referenceClass in order call it statically.
    # ---
    # NOTE: THE METHOD WITH THE SAME NAME AS THE CURRENT
    # HELPRE INSIDE THE SAMIBASE CLASS SHOULD NOT BE CALLED
    # OUT OF A CHILD CLASS OR SOME OF THE SAMI BASE HELPERS
    # ---
    # Make sure a method names as the current helper is declared
    # in the Helper class.
    if (method_exists ($referenceClass, $calledFunction)) {
      # Make a static call to the called method inside
      # the refernce class sending the received arguments
      # on its scope and return the result to the helper
      # called scope.
      return forward_static_call_array (
        # Statc Method Reference
        [$referenceClass, $calledFunction], (
          # A list of whole the received
          # arguments to the current helper
          # function scope.
          func_get_args ()
        )
      );
    }
  }

  SamiBase::UnCoughtReference ($backTrace);
}}

if (!function_exists ('has_one')){
/**
 * @function has
 * Base global function for the
 * Sami\Base model helper.
 * -
 * This is (in the ils environment)
 * an instance of the php module,
 * wich should contain the module
 * core functionalities that should
 * be extended.
 * -
 * For extending the module, just create
 * an 'exts' directory in the module directory
 * and boot it by using the ils directory boot.
 * -
 *
 * -
 * @param array $args
 * list of sent arguments to the
 * current SamiBase Helper function.
 */
function has_one ($args) {
  $backTrace = debug_backtrace ();
  # Complete Trace
  # A boolean value indicating if
  # the function back trace is
  # complete (is the reference is the
  # expected for using a SamiBase helper).
  $CompleteTrace = ( boolean ) (
    # Make sure the current back trace
    # contains a fisrt position and it
    # is not a null or a not array value.
    isset ($backTrace [0]) &&
    # Make sure the current back trace
    # contains a second position and it
    # is not a null or a not array value.
    isset ($backTrace [1]) &&
    # Make sure the fisrt position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [0]) &&
    # Make sure the second position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [1]) &&
    # Verify is the 'function' property is
    # inside the array at the 0 position.
    isset ($backTrace [0]['function']) &&
    # Verify is the 'class' property is
    # inside the array at the 1 position.
    isset ($backTrace [1]['class'])
  );
  # Make sure the reference class in the
  # stack trace is an instance or child class
  # os the SamiBase Core Class in order using
  # the current helper on it;
  # Application will stop and throw an error
  # in negative case.
  # ---
  # THE CURRENT HELPER FUNCTION IS ONLY AVAILABLE
  # FOR USING INSIDE SAMI BASE MODELS; AND SHOULD
  # NOT BE USED OUT OF THEM.
  # ---
  if ($CompleteTrace && in_array (SamiBase::class, class_parents($backTrace [1]['class']))) {
    $calledFunction = snake2camelcase ($backTrace [0]['function']);
    $referenceClass = $backTrace [1]['class'];
    # Verify if the called function is already declared
    # in the referenceClass in order call it statically.
    # ---
    # NOTE: THE METHOD WITH THE SAME NAME AS THE CURRENT
    # HELPRE INSIDE THE SAMIBASE CLASS SHOULD NOT BE CALLED
    # OUT OF A CHILD CLASS OR SOME OF THE SAMI BASE HELPERS
    # ---
    # Make sure a method names as the current helper is declared
    # in the Helper class.
    if (method_exists ($referenceClass, $calledFunction)) {
      # Make a static call to the called method inside
      # the refernce class sending the received arguments
      # on its scope and return the result to the helper
      # called scope.
      return forward_static_call_array (
        # Statc Method Reference
        [$referenceClass, $calledFunction], (
          # A list of whole the received
          # arguments to the current helper
          # function scope.
          func_get_args ()
        )
      );
    }
  }

  SamiBase::UnCoughtReference ($backTrace);
}}

if (!function_exists ('has_many')){
/**
 * @function has_many
 * Base global function for the
 * Sami\Base model helper.
 * -
 * This is (in the ils environment)
 * an instance of the php module,
 * wich should contain the module
 * core functionalities that should
 * be extended.
 * -
 * For extending the module, just create
 * an 'exts' directory in the module directory
 * and boot it by using the ils directory boot.
 * -
 *
 * -
 * @param array $args
 * list of sent arguments to the
 * current SamiBase Helper function.
 */
function has_many ($args) {
  $backTrace = debug_backtrace ();
  # Complete Trace
  # A boolean value indicating if
  # the function back trace is
  # complete (is the reference is the
  # expected for using a SamiBase helper).
  $CompleteTrace = ( boolean ) (
    # Make sure the current back trace
    # contains a fisrt position and it
    # is not a null or a not array value.
    isset ($backTrace [0]) &&
    # Make sure the current back trace
    # contains a second position and it
    # is not a null or a not array value.
    isset ($backTrace [1]) &&
    # Make sure the fisrt position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [0]) &&
    # Make sure the second position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [1]) &&
    # Verify is the 'function' property is
    # inside the array at the 0 position.
    isset ($backTrace [0]['function']) &&
    # Verify is the 'class' property is
    # inside the array at the 1 position.
    isset ($backTrace [1]['class'])
  );
  # Make sure the reference class in the
  # stack trace is an instance or child class
  # os the SamiBase Core Class in order using
  # the current helper on it;
  # Application will stop and throw an error
  # in negative case.
  # ---
  # THE CURRENT HELPER FUNCTION IS ONLY AVAILABLE
  # FOR USING INSIDE SAMI BASE MODELS; AND SHOULD
  # NOT BE USED OUT OF THEM.
  # ---
  if ($CompleteTrace && in_array (SamiBase::class, class_parents($backTrace [1]['class']))) {
    $calledFunction = snake2camelcase ($backTrace [0]['function']);
    $referenceClass = $backTrace [1]['class'];
    # Verify if the called function is already declared
    # in the referenceClass in order call it statically.
    # ---
    # NOTE: THE METHOD WITH THE SAME NAME AS THE CURRENT
    # HELPRE INSIDE THE SAMIBASE CLASS SHOULD NOT BE CALLED
    # OUT OF A CHILD CLASS OR SOME OF THE SAMI BASE HELPERS
    # ---
    # Make sure a method names as the current helper is declared
    # in the Helper class.
    if (method_exists ($referenceClass, $calledFunction)) {
      # Make a static call to the called method inside
      # the refernce class sending the received arguments
      # on its scope and return the result to the helper
      # called scope.
      return forward_static_call_array (
        # Statc Method Reference
        [$referenceClass, $calledFunction], (
          # A list of whole the received
          # arguments to the current helper
          # function scope.
          func_get_args ()
        )
      );
    }
  }

  SamiBase::UnCoughtReference ($backTrace);
}}

if (!function_exists ('hook')){
/**
 * @function hook
 * Base global function for the
 * Sami\Base model helper.
 * -
 * This is (in the ils environment)
 * an instance of the php module,
 * wich should contain the module
 * core functionalities that should
 * be extended.
 * -
 * For extending the module, just create
 * an 'exts' directory in the module directory
 * and boot it by using the ils directory boot.
 * -
 *
 * -
 * @param array $args
 * list of sent arguments to the
 * current SamiBase Helper function.
 */
function hook ($args) {
  $backTrace = debug_backtrace ();
  # Complete Trace
  # A boolean value indicating if
  # the function back trace is
  # complete (is the reference is the
  # expected for using a SamiBase helper).
  $CompleteTrace = ( boolean ) (
    # Make sure the current back trace
    # contains a fisrt position and it
    # is not a null or a not array value.
    isset ($backTrace [0]) &&
    # Make sure the current back trace
    # contains a second position and it
    # is not a null or a not array value.
    isset ($backTrace [1]) &&
    # Make sure the fisrt position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [0]) &&
    # Make sure the second position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [1]) &&
    # Verify is the 'function' property is
    # inside the array at the 0 position.
    isset ($backTrace [0]['function']) &&
    # Verify is the 'class' property is
    # inside the array at the 1 position.
    isset ($backTrace [1]['class'])
  );
  # Make sure the reference class in the
  # stack trace is an instance or child class
  # os the SamiBase Core Class in order using
  # the current helper on it;
  # Application will stop and throw an error
  # in negative case.
  # ---
  # THE CURRENT HELPER FUNCTION IS ONLY AVAILABLE
  # FOR USING INSIDE SAMI BASE MODELS; AND SHOULD
  # NOT BE USED OUT OF THEM.
  # ---
  if ($CompleteTrace && in_array (SamiBase::class, class_parents($backTrace [1]['class']))) {
    $calledFunction = snake2camelcase ($backTrace [0]['function']);
    $referenceClass = $backTrace [1]['class'];
    # Verify if the called function is already declared
    # in the referenceClass in order call it statically.
    # ---
    # NOTE: THE METHOD WITH THE SAME NAME AS THE CURRENT
    # HELPRE INSIDE THE SAMIBASE CLASS SHOULD NOT BE CALLED
    # OUT OF A CHILD CLASS OR SOME OF THE SAMI BASE HELPERS
    # ---
    # Make sure a method names as the current helper is declared
    # in the Helper class.
    if (method_exists ($referenceClass, $calledFunction)) {
      # Make a static call to the called method inside
      # the refernce class sending the received arguments
      # on its scope and return the result to the helper
      # called scope.
      return forward_static_call_array (
        # Statc Method Reference
        [$referenceClass, $calledFunction], (
          # A list of whole the received
          # arguments to the current helper
          # function scope.
          func_get_args ()
        )
      );
    }
  }

  SamiBase::UnCoughtReference ($backTrace);
}}

if (!function_exists ('validate')){
/**
 * @function validate
 * Base global function for the
 * Sami\Base model helper.
 * -
 * This is (in the ils environment)
 * an instance of the php module,
 * wich should contain the module
 * core functionalities that should
 * be extended.
 * -
 * For extending the module, just create
 * an 'exts' directory in the module directory
 * and boot it by using the ils directory boot.
 * -
 *
 * -
 * @param array $args
 * list of sent arguments to the
 * current SamiBase Helper function.
 */
function validate ($args) {
  $backTrace = debug_backtrace ();
  # Complete Trace
  # A boolean value indicating if
  # the function back trace is
  # complete (is the reference is the
  # expected for using a SamiBase helper).
  $CompleteTrace = ( boolean ) (
    # Make sure the current back trace
    # contains a fisrt position and it
    # is not a null or a not array value.
    isset ($backTrace [0]) &&
    # Make sure the current back trace
    # contains a second position and it
    # is not a null or a not array value.
    isset ($backTrace [1]) &&
    # Make sure the fisrt position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [0]) &&
    # Make sure the second position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [1]) &&
    # Verify is the 'function' property is
    # inside the array at the 0 position.
    isset ($backTrace [0]['function']) &&
    # Verify is the 'class' property is
    # inside the array at the 1 position.
    isset ($backTrace [1]['class'])
  );
  # Make sure the reference class in the
  # stack trace is an instance or child class
  # os the SamiBase Core Class in order using
  # the current helper on it;
  # Application will stop and throw an error
  # in negative case.
  # ---
  # THE CURRENT HELPER FUNCTION IS ONLY AVAILABLE
  # FOR USING INSIDE SAMI BASE MODELS; AND SHOULD
  # NOT BE USED OUT OF THEM.
  # ---
  if ($CompleteTrace && in_array (SamiBase::class, class_parents($backTrace [1]['class']))) {
    $calledFunction = snake2camelcase ($backTrace [0]['function']);
    $referenceClass = $backTrace [1]['class'];
    # Verify if the called function is already declared
    # in the referenceClass in order call it statically.
    # ---
    # NOTE: THE METHOD WITH THE SAME NAME AS THE CURRENT
    # HELPRE INSIDE THE SAMIBASE CLASS SHOULD NOT BE CALLED
    # OUT OF A CHILD CLASS OR SOME OF THE SAMI BASE HELPERS
    # ---
    # Make sure a method names as the current helper is declared
    # in the Helper class.
    if (method_exists ($referenceClass, $calledFunction)) {
      # Make a static call to the called method inside
      # the refernce class sending the received arguments
      # on its scope and return the result to the helper
      # called scope.
      return forward_static_call_array (
        # Statc Method Reference
        [$referenceClass, $calledFunction], (
          # A list of whole the received
          # arguments to the current helper
          # function scope.
          func_get_args ()
        )
      );
    }
  }

  SamiBase::UnCoughtReference ($backTrace);
}}

if (!function_exists ('validate_presence_of')){
/**
 * @function validate_presence_of
 * Base global function for the
 * Sami\Base model helper.
 * -
 * This is (in the ils environment)
 * an instance of the php module,
 * wich should contain the module
 * core functionalities that should
 * be extended.
 * -
 * For extending the module, just create
 * an 'exts' directory in the module directory
 * and boot it by using the ils directory boot.
 * -
 *
 * -
 * @param array $args
 * list of sent arguments to the
 * current SamiBase Helper function.
 */
function validate_presence_of ($args) {
  $backTrace = debug_backtrace ();
  # Complete Trace
  # A boolean value indicating if
  # the function back trace is
  # complete (is the reference is the
  # expected for using a SamiBase helper).
  $CompleteTrace = ( boolean ) (
    # Make sure the current back trace
    # contains a fisrt position and it
    # is not a null or a not array value.
    isset ($backTrace [0]) &&
    # Make sure the current back trace
    # contains a second position and it
    # is not a null or a not array value.
    isset ($backTrace [1]) &&
    # Make sure the fisrt position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [0]) &&
    # Make sure the second position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [1]) &&
    # Verify is the 'function' property is
    # inside the array at the 0 position.
    isset ($backTrace [0]['function']) &&
    # Verify is the 'class' property is
    # inside the array at the 1 position.
    isset ($backTrace [1]['class'])
  );
  # Make sure the reference class in the
  # stack trace is an instance or child class
  # os the SamiBase Core Class in order using
  # the current helper on it;
  # Application will stop and throw an error
  # in negative case.
  # ---
  # THE CURRENT HELPER FUNCTION IS ONLY AVAILABLE
  # FOR USING INSIDE SAMI BASE MODELS; AND SHOULD
  # NOT BE USED OUT OF THEM.
  # ---
  if ($CompleteTrace && in_array (SamiBase::class, class_parents($backTrace [1]['class']))) {
    $calledFunction = snake2camelcase ($backTrace [0]['function']);
    $referenceClass = $backTrace [1]['class'];

    # Verify if the called function is already declared
    # in the referenceClass in order call it statically.
    # ---
    # NOTE: THE METHOD WITH THE SAME NAME AS THE CURRENT
    # HELPRE INSIDE THE SAMIBASE CLASS SHOULD NOT BE CALLED
    # OUT OF A CHILD CLASS OR SOME OF THE SAMI BASE HELPERS
    # ---
    # Make sure a method names as the current helper is declared
    # in the Helper class.
    if (method_exists ($referenceClass, $calledFunction)) {
      # Make a static call to the called method inside
      # the refernce class sending the received arguments
      # on its scope and return the result to the helper
      # called scope.
      return forward_static_call_array (
        # Statc Method Reference
        [$referenceClass, $calledFunction], (
          # A list of whole the received
          # arguments to the current helper
          # function scope.
          func_get_args ()
        )
      );
    }
  }

  SamiBase::UnCoughtReference ($backTrace);
}}

if (!function_exists ('validate_uniqueness_of')){
/**
 * @function validate_uniqueness_of
 * Base global function for the
 * Sami\Base model helper.
 * -
 * This is (in the ils environment)
 * an instance of the php module,
 * wich should contain the module
 * core functionalities that should
 * be extended.
 * -
 * For extending the module, just create
 * an 'exts' directory in the module directory
 * and boot it by using the ils directory boot.
 * -
 *
 * -
 * @param array $args
 * list of sent arguments to the
 * current SamiBase Helper function.
 */
function validate_uniqueness_of ($args) {
  $backTrace = debug_backtrace ();
  # Complete Trace
  # A boolean value indicating if
  # the function back trace is
  # complete (is the reference is the
  # expected for using a SamiBase helper).
  $CompleteTrace = ( boolean ) (
    # Make sure the current back trace
    # contains a fisrt position and it
    # is not a null or a not array value.
    isset ($backTrace [0]) &&
    # Make sure the current back trace
    # contains a second position and it
    # is not a null or a not array value.
    isset ($backTrace [1]) &&
    # Make sure the fisrt position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [0]) &&
    # Make sure the second position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [1]) &&
    # Verify is the 'function' property is
    # inside the array at the 0 position.
    isset ($backTrace [0]['function']) &&
    # Verify is the 'class' property is
    # inside the array at the 1 position.
    isset ($backTrace [1]['class'])
  );
  # Make sure the reference class in the
  # stack trace is an instance or child class
  # os the SamiBase Core Class in order using
  # the current helper on it;
  # Application will stop and throw an error
  # in negative case.
  # ---
  # THE CURRENT HELPER FUNCTION IS ONLY AVAILABLE
  # FOR USING INSIDE SAMI BASE MODELS; AND SHOULD
  # NOT BE USED OUT OF THEM.
  # ---
  if ($CompleteTrace && in_array (SamiBase::class, class_parents($backTrace [1]['class']))) {
    $calledFunction = snake2camelcase ($backTrace [0]['function']);
    $referenceClass = $backTrace [1]['class'];
    # Verify if the called function is already declared
    # in the referenceClass in order call it statically.
    # ---
    # NOTE: THE METHOD WITH THE SAME NAME AS THE CURRENT
    # HELPRE INSIDE THE SAMIBASE CLASS SHOULD NOT BE CALLED
    # OUT OF A CHILD CLASS OR SOME OF THE SAMI BASE HELPERS
    # ---
    # Make sure a method names as the current helper is declared
    # in the Helper class.
    if (method_exists ($referenceClass, $calledFunction)) {
      # Make a static call to the called method inside
      # the refernce class sending the received arguments
      # on its scope and return the result to the helper
      # called scope.
      return forward_static_call_array (
        # Statc Method Reference
        [$referenceClass, $calledFunction], (
          # A list of whole the received
          # arguments to the current helper
          # function scope.
          func_get_args ()
        )
      );
    }
  }

  SamiBase::UnCoughtReference ($backTrace);
}}

if (!function_exists ('validates')){
/**
 * @function validates
 * Base global function for the
 * Sami\Base model helper.
 * -
 * This is (in the ils environment)
 * an instance of the php module,
 * wich should contain the module
 * core functionalities that should
 * be extended.
 * -
 * For extending the module, just create
 * an 'exts' directory in the module directory
 * and boot it by using the ils directory boot.
 * -
 *
 * -
 * @param array $args
 * list of sent arguments to the
 * current SamiBase Helper function.
 */
function validates ($args) {
  $backTrace = debug_backtrace ();
  # Complete Trace
  # A boolean value indicating if
  # the function back trace is
  # complete (is the reference is the
  # expected for using a SamiBase helper).
  $CompleteTrace = ( boolean ) (
    # Make sure the current back trace
    # contains a fisrt position and it
    # is not a null or a not array value.
    isset ($backTrace [0]) &&
    # Make sure the current back trace
    # contains a second position and it
    # is not a null or a not array value.
    isset ($backTrace [1]) &&
    # Make sure the fisrt position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [0]) &&
    # Make sure the second position is not
    # another value type beyond of array,
    # and then, verify if the same as the
    # expected property name.
    is_array ($backTrace [1]) &&
    # Verify is the 'function' property is
    # inside the array at the 0 position.
    isset ($backTrace [0]['function']) &&
    # Verify is the 'class' property is
    # inside the array at the 1 position.
    isset ($backTrace [1]['class'])
  );
  # Make sure the reference class in the
  # stack trace is an instance or child class
  # os the SamiBase Core Class in order using
  # the current helper on it;
  # Application will stop and throw an error
  # in negative case.
  # ---
  # THE CURRENT HELPER FUNCTION IS ONLY AVAILABLE
  # FOR USING INSIDE SAMI BASE MODELS; AND SHOULD
  # NOT BE USED OUT OF THEM.
  # ---
  if ($CompleteTrace && in_array (SamiBase::class, class_parents($backTrace [1]['class']))) {
    $calledFunction = snake2camelcase ($backTrace [0]['function']);
    $referenceClass = $backTrace [1]['class'];
    # Verify if the called function is already declared
    # in the referenceClass in order call it statically.
    # ---
    # NOTE: THE METHOD WITH THE SAME NAME AS THE CURRENT
    # HELPRE INSIDE THE SAMIBASE CLASS SHOULD NOT BE CALLED
    # OUT OF A CHILD CLASS OR SOME OF THE SAMI BASE HELPERS
    # ---
    # Make sure a method names as the current helper is declared
    # in the Helper class.
    if (method_exists ($referenceClass, $calledFunction)) {
      # Make a static call to the called method inside
      # the refernce class sending the received arguments
      # on its scope and return the result to the helper
      # called scope.
      return forward_static_call_array (
        # Statc Method Reference
        [$referenceClass, $calledFunction], (
          # A list of whole the received
          # arguments to the current helper
          # function scope.
          func_get_args ()
        )
      );
    }
  }

  SamiBase::UnCoughtReference ($backTrace);
}}
