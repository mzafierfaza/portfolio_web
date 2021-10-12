<?php

namespace App\Controllers;

use App\Models\PortfolioModel;

class Portfolio extends BaseController
{

    protected $portfolioModel;

    public function __construct()
    {
        $this->portfolioModel = new PortfolioModel();
    }

    public function index()
    {

        $data = [
            'title' => 'MZF Portfolios',
            'portfolio' => $this->portfolioModel->getPortfolio()
        ];

        return view('portfolio/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => $slug,
            'portfolio' => $this->portfolioModel->getPortfolio($slug)
        ];

        if (empty($data['portfolio'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Portfolio dengan judul' . $slug . ' tidak ditemukan');
        };

        return view('portfolio/detail', $data);
    }

    public function create()
    {

        $data = [
            'title' => 'Tambah Data',
            'validation' => \Config\Services::validation()
        ];

        return view('portfolio/create', $data);
    }

    public function save()
    {

        // validasi dulu sebelum insert
        // liat aja di dokumentasi ini ada apa aja selain required dan is_uninqe. is_uniqe adalah tiap judul nanti gakboleh sama
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[portfolio.judul]',
                'errors' => [
                    'required' => '{field} portfolio harus diisi',
                    'is_unique' => '{field} portfolio sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,2048]is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran Gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                ]
            ]

        ])) {


            return redirect()->to('/portfolio/create')->withInput();
        }

        // ambil gambarr
        $fileSampul = $this->request->getFile('sampul');

        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            // generate nama sampul random
            $namaSampul = $fileSampul->getRandomName();

            // pindahkan gambar ke folder img
            $fileSampul->move('img', $namaSampul);
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);

        $this->portfolioModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'kategori' => $this->request->getVar('kategori'),
            'detail_en' => $this->request->getVar('detail_en'),
            'detail_id' => $this->request->getVar('detail_id'),
            'sampul' => $namaSampul,
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambah');

        // kalo sudah balek lagi ke halaman index
        return redirect()->to('/portfolio');
    }

    public function delete($id)
    {

        // BERIKUT JIKA GAMBAR DI SERVER JUGA INGIN DIHAPUS!
        // cari gambar berdasarkan id
        $portfolio = $this->portfolioModel->find($id);

        // hapus gambar
        // if ($portfolio['sampul'] != 'default.jpg') {
        //     unlink('img/' . $portfolio['sampul']);
        // }

        $this->portfolioModel->delete($id);
        // sebenarnya gini aja udah bisa mau delete . tapi tidak aman security nya karena pake method GET. bisa aja masukin id untuk di delete di URL nya.

        session()->setFlashdata('pesan', 'Data berhasil dihapus');

        return redirect()->to('/portfolio');
    }

    public function edit($slug)
    {

        $data = [
            'title' => 'Edit Portfolio',
            'validation' => \Config\Services::validation(),
            'portfolio' => $this->portfolioModel->getPortfolio($slug)
        ];

        return view('portfolio/edit', $data);
    }

    // codeigniter bisa bedain update dan save. kalo ada ID itu update ,kalo tidak ada itu save
    public function update($id)
    {

        // pengecekan slug terlebih dahulu.
        $portfolioLama = $this->portfolioModel->getPortfolio($this->request->getVar('slug'));
        if ($portfolioLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[portfolio.judul]';
        }
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} portfolio harus diisi',
                    'is_unique' => '{field} portfolio sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,2048]is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran Gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                ]
            ]
        ])) {
            return redirect()->to('/portfolio/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        // cek gambar, apakah tetap gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            // generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan gambar
            $fileSampul->move('img', $namaSampul);

            // jika mau hapus gambar lama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }


        $slug = url_title($this->request->getVar('judul'), '-', true);

        $this->portfolioModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'kategori' => $this->request->getVar('kategori'),
            'detail_en' => $this->request->getVar('detail_en'),
            'detail_id' => $this->request->getVar('detail_id'),
            'sampul' => $namaSampul,
        ]);
        session()->setFlashdata('pesan', 'Data berhasil diubah');

        // kalo sudah balek lagi ke halaman index
        return redirect()->to('/portfolio');
    }
}
