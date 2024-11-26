<?php
namespace App\Models;

use CodeIgniter\Model;

class PinsOld extends Model
{
    protected $table = 'pins';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['used','sold','vendor'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
