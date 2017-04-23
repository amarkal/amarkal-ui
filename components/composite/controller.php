<?php

namespace Amarkal\UI;

/**
 * Implements a Composite UI component.
 */
class Component_composite
extends AbstractComponent
implements ValueComponentInterface, 
           DisableableComponentInterface,
           FilterableComponentInterface,
           ValidatableComponentInterface
{
    /**
     * The list of child components.
     * 
     * @var UI\AbstractComponent[] 
     */
    private $components;
    
    public $component_type = 'composite';
    
    /**
     * The __set magic method is overridden here to apply value changes to 
     * child components.
     */
    public function __set( $name, $value )
    {
        parent::__set($name, $value);
        
        if( 'value' === $name )
        {
            $this->set_value($value);
        }
    }
    
    /**
     * Apply the value to each of the child components.
     * 
     * @param array $value
     */
    public function set_value( array $value )
    {
        foreach($value as $n => $v)
        {
            $component = $this->get_component($n);
            $component->value = $v;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function default_model() 
    {
        return array(
            'name'          => '',
            'parent_name'   => '',
            'id'            => '',
            'disabled'      => false,
            'template'      => null,
            'components'    => array(),
            'filter'        => null,
            'validation'    => null
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function required_arguments()
    {
        return array('name','components','template');
    }
    
    /**
     * {@inheritdoc}
     */
    public function get_template_path() 
    {
        return __DIR__.'/template.phtml';
    }
    
    /**
     * Parse the template by converting the name tokens into UI components.
     * 
     * @return string The parsed template
     */
    public function parse_template()
    {
        return preg_replace_callback('/\{\{([a-zA-Z\d-_]+)\}\}/', function($a){
            $component = $this->get_component($a[1]);
            return $component->render();
        }, $this->model['template']);
    }
    
    /**
     * If this is the root composite component, this will return the component's 
     * name. If this is a child composite component, this will return the
     * component's name as a key in the parent's array, i.e 'parent_name[child_name]'
     * 
     * @return string
     */
    public function get_name()
    {
        if('' !== $this->parent_name)
        {
            return "{$this->parent_name}[{$this->name}]";
        }
        return $this->name;
    }
    
    /**
     * Instantiate child UI components when created.
     */
    protected function on_created()
    {
        foreach( $this->model['components'] as $args )
        {
            $this->components[$args['name']] = $this->create_component($args);
        }
    }
    
    /**
     * 
     * @param type $args
     * @return type
     */
    private function create_component( $args )
    {
        $type = $args['type'];
        
        if('composite' === $type)
        {
            $args['parent_name'] = $this->get_name();
        }
        
        $c = \Amarkal\UI\ComponentFactory::create( $type, $args );
        
        // Apply the composite name template
        $c->name_template = str_replace('{{parent_name}}', $this->get_name(), $c->composite_name_template);
        
        return $c;
    }
    
    /**
     * Get a child component by name.
     * 
     * @param string $name
     * @return UI\AbstractComponent
     * @throws \RuntimeException If there's no child component corresponding to the given name
     */
    private function get_component( $name )
    {
        if(!array_key_exists($name, $this->components))
        {
            throw new \RuntimeException("Composite sub-component not found with name $name");
        }
        return $this->components[$name];
    }
}