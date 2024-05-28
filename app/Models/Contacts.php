<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    public function contacts()
    {
        $allContacts = Contacts::all();
    }
}
