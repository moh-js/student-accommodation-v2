<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateAllocationSetting extends SettingsMigration
{
    protected $disabled = ['student_type', 'disabled'];
    protected $foreigner = ['student_type', 'foreigner'];
    protected $fresher = ['student_type', 'fresher'];
    protected $sponsor = ['sponsor', 'government'];
    protected $female = ['gender_id', 2];
    protected $male = ['gender_id', 1];
    protected $certificate_award = ['award', 'certificate'];
    protected $diploma_award = ['award', 'diploma'];
    protected $bachelor_award = ['award', 'bachelor'];

    public function up(): void
    {
        $this->migrator->add('allocation.room_reserved', 0);
        $this->migrator->add('allocation.criteria', [
            [$this->disabled],
            [$this->foreigner],
            [$this->certificate_award],
            [$this->sponsor, $this->fresher],
            [$this->sponsor],
            [$this->fresher, $this->female],
            [$this->female],
            [$this->fresher, $this->male, $this->diploma_award],
            [$this->fresher, $this->male, $this->bachelor_award],
            [$this->fresher],
            [$this->male]
        ]);
    }
}
