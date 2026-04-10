<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'image',
        'link',
        'code',
        'dimensions',
        'is_active',
        'start_date',
        'end_date',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            });
    }

    public function scopeByPosition(Builder $query, string $position): Builder
    {
        return $query->where('position', $position);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    public function toAdSenseArray(): array
    {
        if ($this->code) {
            return [
                'type' => 'code',
                'code' => $this->code,
                'dimensions' => $this->dimensions,
            ];
        }

        return [
            'type' => 'image',
            'image' => $this->image,
            'link' => $this->link,
            'dimensions' => $this->dimensions,
        ];
    }
}
