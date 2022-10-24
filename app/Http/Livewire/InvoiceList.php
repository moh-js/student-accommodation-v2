<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use Livewire\Component;
use App\Models\AcademicYear;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class InvoiceList extends Component
{
    use WithPagination;

    public $academic_year_id;
    public $status;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->academic_year_id = AcademicYear::current()->id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingAcademicYearId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $invoices = Invoice::where('academic_year_id', $this->academic_year_id)->orderBy('id', 'desc')
            ->when($this->status != null, function ($query) {
                $query->where('status', $this->status);
            })
            ->when(strlen($this->search) >= 3, function ($query) {
                $query->whereHas('student', function (Builder $q) {

                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('username', 'like', "%{$this->search}%");
                });
            })
            ->paginate(50);

        return view('livewire.invoice-list', [
            'invoices' => $invoices
        ]);
    }
}
