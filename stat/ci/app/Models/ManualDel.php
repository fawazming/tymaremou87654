<?php
namespace App\Models;

use CodeIgniter\Model;

class ManualDel extends Model
{
    protected $table = 'manual';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['fname','lname','lb','phone','category','school','gender','tag'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
