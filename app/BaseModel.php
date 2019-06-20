<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_atualizacao';
}
