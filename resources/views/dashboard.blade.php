@extends('layouts.app')

@section('content')

{{-- Payment Dashboard --}}

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body overflow-hidden">
                        <p class="text-truncate font-size-14 mb-2">Number of Application</p>
                        <h4 class="mb-0">{{ $applications->count() }}</h4>
                    </div>
                    <div class="text-primary">
                        <i class="mdi mdi-application font-size-24"></i>
                    </div>
                </div>
            </div>
            <div class="card-body border-top py-3">
                <div class="text-truncate d-flex">
                    <div class="d-inline mr-3">
                        <span><i class="mdi mdi-human-male"> </i> Male</span>
                        <span class="badge badge-soft-success font-size-13"> {{ $maleApplication }}</span>
                    </div>
                    <div class="d-inline">
                        <span><i class="mdi mdi-human-female"> </i> Female</span>
                        <span class="badge badge-soft-success font-size-13"> {{ $femaleApplication }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body overflow-hidden">
                        <p class="text-truncate font-size-14 mb-2">Number of Selected Applicants</p>
                        <h4 class="mb-0">{{ $shortlisted->count() }}</h4>
                    </div>
                    <div class="text-primary">
                        <i class="mdi mdi-application-import font-size-24"></i>
                    </div>
                </div>
            </div>
            <div class="card-body border-top py-3">
                <div class="text-truncate d-flex">
                    <div class="d-inline mr-3">
                        <span><i class="mdi mdi-human-male"> </i> Male</span>
                        <span class="badge badge-soft-success font-size-13"> {{ $maleSelected->count() }}</span>
                    </div>
                    <div class="d-inline">
                        <span><i class="mdi mdi-human-female"> </i> Female</span>
                        <span class="badge badge-soft-success font-size-13"> {{ $femaleSelected->count() }}</span>
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
