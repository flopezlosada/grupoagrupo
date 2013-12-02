<?php
/*
© Copyright 2012 diphda.net && Sodepaz
info@diphda.net


Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia
Pública General de GNU según es publicada por la Free Software Foundation, bien de la versión 3 de dicha
Licencia o bien (según su elección) de cualquier versión posterior.

Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin la
garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la
Licencia Pública General de GNU para más detalles.

Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así,
escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, MA 02139, EEUU.

La licencia se encuentra en el archivo licencia.txt*/

function deleteRightZero($int)
{
  return preg_replace("/\\.?0*$/", "", $int);  
}

function getMonth($id)
{
    $months=sfConfig::get("app_month_list");
    
    return $months[$id];
}

function zerofill($entero, $largo){
    // Limpiamos por si se encontraran errores de tipo en las variables
    $entero = (int)$entero;
    $largo = (int)$largo;
     
    $relleno = '';
     
    /**
     * Determinamos la cantidad de caracteres utilizados por $entero
     * Si este valor es mayor o igual que $largo, devolvemos el $entero
     * De lo contrario, rellenamos con ceros a la izquierda del número
     **/
    if (strlen($entero) < $largo) {
        $relleno = str_repeat('0', $largo - strlen($entero));
    }
    return $relleno . $entero;
}