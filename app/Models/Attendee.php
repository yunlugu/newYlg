<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/*
  Attendize.com   - Event Management & Ticketing
 */

/**
 * Description of Attendees.
 *
 * @author Dave
 */
class Attendee extends MyBaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'event_id',
        'order_id',
        'member_id',
        'full_name',
        'ticket_id',
        'account_id',
        'reference',
        'private_reference_number',
        'has_arrived',
        'arrival_time'
    ];

     /**
      * Generate a private reference number for the attendee. Use for checking in the attendee.
      *
      */
     public static function boot()
     {
         parent::boot();

         static::creating(function ($order) {
            $order->private_reference_number = str_pad(rand(0, pow(10, 9) - 1), 9, '0', STR_PAD_LEFT);
        });
     }

    /**
     * The order associated with the attendee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('\App\Models\Order');
    }

    /**
     * The ticket associated with the attendee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo('\App\Models\Ticket');
    }

    /**
     * The event associated with the attendee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo('\App\Models\Event');
    }
    public function member()
    {
        return $this->belongsTo('\App\Models\Member');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\Models\QuestionAnswer');
    }

    /**
     * Scope a query to return attendees that have not cancelled.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeWithoutCancelled($query)
    {
        return $query->where('attendees.is_cancelled', '=', 0);
    }

    /**
     * Get the attendee reference
     *
     * @return string
     */
    public function getReferenceAttribute() {
        return $this->order->order_reference . '-' . $this->reference_index;
    }


    /**
     * The attributes that should be mutated to dates.
     *
     * @return array $dates
     */
    public function getDates()
    {
        return ['created_at', 'updated_at', 'arrival_time'];
    }
}
