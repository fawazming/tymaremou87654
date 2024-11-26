<?php
namespace App\Models;

use CodeIgniter\Model;

class Pins extends Model
{
    protected $table = 'pins_24';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['pin','used','vendor','sold'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
