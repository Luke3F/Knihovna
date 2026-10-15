<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'isbn', 'available_copies'];

    public function loans() { return $this->hasMany(Loan::class); }

    // Filtr podle názvu nebo autora
    public function scopeSearch($q, ?string $s)
    {
        return $q->when($s, fn ($q) => $q->where(
            fn ($w) => $w->where('title', 'like', "%$s%")->orWhere('author', 'like', "%$s%")
        ));
    }
}
