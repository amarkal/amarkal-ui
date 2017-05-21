<?php

namespace Amarkal\UI;

/**
 * Describes a component with a validatable value.
 * 
 * This interface is applicable for component that allow free user input,
 * such as textfields and textareas.
 * 
 * A validatable component must have a validation function as part of its default
 * model. If a validation function is not provided as an argument when during 
 * instantiation, the validation process will be skipped.
 */
interface ValidatableComponentInterface 
extends ValueComponentInterface 
{
    /**
     * Component state after validation.
     * @see self::set_validity()
     */
    const INVALID   = 'invalid';
    const VALID     = 'valid';
    
    const DEFAULT_MESSAGE = 'The value given is invalid';
}