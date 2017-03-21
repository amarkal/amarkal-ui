<?php
/**
 * WordPress UI
 *
 * A set of HTML UI components for WordPress.
 * This is a component within the Amarkal framework.
 *
 * @package   amarkal-ui
 * @author    Askupa Software <hello@askupasoftware.com>
 * @link      https://github.com/askupasoftware/amarkal-ui
 * @copyright 2017 Askupa Software
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Prevent loading the library more than once
 */
if( defined( 'AMARKAL_UI' ) ) return;
define( 'AMARKAL_UI', true );

/**
 * Load required classes
 */
require_once 'renderer.php';
require_once 'abstract-component.php';

if(!function_exists('amarkal_ui_render'))
{
    /**
     * Render a UI component.
     * 
     * @param string $type The component's type - one of the core component types,
     * or a registered custom component.
     * @param array $props The component's properties
     * @return string The rendered HTML
     */
    function amarkal_ui_render( $type, array $props = array() )
    {
        $renderer = Amarkal\UI\Renderer::get_instance();
        return $renderer->render_component( $type, $props );
    }
}

if(!function_exists('amarkal_ui_register_component'))
{
    /**
     * Register a custom UI component. The registered component's class should
     * inherit from Amarkal\UI\AbstractComponent.
     * 
     * @param string $type The component's type. If the custom type is similar 
     * to one of the core component's type, it will override the core component.
     * @param string $class_name The component's class name.
     */
    function amarkal_ui_register_component( $type, $class_name )
    {
        $renderer = Amarkal\UI\Renderer::get_instance();
        $renderer->register_component( $type, $class_name );
    }
}