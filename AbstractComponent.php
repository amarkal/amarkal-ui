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
     * A list of HTML classes to be added to the wrapper div of this component.
     *
     * @var array
     */
    public $html_classes = array();
    
    /**
     * Constructor
     * 
     * @param array $model
     */
    public function __construct( array $model = array() ) 
    {
        parent::__construct($model);
        
        $this->add_html_class(sprintf(
            'amarkal-ui-component amarkal-ui-component-%s',
            $this->component_type
        ));

        if($this instanceof DisableableComponentInterface && $this->disabled)
        {
            $this->add_html_class('amarkal-ui-disabled');
        }
        
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
        if( !isset($model['id']) && isset($model['name']) )
        {
            $model['id'] = $model['name'];
        }

        // A name must be specified when a component has a visibility condition
        if( isset($model['show']) && !isset($model['name']) )
        {
            throw new \RuntimeException('Components with a visibility condition (a "show" argument) must have a name');
        }
        
        $this->model = array_merge( $this->default_model(), $model );
    }
    
    /**
     * Get the name for this component by parsing the name template.
     * 
     * @return string
     */
    public function get_name()
    {
        return \str_replace('{{name}}', $this->name, $this->name_template);
    }
    
    /**
     * Add an HTML class to the list of HTML classes to be printed when the
     * component is rendered. 
     * 
     * @param string $class
     */
    public function add_html_class( $class )
    {
        if( !in_array($class, $this->html_classes) )
        {
            $this->html_classes[] = $class;
        }
    }
    
    /**
     * Remove an HTML class to the list of HTML classes to be printed when the
     * component is rendered. 
     * 
     * @param string $class
     */
    public function remove_html_class( $class )
    {
        $i = 0;
        foreach( $this->html_classes as $c )
        {
            if( $c === $class )
            {
                array_splice($this->html_classes,$i,1);
                break;
            }
            $i++;
        }
    }
    
    /**
     * Set the validity of this component if it supports validation.
     * 
     * @param type $validity
     */
    Public function set_validity( $validity )
    {
        $this->validity = $validity;
        if($validity === $this::INVALID)
        {
            $this->add_html_class('amarkal-ui-component-error');
        }
    }
    
    /**
     * Generate common UI component wrapper attributes
     */
    public function component_attributes()
    {
        return sprintf(
            'class="%s" amarkal-component-name="%s"',
            implode(' ', $this->html_classes),
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
        
        ob_start();
        include dirname(__FILE__).'/AbstractComponent.phtml';
        $html = ob_get_clean();

        if( !$echo )
        {
            return $html;
        }
        echo $html;
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