<?php

namespace Core;

class Controller
{
    // Method untuk load view
    public function view($view, $data = [])
    {
        // Ekstrak array $data menjadi variabel biasa
        extract($data);

        $viewPath = __DIR__ . '/../src/Views/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View {$view} tidak ditemukan.");
        }
    }

    // Method untuk load model
    public function model($model)
    {
        $modelClass = 'App\\Models\\' . $model;
        return new $modelClass();
    }
}
