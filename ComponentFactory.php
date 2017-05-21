<?php

namespace Amarkal\UI;

/**
 * Implements a factory for UI component objects. Can be used to register and 
 * create components.
 */
class ComponentFactory
{   
    /**
     * @var array A list of user-registered custom components
     */
    private static $registered_components = array();
    
    /**
     * Create a UI component instance.
     * 
     * @param string $type
     * @param array $props
     * @return AbstractComponent
     */
    public static function create( $type, array $props )
    {
        try {
            $component = self::create_registered_component($type, $props);
        } catch (\RuntimeException $ex) {
            $component = self::create_core_component($type, $props);
        }
        
        return $component;
    }
    
    /**
     * Register a custom component class. If the given component name is similar
     * to the name of one of the core components, it will override it. If a 
     * custom component with a similar name has already been registered, an 
     * exception will be thrown.
     * 
     * @param string $type
     * @param string $class_name
     * @throws \RuntimeException
     */
    public static function register( $type, $class_name )
    {
        if( !in_array($type, self::$registered_components) )
        {
            self::$registered_components[$type] = $class_name;
        }
        else throw new \RuntimeException("A component of type '$type' has already been registered.");
    }
    
    /**
     * 
     * @param type $type
     * @param type $props
     * @throws \RuntimeException
     */
    private static function create_core_component( $type, $props )
    {
        $file_name  = __DIR__."/components/$type/controller.php";
        $class_name = 'Amarkal\\UI\\Component_'.$type;
        
        // Load one of the core components
        if(!class_exists($class_name))
        {
            if( file_exists( $file_name ) ) 
            {
                require_once $file_name;
            }
            else 
            {
                throw new \RuntimeException("A component of type '$type' does not exist.");
            }
        }
        
        return new $class_name($props);
    }
    
    /**
     * 
     * @param type $type
     * @param type $props
     * @throws \RuntimeException
     */
    private static function create_registered_component( $type, $props )
    {
        if(in_array($type, self::$registered_components))
        {
            $class_name = self::$registered_components[$type];
            return new $class_name($props);
        }
        
        throw new \RuntimeException("A component of type '$type' has not been registered.");
    }
    
    /**
     * Private constructor to prevent instantiation
     */
    private function __construct() {}
}