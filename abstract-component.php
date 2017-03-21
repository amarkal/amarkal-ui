<?php

namespace Amarkal\UI;

/**
 * Defines an abstract UI component
 */
abstract class AbstractComponent
{
    /**
     * An associative array holding the model to be used by this controller
     * @var array 
     */
    protected $model;
    
    /**
     * Constructor
     * 
     * @param array $model
     */
    public function __construct( array $model = array() ) 
    {
        // Check that the required parameters are provided.
        foreach( $this->required_parameters() as $key )
        {
            if ( !isset($model[$key]) )
            {
                throw new \RuntimeException('The required parameter "'.$key.'" was not provided for '.get_called_class());
            }
        }
        
        $this->model = array_merge( $this->default_model(), $model );
        
        $this->on_created();
    }
    
    /**
     * Get model parameter value by name.
     * 
     * @param string $name The parameter's name.
     * 
     * @return mixed the parameter's value.
     */
    public function __get( $name ) 
    {
        if( isset( $this->model[$name] ) )
        {
            return $this->model[$name];
        }
    }
    
    /**
     * Set model parameter by name.
     * 
     * @param string $name The parameter's name.
     * @param mixed $value The value to set.
     * 
     * @return mixed the settings' parameter value.
     */
    public function __set( $name, $value )
    {
        $this->model[$name] = $value;
    }
    
    /**
     * Render the template with the local properties.
     * 
     * @return string                        The rendered template.
     * @throws TemplateNotFoundException    Thrown if the template file can 
     *                                        not found.
     */
    public function render( $echo = false ){
        
        $rendered_html = '';
        
        if( file_exists( $this->get_script_path() ) ) 
        {
            ob_start();
            include( $this->get_script_path() );
            $rendered_html = ob_get_clean();
        } 
        else 
        {
            throw new \RuntimeException( "Error: cannot render HTML, template file not found at " . $this->get_script_path() );
        }
        
        if( !$echo )
        {
            return $rendered_html;
        }
        echo $rendered_html;
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
     * Get the current component model data.
     * 
     * @return array
     */
    public function get_model()
    {
        return $this->model;
    }
    
    /**
     * The list of required model parameters.
     * This method should be overriden by child class to specify required model
     * parameters.
     * 
     * @return array
     */
    public function required_parameters()
    {
        return array();
    }
    
    /**
     * A hook that is called once the component has been created.
     */
    protected function on_created() {}
    
    /**
     * Get the full path to the template file.
     * 
     * @return string The full path.
     */
    abstract function get_script_path();
}