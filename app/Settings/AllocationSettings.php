<?php
namespace App\Settings;

use Spatie\LaravelSettings\Settings;


class AllocationSettings extends Settings
{
    public int $male_reserved_room;
    public int $female_reserved_room;
    public array $criteria;
    
    public static function group(): string
    {
        return 'allocation';
    }
    
}
