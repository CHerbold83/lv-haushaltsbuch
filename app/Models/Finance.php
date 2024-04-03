<?php

namespace App\Models;

use App\FinanceType;
use App\Observers\FinanceObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;

    protected $id;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $title;
    protected $amount;
    protected $monthly;
    protected $type = FinanceType::Income;
    protected $date;
    protected int $userID; 
    protected $casts = [
        'type' => FinanceType::class,
        'date' => 'datetime:Y-m-d',
    ];
    protected $attributes = [
        'monthly'=> false,
    ];

    protected $fillable = [
        'title', 
        'amount',
        'monthly',
        'type',
        'date',
        'user_id'
    ];

    public static function boot(){
        parent::boot();
        parent::observe(new FinanceObserver);
        static::creating(function ($model) {
            $model->user_id=auth()->user()->id; 
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getId(): int{
        return $this->id;
    }

}
