<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Carbon\Carbon;

class Period extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function periodUsers()
    {
        return $this->hasMany(PeriodUser::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Check if period is still active (end_date >= today)
     */
    public function isActive(): bool
    {
        return $this->end_date >= Carbon::today();
    }

    /**
     * Scope to get only active periods
     */
    public function scopeActive($query)
    {
        return $query->where('end_date', '>=', Carbon::today());
    }
}
