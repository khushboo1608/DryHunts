@extends('layouts.app')
@section('content')
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNK2NX9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')
<main class="main__content_wrapper my-Appoinment">
    <section class="order-details__page--area section--padding">
    @if(isset($orderData))

    <?php 
    // echo "<pre>";
    // print_r($orderData);die;
    ?>
    <div class="container">
        <div class="row">
        <div class="col-lg-12">
            <div class="card-1">
            @if (session('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="header-single-box">
                
                <h3 class="">Request ID : {{$orderData['order_id']}}</h3>
                <?php 
                $order_type = '';
                if($orderData['order_type']== 1){
                    $order_type ='pending';
                }
                else if($orderData['order_type'] == 2){
                    $order_type ='accepted';
                }
                else if($orderData['order_type'] == 3){
                    $order_type ='work in progress';
                }
                else if($orderData['order_type'] == 4){
                    $order_type ='completed';
                }
                else{
                    $order_type ='cancelled';
                }
            ?>
                <button class="primary__btn">{{$order_type}}</button>
            </div>
            <div class="col-12">
                <div class="cart__table">
                <table class="cart__table--inner">
                    <thead class="cart__table--header">
                    <tr class="cart__table--header__items">
                        <th class="cart__table--header__list">Product</th>
                        <th class="cart__table--header__list">Price</th>
                        <th class="cart__table--header__list text-center">
                        Quantity
                        </th>
                        <th class="cart__table--header__list text-right">
                        Total
                        </th>
                    </tr>
                    </thead>
                    <tbody class="cart__table--body order-details">
                    <?php 
                                        $totalamount =0;
                                        $total_amount = 0;
                                    ?>
                  @foreach ($orderData['order_details']  as $key => $val)

                  <?php 
                //   echo "<pre>";
                //   print_r($val);
                  ?>
                    <tr class="cart__table--body__items">
                        <td class="cart__table--body__list">
                        <div class="cart__product d-flex align-items-center">
                            <div class="cart__thumbnail">
                          
                            <a href="{{ url('servicedetails/'.$val['service_id']) }}">
                                <img class="border-radius-5" src="{{$val['service_image']}}" alt="cart-product"></a>
                            </div>
                            <div class="cart__content">
                            <h4 class="cart__content--title">
                                <a href="#">{{$val['service_name']}}</a>
                            </h4>
                            <span class="cart__content--variant">SIZE: {{$val['order_unit']}}</span>
                            </div>
                        </div>
                        </td>
                        <td class="cart__table--body__list">
                        <span class="cart__price">{{$val['order_original_price']}}</span>
                        </td>
                        <td class="cart__table--body__list">
                        <div class="quantity__box">{{$val['order_quantity']}}</div>
                        </td>
                        <?php 
                            $totalamount = $val['order_quantity']*$val['order_original_price'];
                            // $total_amount += $totalamount;

                            ?>
                        <td class="cart__table--body__list">
                        <span class="cart__price end">₹  {{$totalamount}}</span>
                        </td>
                    </tr>
                    <?php 
                        $total_amount += $totalamount;
                    ?>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div class="d-flex flex-wrap mt-40 margin">
                <div class="col-xl-6 col-lg-6 col-12 col-md-12 padding mb-md-3">
                
                <div class="main-single-box">
                    <h2 class="checkout__order--summary__title text-center mb-15">
                    Payment Details
                    </h2>                                     
                    <div class="payment-amount">
                    <span class="checkout__total--footer__title">Total Amount</span>
                    <span class="checkout__total--footer__amount">₹ {{$total_amount}}</span>
                    </div>
                </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-12 col-md-12 padding"> 
                    <form id="order-cancle-form" action="{{ url('ordercancle') }}" method="POST" >  
                        @csrf
                    <input type="hidden" id="order_id" name="order_id" value="{{$orderData['order_id']}}">  
                    <?php      
                        //  if($orderData['order_type'] == 5){
                        //     $style = "display:none";
                        //  }
                        //  else{
                        //     $style = "display:block";
                        //  }
                         if($orderData['order_type'] == 1){
                            $style = "display:block;";
                        }
                        elseif($orderData['order_type'] == 2){
                            $style = "display:none;";
                        }
                        elseif($orderData['order_type'] == 3){
                            $style = "display:none;";
                        }
                        elseif($orderData['order_type'] == 4){
                            $style = "display:none;";
                        }
                        elseif($orderData['order_type'] == 5){
                            $style = "display:none;";
                        }
                        else{
                            $style = "display:none;";
                        }

                         ?>
                    <button type="submit" class="primary__btn" style="{{$style}} margin: 0;position: absolute;top: 50%;left: 33%;-ms-transform: translateY(-50%);transform: translateY(-50%);" id="cancle_order">Cancel Request</button>
            </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    @endif
    </section>
</main>
@include('layouts.footer')
@endsection
@section('scripts')
<!-- <script type="text/javascript">

    $('#cancle_order').on('click', function() {

    var order_id = $('order_id').val();

    $.ajax({
        type: "post",
        data: {
            'order_id': order_id,
        },
        url: "{{url('/ordercancle')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "JSON",
        success: function(response) {
            if(response.result == true)
            {
                location.reload();
            }
            else{
                alert(response.result.message);
            }
        }
    });
    return false;
    });

      
     
      </script> -->
@endsection