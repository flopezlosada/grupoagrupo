<?php

/**
 * Enable the jQuery.validate plugin validation for the given {@param $form}
 *
 * @param sfForm $form [the sfForm object]
 * @param String $formId [the DOM Id of the rendered form]
 * @param String  $jQueryValidatePlugin [the script name of the jquery.validate plugin]
 */
function jquery_validate_form(sfForm $form, $formId, $jQueryValidatePlugin = 'jquery.validate.min.js') {
  sfContext::getInstance()->getConfiguration()->loadHelpers(array('Asset', 'JavascriptBase'));

  if ($jQueryValidatePlugin) {
		use_javascript($jQueryValidatePlugin);
  }

  _jquery_validate_form_extend_form_fields($form->getValidatorSchema()->getFields(), $form->getWidgetSchema()->getFields());
  return javascript_tag("var {$form->getName()}Validator = jQuery('#$formId').validate();");
}

/**
 * Internal helper-helper that adds css and title meta information to the form fields.
 * This information is used by jQuery.validate to build up the validation rules and error messages
 *
 * @param array $validators
 * @param array $widgets
 */
function _jquery_validate_form_extend_form_fields(array $validators, array $widgets)
{
  foreach ($validators as $fieldName => $validator) {      
  	$widget = $widgets[$fieldName];
  	//if ($validator instanceof sfValidatorSchema || $validator instanceof sfWidgetFormSchemaDecorator) {
  	if (($validator instanceof sfValidatorSchema || $validator instanceof sfWidgetFormSchemaDecorator)&& (!$widget instanceof sfWidgetFormDoctrineChoice)) {
  		_jquery_validate_form_extend_form_fields($validator->getFields(), $widget->getFields());
  	}
  	else {
  		$options = $validator->getOptions();
  		$messages = $validator->getMessages();
  		$class = $widget->getAttribute('class');
  		$title = $widget->getAttribute('title');
  		if ($options['required']) {
  			$class .= ' required';
  			$title .= $messages['required'];
  		}

  		switch (get_class($validator)) {
  			case 'sfValidatorEmail':
  			  $class .= ' email';
  			  break;
  		}

  		$widget->setAttribute('class', $class);
  		$widget->setAttribute('title', $title);

  	}
  }

}
