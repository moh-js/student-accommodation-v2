@extends('layouts.app')

@section('content')

{{-- Payment Dashboard --}}

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body overflow-hidden">
                        <p class="text-truncate font-size-14 mb-2">Number of Invoice</p>
                        <h4 class="mb-0">{{ $invoices->count() }}</h4>
                    </div>
                    <div class="text-primary">
                        <i class=" ri-wallet-line font-size-24"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body overflow-hidden">
                        <p class="text-truncate font-size-14 mb-2">Number of Paid Invoice</p>
                        <h4 class="mb-0">{{ $invoices->where('status', 1)->count() }}</h4>
                    </div>
                    <div class="text-primary">
                        <i class=" ri-hand-coin-line font-size-24"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body overflow-hidden">
                        <p class="text-truncate font-size-14 mb-2">Number of Pending Payment</p>
                        <h4 class="mb-0">{{ $invoices->where('status', 0)->count() }}</h4>
                    </div>
                    <div class="text-primary">
                        <i class="ri-refund-line font-size-24"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- End Payment Dashboard --}}
@endsection
