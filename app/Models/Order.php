<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- IMPORTAR: Para eliminación lógica

class Order extends Model
{
    use HasFactory, SoftDeletes; // <-- USAR: Trait para eliminación lógica

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'user_id',
        'invoice_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'total_amount',
        'status',
        'process_name',
        'process_date',
        'in_route_photo_path',
        'delivered_photo_path',
    ];

    // Casteo de atributos a tipos nativos de PHP
    protected $casts = [
        'process_date' => 'datetime',
        'total_amount' => 'decimal:2', // Asegura que se casteé como decimal con 2 decimales
    ];

    /**
     * Define la relación: Una orden pertenece a un usuario (quien la creó).
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para obtener órdenes activas (no eliminadas lógicamente).
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Scope para obtener órdenes archivadas (eliminadas lógicamente).
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchived($query)
    {
        return $query->onlyTrashed(); // onlyTrashed es clave con SoftDeletes
    }
}