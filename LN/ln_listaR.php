<?php
// LN/ln_listaR.php

require_once '../AD/ad.php'; // Incluye las funciones de acceso a datos

// Función para listar áreas
function obtener_areas() 
{
    return listar_areas();
}

// Función para listar dependencias
function obtener_dependencias() 
{
    return listar_dependencias();
}

// Función para listar bienes
function obtener_bienes() 
{
    return listar_bienes();
}

// Función para listar personas
function obtener_personas() 
{
    return listar_personas();
}

// Función para listar menús
function obtener_menuss() 
{
    return listar_menuss();
}

function obtener_nombre_bien() {
    return listar_nombre_bien();
}


?>
