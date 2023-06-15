<?php
define('INDEX_FILE_LOCATION', __FILE__);
$application = require('formulario.php');

// Serve the request
$application->execute();