<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormInput represents an HTML text input tag.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormInputText.class.php 20941 2009-08-08 14:11:51Z Kris.Wallsmith $
 */
class sfWidgetFormInputTextObject extends sfWidgetFormInputText
{
    /**
     * @param array $options     An array of options
     * @param array $attributes  An array of default HTML attributes
     *
     * @see sfWidgetForm
     */
    protected function configure($options = array(), $attributes = array())
    {
        parent::configure($options, $attributes);
        $this->addRequiredOption('model');
    }

    /**
     * @param  string $name        The element name
     * @param  string $value       The value displayed in this widget
     * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
     * @param  array  $errors      An array of errors for the field
     *
     * @return string An HTML tag string
     *
     * @see sfWidgetForm
     */
    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        if ($value){
        $object=Doctrine::getTable($this->getOption('model'))->findOneById($value);
        return $object->name.$this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' => $value, "style"=>"display:none"), $attributes));
        } else {
            return $this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'readonly'=>'readonly','name' => $name), $attributes));
        }
    }
}
