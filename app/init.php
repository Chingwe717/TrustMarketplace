<?php
// App Root should point to the application folder itself, not the project root.
define('APPROOT', __DIR__);

require_once 'helpers/session_helper.php';
require_once 'config/config.php';
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Database.php';
