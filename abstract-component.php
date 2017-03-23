<?php

namespace Amarkal\UI;

/**
 * Defines an abstract UI component
 */
abstract class AbstractComponent
extends AbstractController
{
    /**
     * Constructor
     * 
     * @param array $model
     */
    public function __construct( array $model = array() ) 
    {
        parent::__construct($model);
        $this->on_created();
    }
    
    /**
     * The default model to use when none is provided to the constructor.
     * This method should be overriden by child class to define the default
     * model.
     * 
     * @return array
     */
    public function default_model()
    {
        return array();
    }
    
    /**
     * The list of required model arguments.
     * This method should be overriden by child class to specify required model
     * arguments.
     * 
     * @return array
     */
    public function required_arguments()
    {
        return array();
    }
    
    /**
     * Set the model data for this component.
     * 
     * @return array
     */
    public function set_model( $model )
    {
        // Check that the required arguments are provided.
        foreach( $this->required_arguments() as $key )
        {
            if ( !isset($model[$key]) )
            {
                throw new \RuntimeException('The required argument "'.$key.'" was not provided for '.get_called_class());
            }
        }
        
        // Assign the name of the component as the id if no id was specified
        if( !isset($model['id']) )
        {
            $model['id'] = $model['name'];
        }
        
        $this->model = array_merge( $this->default_model(), $model );
    }
    
    /**
     * A hook that is called once the component has been created.
     */
    protected function on_created() {}
}