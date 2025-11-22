<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = ['name','slug'];

    public function users() { return $this->hasMany(User::class); }
    public function accounts() { return $this->hasMany(Account::class); }
    public function invoices() { return $this->hasMany(Invoice::class); }
}
