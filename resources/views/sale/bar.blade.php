@extends('layout.main') 
@section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Bar Sales</h4>
                    </div>
                    <div class="card-body">
                        {{-- Pasted Code --}}

                        <div class="row">
                            @foreach($sales as $data)
                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="card-header bg-gradient-gray">
                                            <span><strong><a href="{{ asset('store/orders/view-order/'.$data->id) }}" > # {{$data->reference_no}}</a></strong></span>
                                        </div>
                                        <input type="hidden" name="orderId" id="orderId" value="{{$data->id}}"/>
                                        <div class="list-group">
                                            <div class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h4 class="mb-1">{{ __('Bill Amount') }}: <b>${{$data->grand_total}}</b></h4>
                                                </div>
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1">placed: <b>{{ $data->created_at->diffForHumans() }}</b></h6>
                                                    <small class="mb-1">Payment :
                                                        @switch ($data->payment_status)
                                                            @case('1')
                                                            <span class="badge badge-success"><strong> Complete</strong></span>
                                                            @break
                                                            @case('2')
                                                            <span class="badge badge-warning"><strong> Pending</strong></span>
                                                            @break
                                                            @case('3')
                                                            <span class="badge badge-primary"><strong> Draft</strong></span>
                                                            @break
                                                            @case('0')
                                                            <span class="badge badge-info"><strong> {{__('all.pending')}}</strong></span>
                                                            @break
                                                        @endswitch
                                                    </small>
                                                </div>
                                                
                                                <div class="d-flex w-100 justify-content-between">
                                                    <label><b>Note</b></label>
                                                    <small class="mb-1"><b>{{ $data->sale_note }}</b></small>
                                                </div>
                                                <div class="d-flex w-100 justify-content-between">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 160px;">Particular</th>
                                                                <th style="text-align: right;">Quantity</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($data->saleProducts as $item)
                                                        <tr>
                                                            @if($item->product->mode=="Kitchen")
                                                            <td>
                                                                {{ $item->product->name }}
                                                            </td>
                                                            <td style="text-align: right;">{{ $item->qty }}</td>
                                                            @endif
                                                        </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- End of Pasted Code --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection