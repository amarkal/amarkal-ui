<?php

namespace Amarkal\UI;

/**
 * Implements a data structure consisting of a list of UI components
 */
class ComponentList
{
    /**
     * The list of component argument arrays
     *
     * @var array
     */
    private $components = array();

    /**
     * Set the components
     *
     * @param array $components
     */
    public function __construct( array $components = array() )
    {
        $this->add_components($components);
    }

    /**
     * Get a component by name. Only applicable to value components.
     *
     * @param string $name
     * @return AbstractComponent
     */
    public function get_by_name( $name )
    {
        $filtered = $this->filter(function($c) use ($name) {
            return $c instanceof ValueComponentInterface && $c->name === $name;
        });
        if(count($filtered) < 1)
        {
            throw new \RuntimeException("No component with the name <b>$name</b> could be found.");
        }
        return $filtered[0];
    }

    /**
     * Get components by type
     *
     * @param string $type
     * @return AbstractComponent[]
     */
    public function get_by_type( $type )
    {
        return $this->filter(function($c) use ($type) {
            return $c->component_type === $type;
        });
    }

    /**
     * Get all components.
     *
     * @return AbstractComponent[]
     */
    public function get_all()
    {
        return $this->components;
    }

    /**
     * Get all the components that implement the ValueComponentInterface
     *
     * @return AbstractComponent[]
     */
    public function get_value_components()
    {
        return $this->filter(function($c) {
            return $c instanceof ValueComponentInterface;
        });
    }

    /**
     * Get all the components that implement the FilterableComponentInterface
     *
     * @return AbstractComponent[]
     */
    public function get_filterable_components()
    {
        return $this->filter(function($c) {
            return $c instanceof FilterableComponentInterface;
        });
    }

    /**
     * Get all the components that implement the ValidatableComponentInterface
     *
     * @return AbstractComponent[]
     */
    public function get_validatable_components()
    {
        return $this->filter(function($c) {
            return $c instanceof ValidatableComponentInterface;
        });
    }

    /**
     * Add an array of components to the list
     *
     * @param AbstractComponent[] $components
     * @return void
     */
    public function add_components( array $components )
    {
        foreach( $components as $component )
        {
            $this->add_component($component);
        }
    }

    /**
     * Add a single component to the list
     *
     * @param AbstractComponent[] $args
     * @return void
     */
    public function add_component( array $args )
    {
        if(!array_key_exists('type', $args))
        {
            throw new \RuntimeException("Component configuration arrays must have a <b>type</b> argument");
        }

        $comp = ComponentFactory::create($args['type'], $args);

        $this->verify_name_uniqueness($comp);
        $this->components[] = $comp;
    }

    /**
     * Verify that the given component name is unique among the list of value components
     *
     * @param AbstractComponent $comp
     * @return void
     */
    private function verify_name_uniqueness( AbstractComponent $comp )
    {
        if(!($comp instanceof ValueComponentInterface))
        {
            return;
        }

        foreach ($this->components as $c) 
        {
            if($c->name === $comp->name)
            {
                throw new \RuntimeException("Duplicate component name detected for the name <b>{$c->name}</b>.");
            }
        }
    }

    /**
     * Filter the list of components
     *
     * @param function $callable
     * @return array
     */
    private function filter( $callable )
    {
        // array_values is needed in order to reindex the array after filtering it
        return array_values(array_filter($this->components, $callable));
    }
}