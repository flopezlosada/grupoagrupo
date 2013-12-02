<?php
/*
 © Copyright 2012 diphda.net && Sodepaz
 info@diphda.net


 Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia
 Pública General de GNU según es publicada por la Free Software Foundation, bien de la versión 3 de dicha
 Licencia o bien (según su elección) de cualquier versión posterior.

 Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin l
 garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la
 Licencia Pública General de GNU para más detalles.

 Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así,
 escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, MA 02139, EEUU.

 La licencia se encuentra en el archivo licencia.txt*/

/**
 *
 * @author paco
 * Representa un campo fecha que no se puede modificar
 */
class sfWidgetFormInputDate extends sfWidgetFormInputText
{
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
        sfApplicationConfiguration::getActive()->loadHelpers(array('Date'));
        $value_format=format_datetime($value,"P",sfContext::getInstance()->getUser()->getCulture(),"utf-8");
        return '<span>'.$value_format.'</span>'.$this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' => $value, "style"=>"display:none"), $attributes));;
    }
}

