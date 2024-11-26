<?php
namespace App\Models;

use CodeIgniter\Model;

class Alerts extends Model
{
    protected $table = 'alerts';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['message','linked'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
// CREATE TABLE 'alerts' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'message' TEXT, 'linked' TEXT)