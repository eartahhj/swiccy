<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\ImageEntity;

class ImageModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'App\Entities\ImageEntity';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function uploadImagesForPost($images, int $postId) : bool {
        foreach ($images as $image) {
            if (!$image->isValid()) {
                return false;
            }

            $imageData['filename'] = $image->getRandomName();
            $imageData['width'] = getimagesize($image->getTempName())[0];
            $imageData['height'] = getimagesize($image->getTempName())[1];
            $imageData['mimetype'] = $image->getMimeType();
            $imageData['alternate_text'] = '';
            $imageData['post_id'] = $postId;

            if (!$image->move(WRITEPATH . 'uploads', $imageData['filename'])) {
                return false;
            }

            $imageEntity = new ImageEntity($imageData);
            if (!$this->protect(false)->insert($imageEntity)) {
                return false;
            }
        }
        
        return true;
    }

    public function removeImagesForPost(int $postId) : bool {
        $images = $this->where("post_id = $postId")->findAll();
        dd($images);
    }
}
