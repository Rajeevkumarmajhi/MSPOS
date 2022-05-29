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
                        <h4>Kitchen Sales</h4>
                    </div>
                    <div class="card-body">
                        {{-- Pasted Code --}}

                        <div class="row">
                            @foreach($sales as $data)
                                <div class="col-lg-3">
                                    <div class="card">
                                        @switch ($data->cooking_status)
                                            @case('1')
                                            <div class="card-header bg-gradient-gray">
                                                <span><strong><a href="{{ asset('store/orders/view-order/'.$data->id) }}" > # {{$data->reference_no}}</a></strong></span>
                                                <span class="float-right badge badge-white text-gray cooking_msg_{{ $data->id }}" >{{__('NOT STARTED')}}</span>
                                                <button class="btn btn-primary cooking_status cooking_btn_{{ $data->id }}" data-status="{{ $data->cooking_status }}" data-id="{{ $data->id }}" >Start Cooking</button>
                                            </div>
                                            @break
                                            @case('2')
                                            <div class="card-header bg-gradient-blue">
                                                <span><strong>#{{$data->reference_no}}</strong></span>
                                                <span class="float-right badge badge-white text-blue cooking_msg_{{ $data->id }}">{{__('COOKING')}}</span>
                                                <button class="btn btn-primary cooking_status cooking_btn_{{ $data->id }}" data-status="{{ $data->cooking_status }}" data-id="{{ $data->id }}" >Ready To Serve</button>
                                            </div>
                                            @break
                                            @case('3')
                                            <div class="card-header bg-gradient-success">
                                                <span><strong>#{{$data->reference_no}}</strong></span>
                                                <span class="float-right badge badge-white text-success cooking_msg_{{ $data->id }}"> {{__('Ready To Serve')}}</span>
                                            </div>
                                            @break
                                        @endswitch
                                        <input type="hidden" name="orderId" id="orderId" value="{{$data->id}}"/>
                                        <div class="list-group">
                                            <div class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h4 class="mb-1">{{ __('Bill Amount') }}: <b>${{$data->grand_total}}</b></h4>
                                                    {{-- <small class="mb-1">{{ __('all.order_type') }} : <span
                                                            class="badge bg-gradient-blue text-white"><strong>
                                                                @switch ($data->delivery_type)
                                                                    @case('1')
                                                                    {{__('all.dining')}}
                                                                    @break
                                                                    @case('2')
                                                                    {{__('all.takeaway')}}
                                                                    @break
                                                                    @case('3')
                                                                    {{__('all.delivery')}}
                                                                    @break
                                                                @endswitch</strong></span></small> --}}
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

@section('scripts')

<script>

    $(document).on('click','.cooking_status',function(){
        let id = $(this).data('id');
        let status = $(this).data('status');
        console.log(status);
        if(status>2){
            return;
        }
        if(status == 2){
            status = 3;
        }else if(status == 1){
            status = 2;
        }
        
        $.ajax({
            url: "{{ route('cooking.status.update') }}",
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "status": status,
            },
            success: function(data) {
                if(data.status==true){
                    if(data.data.cooking_status == "2"){
                        $('.cooking_btn_'+data.data.id).data('status',2);
                        $('.cooking_msg_'+data.data.id).html('Cooking');
                        $('.cooking_msg_'+data.data.id).addClass('text-blue');
                        $('.cooking_btn_'+data.data.id).html('Ready To Serve');
                    }else if(data.data.cooking_status == "3"){
                        $('.cooking_btn_'+data.data.id).data('status',3);
                        $('.cooking_btn_'+data.data.id).remove();
                        $('.cooking_msg_'+data.data.id).html('Ready To Serve');
                        $('.cooking_msg_'+data.data.id).removeClass('text-blue');
                        $('.cooking_msg_'+data.data.id).addClass('text-success');
                    }
                }
            },
            error: function(error) {
                alert('error');
            }
        });

    });


</script>


@endsection