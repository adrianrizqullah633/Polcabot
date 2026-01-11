<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daftar extends Model
{
    use HasFactory;

    // Nama table di database
    protected $table = 'daftar_knowledge';

    // Field yang bisa diisi (mass assignment)
    protected $fillable = [
        'question',
        'answer',
        'keywords',
        'source',
    ];

    // Cast keywords sebagai array (jika disimpan sebagai JSON)
    protected $casts = [
        'keywords' => 'array',
    ];

    /**
     * Accessor: Get keywords as comma-separated string
     */
    public function getKeywordsStringAttribute()
    {
        if (is_array($this->keywords)) {
            return implode(', ', $this->keywords);
        }
        return $this->keywords;
    }

    /**
     * Mutator: Set keywords from comma-separated string
     */
    public function setKeywordsAttribute($value)
    {
        if (is_string($value)) {
            // Split by comma, trim whitespace, filter empty
            $keywords = array_filter(array_map('trim', explode(',', $value)));
            $this->attributes['keywords'] = json_encode($keywords);
        } elseif (is_array($value)) {
            $this->attributes['keywords'] = json_encode($value);
        } else {
            $this->attributes['keywords'] = null;
        }
    }

    /**
     * Scope: Search by keyword
     */
    public function scopeWithKeyword($query, $keyword)
    {
        return $query->whereRaw('JSON_CONTAINS(keywords, ?)', [json_encode($keyword)]);
    }
}