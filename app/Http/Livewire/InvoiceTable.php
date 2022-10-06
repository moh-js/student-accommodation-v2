<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InvoiceTable extends Component
{
    public $invoice;
    public $student;

    public function mount()
    {
        $this->invoice = $this->student->currentInvoice();
    }
    
    public function render()
    {
        return view('livewire.invoice-table');
    }
}
