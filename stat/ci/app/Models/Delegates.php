<?php
namespace App\Models;

use CodeIgniter\Model;

class Delegates extends Model
{
    protected $table = 'delegates_24';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['fname','lname','tc','phone','age','ailment','schoolcls','ref','address','gender'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
