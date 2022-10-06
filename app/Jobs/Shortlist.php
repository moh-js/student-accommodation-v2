<?php

namespace App\Jobs;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Shortlist as ModelsShortlist;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class Shortlist implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $disabled = ['student_type', 'disabled'];
    protected $foreigner = ['student_type', 'foreigner'];
    protected $fresher = ['student_type', 'fresher'];
    protected $sponsor = ['sponsor', 'government'];
    protected $female = ['gender_id', 2];
    protected $male = ['gender_id', 1];
    protected $certificate_award = ['award', 'certificate'];
    protected $diploma_award = ['award', 'diploma'];
    protected $bachelor_award = ['award', 'bachelor'];
    protected $shortlist = [];
    protected $checked = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $privileges = [
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
        ];

        ModelsShortlist::query()->delete();

        $this->shortlist = collect();
        $this->checked = collect();

        foreach ($privileges as $key => $privilege) {

            $students = Student::hasApplication()->notRedFlagged()
            ->where($privilege)
            ->whereNotIn('id', $this->checked)
            ->get();

            foreach ($students as $student) {
                ModelsShortlist::firstOrCreate([
                    'student_id' => $student->id
                ]);
            }

            $this->checked = collect($this->checked)->merge($students->pluck('id'));

        }
    }
}
