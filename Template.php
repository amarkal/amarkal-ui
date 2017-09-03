<?php

namespace Amarkal\UI;

/**
 * Templates are a combination of markup and logic. Use templates to maintain
 * separation of concepts.
 */
class Template
{
    /**
     * An associative array holding the model to be used by this controller
     * @var array 
     */
    protected $model;
    
    /**
     * @var string The path to the template file
     */
    protected $template;

    /**
     * Constructor
     * 
     * @param array $model
     * @param string $template_path
     */
    public function __construct( array $model = array(), $template_path = null ) 
    {
        $this->set_model( $model );
        $this->template = $template_path;
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
     * Check if a model argument exists
     *
     * @param string $name The argument's name.
     * @return boolean Whether this arguments exists or not.
     */
    public function __isset( $name )
    {
        return isset($this->model[$name]);
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
    public function get_template_path()
    {
        return $this->template;
    }
    
    /**
     * Render the template with the local properties.
     * 
     * @return string The rendered template.
     * @throws TemplateNotFoundException Thrown if the template file cannot be found.
     */
    public function render( $echo = false )
    {
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