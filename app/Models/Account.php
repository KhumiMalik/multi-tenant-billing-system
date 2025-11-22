<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToAgency;

class Account extends Model {
    use BelongsToAgency;
    protected $fillable = ['agency_id','account_number','name','email','phone'];

    public function invoices() { return $this->hasMany(Invoice::class); }
}
