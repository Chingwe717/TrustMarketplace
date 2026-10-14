<?php
/*
 * Base Controller
 * Loads the models and views
 */
class Controller {
    // Load model
    public function model($model) {
        require_once APPROOT . '/models/' . $model . '.php';
        return new $model();
    }

    // Load view
    public function view($view, $data = []) {
        $viewPath = APPROOT . '/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            // Friendly 404 when a view is missing instead of killing the process
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            echo '<h1>404 - View not found</h1>';
            echo '<p>The requested view <strong>' . htmlspecialchars($view) . '</strong> does not exist.</p>';
            exit;
        }
    }
}
