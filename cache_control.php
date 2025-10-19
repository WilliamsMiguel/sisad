<?php
/**
 * Sistema Central de Control de Caché - Versión Simple
 */

// Headers anti-caché
header("Cache-Control: no-cache, no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

// Versión de la aplicación
define('APP_VERSION', '1.0.7');

// Meta tags HTML
function cache_meta_tags() {
    return '
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    ';
}

// Detector de versión
function cache_version_checker() {
    return "
    <script>
        const currentVersion = '" . APP_VERSION . "';
        const storedVersion = localStorage.getItem('app_version');
        
        if (storedVersion && storedVersion !== currentVersion) {
            console.log('Nueva versión detectada');
            localStorage.clear();
            sessionStorage.clear();
            window.location.reload(true); // Recarga forzada
        }
        
        localStorage.setItem('app_version', currentVersion);
    </script>
    ";
}
?>
