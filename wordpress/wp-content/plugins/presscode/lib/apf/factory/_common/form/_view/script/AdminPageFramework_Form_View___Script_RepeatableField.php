<?php 
/**
	Admin Page Framework v3.8.13 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/presscode>
	Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class Pcode_AdminPageFramework_Form_View___Script_RepeatableField extends Pcode_AdminPageFramework_Form_View___Script_Base {
    static public function getScript() {
        $_aParams = func_get_args() + array(null);
        $_oMsg = $_aParams[0];
        $sCannotAddMore = $_oMsg->get('allowed_maximum_number_of_fields');
        $sCannotRemoveMore = $_oMsg->get('allowed_minimum_number_of_fields');
        return <<<JAVASCRIPTS
(function ( $ ) {
        
    /**
     * Bind field-repeating events to repeatable buttons for individual fields.
     * @remark      This method can be called from a fields container or a cloned field container.
     */
    $.fn.updatePcode_AdminPageFrameworkRepeatableFields = function( aSettings ) {
        
        var nodeThis            = this; 
        var _sFieldsContainerID = nodeThis.find( '.repeatable-field-add-button' ).first().data( 'id' );
        
        /* Store the fields specific options in an array  */
        if ( ! $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions ) {
            $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions = [];
        }
        if ( ! $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions.hasOwnProperty( _sFieldsContainerID ) ) {     
            $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions[ _sFieldsContainerID ] = $.extend({    
                // These are the defaults.
                max: 0, 
                min: 0,
                fadein: 500,
                fadeout: 500,
                disabled: false,    // 3.8.13+
                }, aSettings );
        }
        var _aOptions = $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions[ _sFieldsContainerID ];

        /* Set the option values in the data attributes so that when a section is repeated and creates a brand new field container, it can refer to the options */
// @todo For nested fields, the `find()` method should be avoided.
        $( nodeThis ).find( '.presscode-repeatable-field-buttons' ).attr( 'data-max', _aOptions[ 'max' ] );
        $( nodeThis ).find( '.presscode-repeatable-field-buttons' ).attr( 'data-min', _aOptions[ 'min' ] );
        $( nodeThis ).find( '.presscode-repeatable-field-buttons' ).attr( 'data-fadein', _aOptions[ 'fadein' ] );
        $( nodeThis ).find( '.presscode-repeatable-field-buttons' ).attr( 'data-fadeout', _aOptions[ 'fadeout' ] );
        
        /* The Add button behavior - if the tag id is given, multiple buttons will be selected. 
         * Otherwise, a field node is given and a single button will be selected. */
// @todo For nested fields, the `find()` method should be avoided.         
        $( nodeThis ).find( '.repeatable-field-add-button' ).unbind( 'click' );
        $( nodeThis ).find( '.repeatable-field-add-button' ).click( function() {
        
            // 3.8.13+ 
            if ( $( this ).parent().data( 'disabled' ) ) {
                var _aDisabled = $( this ).parent().data( 'disabled' );
                tb_show( _aDisabled[ 'caption' ], $( this ).attr( 'href' ) );    
                return false;
            }        
        
            $( this ).addPcode_AdminPageFrameworkRepeatableField();
            return false; // will not click after that
        });

        /* The Remove button behavior */
// @todo For nested fields, the `find()` method should be avoided.        
        $( nodeThis ).find( '.repeatable-field-remove-button' ).unbind( 'click' );
        $( nodeThis ).find( '.repeatable-field-remove-button' ).click( function() {
            $( this ).removePcode_AdminPageFrameworkRepeatableField();
            return false; // will not click after that
        });

        /* If the number of fields is less than the set minimum value, add fields. */
        var _sFieldID           = nodeThis.find( '.repeatable-field-add-button' ).first().closest( '.presscode-field' ).attr( 'id' );
        var _nCurrentFieldCount = jQuery( '#' + _sFieldsContainerID ).find( '.presscode-field' ).length;
        if ( _aOptions[ 'min' ] > 0 && _nCurrentFieldCount > 0 ) {
            if ( ( _aOptions[ 'min' ] - _nCurrentFieldCount ) > 0 ) {     
                $( '#' + _sFieldID ).addPcode_AdminPageFrameworkRepeatableField( _sFieldID );  
            }
        }
        
    };
    
    /**
     * Adds a repeatable field.
     * 
     * This method is called when the user presses the + repeatable button.
     */
    $.fn.addPcode_AdminPageFrameworkRepeatableField = function( sFieldContainerID ) {
        
        if ( 'undefined' === typeof sFieldContainerID ) {
            var sFieldContainerID = $( this ).closest( '.presscode-field' ).attr( 'id' );
        }

        var nodeFieldContainer  = $( '#' + sFieldContainerID );
        var nodeNewField        = nodeFieldContainer.clone(); // clone without bind events.
        var nodeFieldsContainer = nodeFieldContainer.closest( '.presscode-fields' );
        var _sFieldsContainerID = nodeFieldsContainer.attr( 'id' );

        // If the set maximum number of fields already exists, do not add.
        if ( ! $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions.hasOwnProperty( _sFieldsContainerID ) ) {     
            var nodeButtonContainer = nodeFieldContainer.find( '.presscode-repeatable-field-buttons' );
            $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions[ _sFieldsContainerID ] = {    
                max: nodeButtonContainer.attr( 'data-max' ), // These are the defaults.
                min: nodeButtonContainer.attr( 'data-min' ),
                fadein: nodeButtonContainer.attr( 'data-fadein' ),
                fadeout: nodeButtonContainer.attr( 'data-fadeout' ),
            };
        }  
       
        var _iFadein  = $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions[ _sFieldsContainerID ][ 'fadein' ];
        var _iFadeout = $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions[ _sFieldsContainerID ][ 'fadeout' ];

        // Show a warning message if the user tries to add more fields than the number of allowed fields.
        var sMaxNumberOfFields = $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions[ _sFieldsContainerID ]['max'];
        if ( sMaxNumberOfFields != 0 && nodeFieldsContainer.find( '.presscode-field' ).length >= sMaxNumberOfFields ) {
            var nodeLastRepeaterButtons = nodeFieldContainer.find( '.presscode-repeatable-field-buttons' ).last();
            var sMessage                = $( this ).formatPrintText( '{$sCannotAddMore}', sMaxNumberOfFields );
            var nodeMessage             = $( '<span class=\"repeatable-error repeatable-field-error\" id=\"repeatable-error-' + _sFieldsContainerID + '\" >' + sMessage + '</span>' );
            if ( nodeFieldsContainer.find( '#repeatable-error-' + _sFieldsContainerID ).length > 0 ) {
                nodeFieldsContainer.find( '#repeatable-error-' + _sFieldsContainerID ).replaceWith( nodeMessage );
            } else {
                nodeLastRepeaterButtons.before( nodeMessage );
            }
            nodeMessage.delay( 2000 ).fadeOut( _iFadeout );
            return;     
        }
        
        // Empty values.
        nodeNewField.find( 'input:not([type=radio], [type=checkbox], [type=submit], [type=hidden]),textarea' ).val( '' ); // empty the value     
        nodeNewField.find( 'input[type=checkbox]' ).prop( 'checked', false ); // uncheck checkboxes.
        nodeNewField.find( '.repeatable-error' ).remove(); // remove error messages.
        
        // Add the cloned new field element.
        if ( _iFadein ) {
            nodeNewField
                .hide()
                .insertAfter( nodeFieldContainer )
                .delay( 100 )
                .fadeIn( _iFadein );
        } else {            
            nodeNewField.insertAfter( nodeFieldContainer );    
        }

        // 3.6.0+ Increment name and id attributes of the newly cloned field.
        _incrementFieldAttributes( nodeNewField, nodeFieldsContainer );
               
        /** 
         * Rebind the click event to the + and - buttons - important to update AFTER inserting the clone to the document node since the update method needs to count the fields. 
         * Also do this after updating the attributes since the script needs to check the last added id for repeatable field options such as 'min'.
         */
        nodeNewField.updatePcode_AdminPageFrameworkRepeatableFields();
        
        // It seems radio buttons of the original field need to be reassigned. Otherwise, the checked items will be gone.
        nodeFieldContainer.find( 'input[type=radio][checked=checked]' ).prop( 'checked', 'checked' );
        
        // Call back the registered functions.
        
        // @deprecated 3.8.8 Kept for backward compatibility as some custom field types rely on this method.
        nodeNewField.trigger( 
            'presscode_added_repeatable_field', 
            [ 
                nodeNewField.data( 'type' ), // field type slug
                nodeNewField.attr( 'id' ),   // element tag id
                0, // call type // call type, 0 : repeatable fields, 1: repeatable sections, 2: nested repeatable fields.
                0, // section index - @todo find the section index
                0  // field index - @todo find the field index
            ]
        );
        
        // 3.8.8+ _nested and inline_mixed field types have nested fields. The above 
        $( nodeNewField ).find( '.presscode-field' ).addBack().trigger( 
            'presscode_repeated_field', 
            [ 
                0, // call type, 0 : repeatable fields, 1: repeatable sections
                jQuery( nodeNewField ).closest( '.presscode-fields' )    // model container
            ]
        );
        
        // If more than one fields are created, show the Remove button.
// @todo find() may not be appropriate for nested fields.
        var nodeRemoveButtons = nodeFieldsContainer.find( '.repeatable-field-remove-button' );
        if ( nodeRemoveButtons.length > 1 ) { 
            nodeRemoveButtons.css( 'visibility', 'visible' ); 
        }

        // Display/hide delimiters.
        nodeFieldsContainer.children( '.presscode-field' ).children( '.delimiter' ).show().last().hide();
        
        // Return the newly created element. The media uploader needs this 
        return nodeNewField; 
        
    };
    
        /**
         * Increments digits in field attributes.
         * @since       3.8.0
         */
        var _incrementFieldAttributes = function( oElement, oFieldsContainer ) {
                
            var _iFieldCount            = Number( oFieldsContainer.attr( 'data-largest_index' ) );
            var _iIncrementedFieldCount = _iFieldCount + 1;
            oFieldsContainer.attr( 'data-largest_index', _iIncrementedFieldCount );
         
            var _sFieldTagIDModel    = oFieldsContainer.attr( 'data-field_tag_id_model' );
            var _sFieldNameModel     = oFieldsContainer.attr( 'data-field_name_model' );
            var _sFieldFlatNameModel = oFieldsContainer.attr( 'data-field_name_flat_model' );
            var _sFieldAddressModel  = oFieldsContainer.attr( 'data-field_address_model' );

            oElement.incrementAttribute(
                'id', // attribute name
                _iFieldCount, // increment from
                _sFieldTagIDModel // digit model
            );
            oElement.find( 'label' ).incrementAttribute(
                'for', // attribute name
                _iFieldCount, // increment from
                _sFieldTagIDModel // digit model
            );
            oElement.find( 'input,textarea,select' ).incrementAttribute(
                'id', // attribute name
                _iFieldCount, // increment from
                _sFieldTagIDModel // digit model
            );       
            oElement.find( 'input,textarea,select' ).incrementAttribute(
                'name', // attribute name
                _iFieldCount, // increment from
                _sFieldNameModel // digit model
            );
            
            // Update the hidden input elements that contain field names for nested elements.
            oElement.find( 'input[type=hidden].element-address' ).incrementAttributes(
                [ 'name', 'value', 'data-field_address_model' ], // attribute names - these elements contain id values in the 'name' attribute.
                _iFieldCount,
                _sFieldAddressModel // digit model - this is
            );              
            
            // For checkbox, select, and radio input types
            oElement.find( 'input[type=radio][data-id],input[type=checkbox][data-id],select[data-id]' ).incrementAttribute(
                'data-id', // attribute name
                _iFieldCount, // increment from
                _sFieldTagIDModel // digit model
            );                
            
            // 3.8 For nested repeatable fields
            oElement.find( '.presscode-field,.presscode-fields,.presscode-fieldset' ).incrementAttributes(
                [ 'id', 'data-field_tag_id_model', 'data-field_id' ],
                _iFieldCount,
                _sFieldTagIDModel
            );
            oElement.find( '.presscode-fields' ).incrementAttributes(
                [ 'data-field_name_model' ],
                _iFieldCount,
                _sFieldNameModel
            );            
            oElement.find( '.presscode-fields' ).incrementAttributes(
                [ 'data-field_name_flat', 'data-field_name_flat_model' ],
                _iFieldCount,
                _sFieldFlatNameModel
            );                 
            oElement.find( '.presscode-fields' ).incrementAttributes(
                [ 'data-field_address', 'data-field_address_model' ],
                _iFieldCount,
                _sFieldAddressModel
            );            
            
        }    
        
    
    /**
     * Removes a repeatable field.
      This method is called when the user presses the - repeatable button.
     */
    $.fn.removePcode_AdminPageFrameworkRepeatableField = function() {
        
        /* Need to remove the element: the field container */
        var nodeFieldContainer  = $( this ).closest( '.presscode-field' );
        var nodeFieldsContainer = $( this ).closest( '.presscode-fields' );
        var _sFieldsContainerID = nodeFieldsContainer.attr( 'id' );
        
        /* If the set minimum number of fields already exists, do not remove */
        var sMinNumberOfFields  = $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions[ _sFieldsContainerID ][ 'min' ];
        if ( sMinNumberOfFields != 0 && nodeFieldsContainer.find( '.presscode-field' ).length <= sMinNumberOfFields ) {
            var nodeLastRepeaterButtons = nodeFieldContainer.find( '.presscode-repeatable-field-buttons' ).last();
            var sMessage                = $( this ).formatPrintText( '{$sCannotRemoveMore}', sMinNumberOfFields );
            var nodeMessage             = $( '<span class=\"repeatable-error repeatable-field-error\" id=\"repeatable-error-' + _sFieldsContainerID + '\">' + sMessage + '</span>' );
            if ( nodeFieldsContainer.find( '#repeatable-error-' + _sFieldsContainerID ).length > 0 ) {
                nodeFieldsContainer.find( '#repeatable-error-' + _sFieldsContainerID ).replaceWith( nodeMessage );
            } else {
                nodeLastRepeaterButtons.before( nodeMessage );
            }
            var _iFadeout = $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions[ _sFieldsContainerID ][ 'fadeout' ]
                ? $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions[ _sFieldsContainerID ][ 'fadeout' ]
                : 500;
            nodeMessage.delay( 2000 ).fadeOut( _iFadeout );
            return;     
        }     
        
        /* Remove the field */
        var _iFadeout = $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions[ _sFieldsContainerID ][ 'fadeout' ]
            ? $.fn.aPcode_AdminPageFrameworkRepeatableFieldsOptions[ _sFieldsContainerID ][ 'fadeout' ]
            : 500;        
        nodeFieldContainer.fadeOut( _iFadeout, function() { 
            $( this ).remove(); 
            var nodeRemoveButtons = nodeFieldsContainer.find( '.repeatable-field-remove-button' );
            if ( 1 === nodeRemoveButtons.length ) { 
                nodeRemoveButtons.css( 'visibility', 'hidden' ); 
            }            
        } );
            
    };
        
}( jQuery ));    
JAVASCRIPTS;
        
    }
}
