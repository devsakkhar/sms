<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimetableTimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'stop_time',
        'timetable_id',
    ];

    protected $getDateFormat = 'H:i';

    public function startTime(): Attribute
    {
        return new Attribute(
            get: fn ($value) => \Carbon\Carbon::parse($value)->format($this->getDateFormat),
            set: fn ($value) => $value,
        );
    }

    public function stopTime(): Attribute
    {
        return new Attribute(
            get: fn ($value) => \Carbon\Carbon::parse($value)->format($this->getDateFormat),
            set: fn ($value) => $value,
        );
    }

    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => sprintf('%s - %s', $this->start_time, $this->stop_time),
            set: fn ($value) => "$this->start_time - $this->stop_time",
        );
    }

    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }

    //many to many relationship with week days
    public function weekdays()
    {
        //get pivot table as timetableRecords
        return $this->belongsToMany(Weekday::class)->as('timetableRecord')->withPivot(['timetable_time_slot_weekdayable_id', 'timetable_time_slot_weekdayable_type'])->withTimestamps()->using(TimetableRecord::class);
    }
}
