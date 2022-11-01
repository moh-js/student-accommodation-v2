<?php
namespace App\Settings;

use Spatie\LaravelSettings\Settings;


class AllocationSettings extends Settings
{
    public int $room_reserved;
    public array $criteria;
    
    public static function group(): string
    {
        return 'allocation';
    }
    
}
