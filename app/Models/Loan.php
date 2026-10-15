<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['book_id', 'reader_id', 'borrowed_at', 'due_at', 'returned_at'];
    protected $casts = ['borrowed_at' => 'datetime', 'due_at' => 'datetime', 'returned_at' => 'datetime'];

    public function book() { return $this->belongsTo(Book::class); }
    public function reader() { return $this->belongsTo(Reader::class); }

    // Po termínu = nevrácená a due_at v minulosti
    public function isOverdue(): bool
    {
        return is_null($this->returned_at) && $this->due_at->isPast();
    }
}
