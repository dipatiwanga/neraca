<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Journal;
use App\Models\Account;
use App\Helpers\Accounting;

/**
 * JournalController
 * Mengelola pencatatan transaksi jurnal umum
 */
class JournalController extends Controller
{
    private $journalModel;
    private $accountModel;

    public function __construct()
    {
        // Proteksi Halaman
        \App\Middleware\AuthMiddleware::handle();

        $this->journalModel = new Journal();
        $this->accountModel = new Account();
    }

    /**
     * Menampilkan daftar jurnal (Index)
     */
    public function index()
    {
        $journals = $this->journalModel->getAll();
        $this->view('journals/index', [
            'title' => 'Jurnal Umum',
            'journals' => $journals
        ]);
    }

    /**
     * Menampilkan form input jurnal baru
     */
    public function create()
    {
        $accounts = $this->accountModel->getAll();
        $this->view('journals/create', [
            'title' => 'Input Jurnal Baru',
            'accounts' => $accounts
        ]);
    }

    /**
     * Menyimpan data jurnal beserta item-itemnya
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /journals');
            exit;
        }

        // 1. Ambil data Header Jurnal
        $journalData = [
            'date' => $_POST['date'],
            'description' => $_POST['description']
        ];

        // 2. Susun data Item Jurnal dari input array
        // Format input diharapkan: account_id[], debit[], credit[]
        $itemsData = [];
        if (isset($_POST['account_id'])) {
            foreach ($_POST['account_id'] as $key => $accountId) {
                if (!empty($accountId)) {
                    $itemsData[] = [
                        'account_id' => $accountId,
                        'debit' => (float) ($_POST['debit'][$key] ?? 0),
                        'credit' => (float) ($_POST['credit'][$key] ?? 0)
                    ];
                }
            }
        }

        // 3. Validasi dasar
        if (empty($itemsData)) {
            die("Error: Jurnal harus memiliki minimal satu item.");
        }

        try {
            // 4. Panggil model untuk simpan (Di dalam model sudah ada validasi balance & Transaction)
            $this->journalModel->createWithItems($journalData, $itemsData);

            // Jika sukses, redirect
            header('Location: /journals?status=success');
            exit;

        } catch (\Exception $e) {
            // Jika gagal (Misal: tidak balance), tampilkan error
            // Idealnya dikembalikan ke form dengan pesan error
            die("Gagal menyimpan jurnal: " . $e->getMessage());
        }
    }
}
