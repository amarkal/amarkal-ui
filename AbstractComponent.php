<?php

namespace Amarkal\UI;

/**
 * Defines an abstract UI component
 */
abstract class AbstractComponent
extends Template
{
    /**
     * This template is used to generate the name for this component. the token 
     * {{name}} will be replaced by the component's name during runtime.
     * 
     * @var string
     */
    public $name_template = '{{name}}';
    
    /**
     * This template is used to generate the name for this component when it is
     * used as a child component in a composite component. The token 
     * {{parent_name}} will be replaced with the name of the parent (composite)
     * component.
     * 
     * @var string
     */
    public $composite_name_template = '{{parent_name}}[{{name}}]';
    
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
     * Get the name for this component by parsing the name template.
     * 
     * @return type
     */
    public function get_name()
    {
        return \str_replace('{{name}}', $this->name, $this->name_template);
    }
    
    /**
     * Generate common UI component wrapper attributes
     */
    public function component_attributes()
    {
        return sprintf(
            'class="amarkal-ui-component amarkal-ui-component-%s" amarkal-component-name="%s"',
            $this->component_type,
            $this->name
        );
    }
    
    /**
     * Enqueue component's script and render it.
     * 
     * {@inheritdoc}
     */
    public function render( $echo = false )
    {
        $this->enqueue_scripts();
        return parent::render($echo);
    }
    
    /**
     * Enqueue styles/scripts required for this element.
     */
    public function enqueue_scripts()
    {
        \wp_enqueue_script('amarkal-ui');
        \wp_enqueue_style('amarkal-ui');
    }
    
    /**
     * A hook that is called once the component has been created.
     */
    protected function on_created() {}
}