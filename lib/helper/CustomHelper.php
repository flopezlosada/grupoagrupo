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

/**
 * Reemplaza todos los acentos por sus equivalentes sin ellos
 *
 * @param $string
 *  string la cadena a sanear
 *
 * @return $string
 *  string saneada
 */
function cleanString($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "<", ";", ",", ":",
             ".", " "),
        '',
        $string
    );
 
 
    return $string;
}
