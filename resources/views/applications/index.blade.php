@extends('layouts.app')

@section('content')

@include('layouts.partials.nav')

<div class="row justify-content-center no-gutters mt-5">
    <div class="col-md-8">
        <div class="row justify-content-center">
            <div class="col-md-6 nav">
                <a href="javascript:void(0)" onclick="$('#fresher').submit()" class="navlink">
                    <div class="icon-in-circle">
                        <i class="ri-user-received-line"></i>
                    </div>
                    <div>
                        <h5 class="navlink__title">Fresher</h5>
                        <div class="navlink__descr">New student who is selected to study at our campus</div>
                    </div>
                </a>
                <form hidden id="fresher" action="{{ route('student-type') }}" method="post">
                    @csrf
                    <input hidden value="1" type="integer" name="fresher">
                </form>
            </div>
            <div class="col-md-6 nav">
                <a href="javascript:void(0)" onclick="$('#continuous').submit()" class="navlink">
                    <div class="icon-in-circle">
                        <i class=" ri-user-follow-line"></i>
                    </div>
                    <div>
                        <h5 class="navlink__title">Continuous</h5>
                        <div class="navlink__descr">Students who are already registered and are continuing their study at our campus</div>
                    </div>
                </a>
                <form hidden id="continuous" action="{{ route('student-type') }}" method="post">
                    @csrf
                    <input hidden value="1" type="integer" name="continuous">
                </form>
            </div>
            <div class="col-md-6 nav">
                <a href="javascript:void(0)" onclick="$('#status').submit()" class="navlink">
                    <div class="icon-in-circle">
                        <i class=" ri-share-forward-2-line"></i>
                    </div>
                    <div>
                        <h5 class="navlink__title">Status</h5>
                        <div class="navlink__descr">Continue where you left or check your application status</div>
                    </div>
                </a>
                <form hidden id="status" action="{{ route('student-type') }}" method="post">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('link')
    <style>
        .navlink {
            display: -ms-inline-flexbox;
            display: inline-flex;
            -ms-flex-align: center;
            align-items: center;
            /* max-width: 344px; */
            margin: 16px;
            padding: 16px;
            box-shadow: 0 4px 8px 0 rgb(38 40 42 / 10%);
            background-color: #ffffff;
            /* letter-spacing: .1px; */
            color: #6b7480;
            transition: none;
        }

        .nav :hover {
            background-color:#F1FBFF;
        }

        .navlink .icon-in-circle {
            margin-right: 12px;
        }

        .icon-in-circle {
            width: 70px;
            height: 70px;
            -ms-flex-negative: 0;
            flex-shrink: 0;
            display: -ms-inline-flexbox;
            display: inline-flex;
            font-size: 20px;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-align: center;
            align-items: center;
            background-color: #f5f8ff;
            border-radius: 50%;
        }

        .icon-in-circle .icon {
            fill: #959eb0;
            /* font-size: 20px; */
        }

        .icon {
            transition: all .3s ease;
        }

        .icon-submit-ticket {
            width: 1em;
            height: 1em;
            fill: #959EB0;
        }

        .navlink .navlink__title {
            /* font-size: 14px; */
            font-weight: 700;
            line-height: 1.5;
            color: #002d73;
        }

        .navlink .navlink__descr {
            /* font-size: 12px; */
        }
    </style>
@endpush
