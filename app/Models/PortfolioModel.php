<?php

namespace App\Models;

use CodeIgniter\Model;

class PortfolioModel extends Model
{

    protected $table      = 'portfolio';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['judul', 'slug', 'kategori', 'detail_en', 'detail_id', 'sampul'];

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // -------------------------------------
    public function getPortfolio($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->where(['slug' => $slug])->first();
    }
}
