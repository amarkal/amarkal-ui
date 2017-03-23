<?php

namespace Amarkal\UI;

abstract class AbstractController
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
        $this->set_model( $model );
    }
    
    /**
     * Get model argument value by name.
     * 
     * @param string $name The argument's name.
     * 
     * @return mixed the argument's value.
     */
    public function __get( $name ) 
    {
        if( isset( $this->model[$name] ) )
        {
            return $this->model[$name];
        }
    }
    
    /**
     * Set model argument by name.
     * 
     * @param string $name The argument's name.
     * @param mixed $value The value to set.
     * 
     * @return mixed the settings' argument value.
     */
    public function __set( $name, $value )
    {
        $this->model[$name] = $value;
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
     * Set the model data for this component.
     * 
     * @return array
     */
    public function set_model( $model )
    {
        $this->model = $model;
    }
    
    /**
     * Get the full path to the template file.
     * 
     * @return string The full path.
     */
    abstract function get_template_path();
    
    /**
     * Render the template with the local properties.
     * 
     * @return string The rendered template.
     * @throws TemplateNotFoundException Thrown if the template file cannot be found.
     */
    public function render( $echo = false ){
        
        $rendered_html = '';
        
        if( file_exists( $this->get_template_path() ) ) 
        {
            ob_start();
            include( $this->get_template_path() );
            $rendered_html = ob_get_clean();
        } 
        else 
        {
            throw new \RuntimeException( "Error: cannot render HTML, template file not found at " . $this->get_template_path() );
        }
        
        if( !$echo )
        {
            return $rendered_html;
        }
        echo $rendered_html;
    }
}