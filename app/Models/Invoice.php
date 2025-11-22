<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToAgency;

class Invoice extends Model
{
    use BelongsToAgency;
    protected $fillable = ['agency_id', 'account_id', 'number', 'status', 'amount', 'due_date', 'notes'];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function markSent()
    {
        $this->update(['status' => 'sent']);
    }
    public function markPaid()
    {
        $this->update(['status' => 'paid']);
    }
}
