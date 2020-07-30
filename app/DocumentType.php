<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $table = 'document_types';
    
    public function parameter()
    {
	    return $this->hasOne('App\Parameter', 'parameters_id', 'id');
    }
    
    public function transfers()
    {
	    return $this->belongsTo('App\Transfer', 'document_types_id', 'id');
    }
    
    public function movements()
    {
	    return $this->belongsTo('App\Movement', 'document_types_id', 'id');
    }
    
    public function movementChecks()
    {
	    return $this->belongsTo('App\MovementCheck', 'document_types_id', 'id');
    }
    
    public function movementBanks()
    {
	    return $this->belongsTo('App\MovementBank', 'document_types_id', 'id');
    }
    
    public function movementBoxes()
    {
	    return $this->belongsTo('App\MovementBox', 'document_types_id', 'id');
    }
}
