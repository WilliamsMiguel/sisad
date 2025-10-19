<?php
require_once '../AD/ad.php';
 
function obtener_personas_disponibles()
{
    return obtener_personas_sin_usuario();
    //return listar_personas();
}
?>