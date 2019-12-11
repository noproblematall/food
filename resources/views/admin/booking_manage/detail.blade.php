@extends('admin.layouts.app')

@section('css')
    <style>
        table tbody tr td {
            border: none !important;
            text-align: left !important;
        }
    </style>
@endsection

@section('content')

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <i class="icon fa fa-briefcase"></i>
            <div>
            <h4>Booking Detail</h4>
            <p class="mg-b-0">Detailed Booking Page</p>
        </div>            
    </div><!-- d-flex -->

    <div class="br-pagebody user_detail">            
        <div class="mg-t-50 card card-body">
        <h3 class="mg-t-10 text-center"><a href="{{ route('admin.wajba_detail', $booking->wajba_id) }}">"{{ $booking->wajba->title }}"</a></h3>
            <div class="row">
                <div class="col-6">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Host Name</td>
                                <td><a href="{{ route('admin.user_detail', $booking->wajba->host->user->id) }}">{{ $booking->wajba->host->user->full_name }}</a></td>
                            </tr>
                            <tr>
                                <td>Number Of Females</td>
                                <td>{{ $booking->numberOfFemales }}</td>
                            </tr>
                            <tr>
                                <td>Number Of Males</td>
                                <td>{{ $booking->numberOfMales }}</td>
                            </tr>
                            <tr>
                                <td>Number Of Childrens</td>
                                <td>{{ $booking->numberOfChildren }}</td>
                            </tr>
                            <tr>
                                <td>Total Amount</td>
                                <td>{{ $booking->totalAmount }}</td>
                            </tr>
                            <tr>
                                <td>Booked Date</td>
                                <td>{{ $booking->date->date }}</td>
                            </tr>
                            <tr>
                                <td>Booked Time</td>
                                <td>{{ $booking->wajba->time->fromTime }} ~ {{ $booking->wajba->time->toTime }}</td>
                            </tr>
                            <tr>
                                <td>Created Date and Time</td>
                                <td>{{ $booking->created_at }}</td>
                            </tr>
                            <tr>
                                <td>Booking Status</td>
                            <td>{{ $booking->status->type }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-6">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Payment Status</td>
                                @if ($booking->payment_id != null)
                                    @if ($booking->payment->status == 0)
                                        <td>
                                            Not Paid
                                        </td>
                                    @else
                                        <td>
                                            Paid
                                        </td>
                                    @endif
                                @else
                                    <td>
                                        Pending
                                    </td>
                                @endif
                            </tr>
                            @if ($booking->payment_id != null)
                                <tr>
                                    <td>PaymentRef</td>
                                    <td>{{ $booking->payment->paymentRef }}</td>
                                </tr>
                                <tr>
                                    <td>Real Amount</td>
                                    <td>{{ $booking->totalAmount * 0.8 }}</td>
                                </tr>
                                <tr>
                                    <td>Created Time</td>
                                    <td>{{ $booking->payment->created_at }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
@endsection