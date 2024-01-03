<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PanelProduct extends Product
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // static::addGlobalScope(new AvailableScope);  eliminado para poder acceder a los productos sin el global scope
    }

}
