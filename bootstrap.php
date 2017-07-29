<?php
/**
 * This file is used to manually include all required PHP files. If you are 
 * using composer as your dependency manager, you do not need to include this 
 * file as composer will include all neccessary files automatically.
 */

// Prevent direct file access
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Load module functions. If this amarkal module has not been loaded, 
 * functions.php will not return false.
 */
if(false !== (require_once 'functions.php'))
{
    // Load required classes if not using composer
    require_once 'AbstractComponent.php';
    require_once 'ComponentFactory.php';
    require_once 'ComponentList.php';
    require_once 'DisableableComponentInterface.php';
    require_once 'FilterableComponentInterface.php';
    require_once 'Form.php';
    require_once 'Template.php';
    require_once 'ValidatableComponentInterface.php';
    require_once 'ValueComponentInterface.php';
}