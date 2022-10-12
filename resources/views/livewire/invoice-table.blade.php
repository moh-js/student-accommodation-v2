<div class="row" wire:poll.10000ms>
    <div class="col-sm-12">
        <hr>
        
        @if ($invoice->student->sponsor != 'government')

            <div class="alert alert-primary" role="alert">
                Your Reference Number for payment is : 
                @if ($invoice->control_number)
                    <h4 class="d-flex d-inline">{{ $invoice->control_number }}</h4>
                @else
                    ....
                    <span class="d-flex float-right">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </span>
                @endif
                <div class="clearfix"></div>
                <span class="text-danger">
                    Payment amount required is TZS : {{ number_format($invoice->amount) }}. Please pay this amount only
                </span>

            </div>
            
        @endif
            

        <h5><strong>Payment Transaction Details</strong></h5>
        <table class="table table-bordered">
            <thead class="">
                <tr class="">
                    <th>Reference #</th>
                    @if ($invoice->student->sponsor != 'government')
                        <th>Invoice #</th>
                        <th>Control #</th>
                        <th>Paid Amount</th>
                        <th>Amount</th>
                    @endif
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $invoice->reference }}</td>
                    @if ($invoice->student->sponsor != 'government')

                    <td>{{ $invoice->invoice_no }}</td>
                    <td>
                        @if ($invoice->control_number)
                            {{ $invoice->control_number }}
                        @else
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td>{{ number_format($invoice->amount_paid) }}</td>
                    <td>{{ number_format($invoice->amount) }}</td>
                    @endif
                    <td class="text-center">
                        @if ($invoice->status)
                            <span class="badge badge-primary">paid</span>
                        @else
                            <span class="badge badge-danger">Not paid</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
