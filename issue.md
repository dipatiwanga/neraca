# Struktur Project PHP MVC Sederhana - Sistem Akuntansi Koperasi

## Spesifikasi
- **Bahasa:** PHP Native
- **Arsitektur:** MVC (Model View Controller)
- **Autoload:** Composer autoload (PSR-4)
- **Framework:** Tanpa framework (Vanilla PHP)

## Struktur Folder

```text
/
├── core/                   # Core system (Router, Database, Base Controller)
│   ├── Controller.php      # Base Controller untuk load model & view
│   ├── Database.php        # Wrapper PDO database
│   └── Router.php          # Class Router sederhana
├── public/                 # Document root yang bisa diakses web server
│   └── index.php           # Front controller / Entry point aplikasi
├── src/                    # Source code aplikasi (MVC)
│   ├── Controllers/        # Controller spesifik aplikasi
│   │   └── HomeController.php
│   ├── Models/             # Model spesifik aplikasi (representasi tabel)
│   │   └── Akun.php
│   └── Views/              # Tampilan aplikasi
│       └── home.php
├── composer.json           # Konfigurasi autoload composer
└── .htaccess               # Konfigurasi rewrite url untuk apache (Opsional)
```

## Contoh File Minimal

### 1. `composer.json`
Konfigurasi autoload menggunakan standar PSR-4.
```json
{
    "name": "koperasi/akuntansi",
    "description": "Sistem Akuntansi Koperasi",
    "autoload": {
        "psr-4": {
            "Core\\": "core/",
            "App\\": "src/"
        }
    }
}
```
> **Catatan:** Jalankan `composer dump-autoload` di terminal setelah membuat file ini untuk menggenerate autoload.

### 2. `public/index.php`
File pertama yang dieksekusi saat aplikasi diakses.
```php
<?php

// Load autoloader dari composer
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;

// Inisialisasi router
$router = new Router();

// Daftarkan rute-rute aplikasi
$router->add('/', 'App\Controllers\HomeController@index');
$router->add('/akun', 'App\Controllers\AkunController@index');

// Jalankan routing berdasarkan URL
$router->dispatch($_SERVER['REQUEST_URI']);
```

### 3. `core/Router.php`
Class sederhana untuk memetakan URL ke Controller dan Method.
```php
<?php

namespace Core;

class Router
{
    protected $routes = [];

    public function add($route, $action)
    {
        $this->routes[$route] = $action;
    }

    public function dispatch($url)
    {
        // Hilangkan query string dari URL (misal: ?id=1)
        $url = parse_url($url, PHP_URL_PATH);
        
        // Sesuaikan jika basepath project bukan root
        // $url = str_replace('/neraca/public', '', $url);

        if (array_key_exists($url, $this->routes)) {
            $action = $this->routes[$url];
            list($controller, $method) = explode('@', $action);

            if (class_exists($controller)) {
                $controllerInstance = new $controller();
                if (method_exists($controllerInstance, $method)) {
                    return $controllerInstance->$method();
                } else {
                    die("Method {$method} tidak ditemukan di Controller {$controller}");
                }
            } else {
                die("Controller {$controller} tidak ditemukan");
            }
        } else {
            http_response_code(404);
            die("404 Halaman Tidak Ditemukan");
        }
    }
}
```

### 4. `core/Database.php`
Wrapper untuk PDO agar lebih mudah digunakan di Model.
```php
<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'db_koperasi';

    private $dbh;
    private $stmt;
    private $error;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            die("Koneksi Database Gagal: " . $this->error);
        }
    }

    // Menyiapkan query
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind parameter keamanan SQL Injection
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Eksekusi query
    public function execute()
    {
        return $this->stmt->execute();
    }

    // Ambil banyak data
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Ambil satu data
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
}
```

### 5. `core/Controller.php`
Base controller agar semua controller bisa dengan mudah memanggil view dan model.
```php
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
```

### 6. `src/Controllers/HomeController.php` (Contoh Penggunaan Controller)
```php
<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Bisa memanggil model seperti ini:
        // $akunModel = $this->model('Akun');
        // $dataAkun = $akunModel->getAll();

        $data = [
            'title' => 'Dashboard Sistem Akuntansi',
            'pesan' => 'Selamat datang di Sistem Akuntansi Koperasi'
        ];

        // Memanggil file src/Views/home.php
        $this->view('home', $data);
    }
}
```

### 7. `src/Views/home.php` (Contoh Penggunaan View)
```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
</head>
<body>
    <h1><?= $title ?></h1>
    <p><?= $pesan ?></p>
</body>
</html>
```
