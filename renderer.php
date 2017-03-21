<?php

namespace Amarkal\UI;

class Renderer
{
    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    private static $instance;
    
    private $registered_components = array();

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function get_instance()
    {
        if( null === static::$instance ) 
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function render_component( $type, array $props = array() )
    {
        $component = $this->create_component( $type, $props );
        return $component->render();
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
    public function register_component( $type, $class_name )
    {
        if( !in_array($type, $this->registered_components) )
        {
            $this->registered_components[$type] = $class_name;
        }
        else throw new \RuntimeException("A component with a name of '$type' has already been registered.");
    }
    
    /**
     * 
     * @param type $type
     * @param type $props
     * @return type
     */
    private function create_component( $type, $props )
    {
        try {
            $component = $this->create_registered_component ($type, $props );
        } catch (\RuntimeException $ex) {
            $component = $this->create_core_component ($type, $props );
        }
        
        return $component;
    }
    
    /**
     * 
     * @param type $type
     * @param type $props
     * @throws \RuntimeException
     */
    private function create_core_component( $type, $props )
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
                throw new \RuntimeException("The component '$type' does not exist.");
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
    private function create_registered_component( $type, $props )
    {
        if(in_array($type, $this->registered_components))
        {
            $class_name = $this->registered_components[$type];
            return new $class_name($props);
        }
        
        throw new \RuntimeException("The component '$type' has not been registered.");
    }
}