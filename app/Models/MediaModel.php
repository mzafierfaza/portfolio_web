<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaModel extends Model
{

    protected $table      = 'portfolio_media';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['id', 'slug', 'gambar'];

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // -------------------------------------
    public function getMedia($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->where(['slug' => $slug])->first();
    }
}
