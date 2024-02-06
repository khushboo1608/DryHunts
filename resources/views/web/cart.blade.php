@extends('layouts.app')
@section('content')
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNK2NX9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')
<main class="main__content_wrapper">
    @if(isset($cart_data) &&  count($cart_data)>0)
    <!-- cart section start -->
    <section class="cart__section section--padding">
        <div class="container-fluid">
            <div class="cart__section--inner">
            <!-- <form action="#"> -->
                <h2 class="cart__title mb-40">Shopping Cart</h2>
                <div class="row">
                <div class="col-lg-8">
                    <div class="cart__table">
                    <table class="cart__table--inner">
                        <thead class="cart__table--header">
                        <tr class="cart__table--header__items">
                            <th class="cart__table--header__list">Product</th>
                            <th class="cart__table--header__list">Price</th>
                            <th class="cart__table--header__list">Quantity</th>
                            <th class="cart__table--header__list">Total</th>
                        </tr>
                        </thead>
                        <tbody class="cart__table--body">
                        <?php 
                            $totalamount =0;
                            $total_amount = 0;
                            $totaldisamount =0;
                            $total_dis_amount =0;
                        ?>
                        @foreach ($cart_data as $key => $val)
                             <?php 
                             $i = $key + 1;
                             ?>
                              
                        <tr class="cart__table--body__items">
                            <td class="cart__table--body__list">
                            <div class="cart__product d-flex align-items-center">
                                <button class="cart__remove--btn cart_remove_product" data-id="{{$val['cart_id']}}" aria-label="search button" type="button" >
                                <!-- <input type="hidden" id="cart_id" name="cart_id" value="{{$val['cart_id']}}"> -->
                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16px" height="16px">
                                    <path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"></path>
                                </svg>
                                </button>
                                
                                <div class="cart__thumbnail">
                                    <a href="#"><img class="border-radius-5" src="{{$val['service_single_image']}}" alt="cart-product"></a>
                                </div>
                                <div class="cart__content">
                                <h4 class="cart__content--title">
                                    <a href="#">{{$val['service_name']}}</a>
                                </h4>
                                <span class="cart__content--variant">SIZE : {{$val['service_unit']}}</span>
                                </div>
                            </div>
                            </td>
                            <td class="cart__table--body__list 1111">
                            <span class="cart__price">₹ {{$val['cart_service_original_price']}}</span>

                            <span class="cart__price text-decoration-line">₹ {{$val['cart_service_discount_price']}}</span>
                            </td>
                            <td class="cart__table--body__list">
                            <div class="quantity__box">
                                <button type="button" class="quantity__value quickview__value--quantity decrease" data-id="{{$val['cart_id']}}" data-type="minus" data-field="" aria-label="quantity value" value="Decrease Value">
                                -
                                </button>

                                <input type="number" class="quantity__number quickview__value--number" id="quantity_{{$val['cart_id']}}" name="quantity_{{$val['cart_id']}}" value="{{$val['cart_service_quantity']}}" min="1">
                                <button type="button" class="quantity__value quickview__value--quantity increase" data-id="{{$val['cart_id']}}" data-type="plus" data-field="" aria-label="quantity value" value="Increase Value">
                                +
                                </button>
                            </div>
                            </td>
                            <td class="cart__table--body__list">
                            <span class="cart__price end">₹{{$val['cart_service_quantity']*$val['cart_service_original_price'];}}</span>

                            </td>
                            <td>
                            </td>
                        </tr>
                            <?php 
                            $totalamount = $val['cart_service_quantity']*$val['cart_service_original_price'];
                            $total_amount += $totalamount;

                            $totaldisamount = $val['cart_service_quantity']*$val['cart_service_discount_price'];
                            $total_dis_amount += $totaldisamount;

                            ?>
                            
                        @endforeach
                        
                        </tbody>
                    </table>
                    <!-- <div class="continue__shopping d-flex justify-content-between">
                        <a class="continue__shopping--link" href="#">Continue shopping</a>                       
                        <button class="continue__shopping--clear remove_users_cart" id="clearcart">Clear Cart</button>
                    </div> -->
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="cart__summary border-radius-10">
                    <div class="cart__summary--total mb-20">
                        <table class="cart__summary--total__table" id="testing">
                        <tbody>
                            <tr class="cart__summary--total__list">
                            <td class="cart__summary--total__title text-left">
                                Total Price
                            </td>
                            <?php
                           $total_price = $val['cart_service_quantity']*$val['cart_service_discount_price'];
                            ?>
                           
                            <td class="cart__summary--amount text-right"> <span>₹</span> <span id="totl_price"> {{ $total_dis_amount}} </span></td>

                            </tr>
                            <tr class="cart__summary--total__list">
                            <td class="cart__summary--total__title text-left">
                            Total Discount Price
                            </td>
                            <?php
                           $total_price = $val['cart_service_quantity']*$val['cart_service_original_price'];
                            ?>
                            
                            <td class="cart__summary--amount text-right"> <span>₹</span> <span id="totl_dis_price"> {{ $total_amount}} </span></td>
                            </tr>
                            
                            <tr class="cart__summary--total__list">
                            <td class="cart__summary--total__title text-left price-total">
                                Final Amount
                            </td>
                            <td class="cart__summary--amount text-right price-total">
                            ₹ {{ $total_amount}}
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <div class="cart__summary--footer">
                        <ul class="d-flex justify-content-between">                       
                        <button class="cart__summary--footer__btn primary__btn checkout" id="btn-confirm">Check Out</button>
                        </ul>
                    </div>
                    </div>
                </div>
                </div>
            <!-- </form> -->
            </div>
        </div>
    </section>
    <!-- cart section end -->
    @else
    <div class="text-center mt-3">
    <div class="text-center">
        <img class="border-radius-5" src="assets/img/empty_cart.png" alt="cart-product">
    </div>
    <!-- <a class="continue__shopping--link mb-3" href="#">Continue shopping</a> -->
    </div>
    @endif
</main>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="myModalLabel">Are you sure?</h3>
        <h5>You want to request this quotation!</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="acceptbtn">YES</button>
        <button type="button" class="btn btn-primary" id="modal-btn-no" data-dismiss="modal">NO</button>
      </div>
    </div>
  </div>
</div>
@include('layouts.footer')
@endsection

@section('scripts')
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script> -->
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script>

const quantityWrapper = document.querySelectorAll(".quantity__box");

// alert(quantityWrapper);
quantityWrapper && quantityWrapper.forEach((function(e) {
    let t = e.querySelector(".quantity__number"),
        i = e.querySelector(".increase"),
        s = e.querySelector(".decrease");
    i.addEventListener("click", (function() {
        let e = parseInt(t.value, 10);
        e = isNaN(e) ? 0 : e, e++, t.value = e
    })), s.addEventListener("click", (function() {
        let e = parseInt(t.value, 10);
        e = isNaN(e) ? 0 : e, e < 2 && (e = 2), e--, t.value = e
    }))
}));

  $("#btn-confirm").on("click", function(){
    $("#mi-modal").modal('show');
  });
    $('#acceptbtn').on('click', function() {

        var totl_price = $("#totl_price").text();
        var totl_dis_price = $("#totl_dis_price").text();

        $.ajax({
            type: "post",
            data: {
                'order_amount': totl_price,
                'order_discount_amount': totl_dis_price
            },
            url: "{{url('/addorder')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: "JSON",
            success: function(response) {
                if(response.result == true)
                {
                    $("#mi-modal").modal('hide');
                    location.href = "{{url('orderthankyou')}}";
                }
                else{
                    alert(response.result.message);
                }
            }
        });
        return false;
    });
  $("#modal-btn-no").on("click", function(){
    // callback(false);
    $("#mi-modal").modal('hide');
  });

  
    $('.cart_remove_product').on('click', function() {

        var cart_id = $(this).data("id");
        // alert(cart_id);

        $.ajax({
            type: "post",
            data: {
                'cart_id': cart_id,
            },
            url: "{{url('/deletecart')}}",
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


    $(".increase").on("click",function(e){
        // alert('hii');
         e.preventDefault();

        var _id=$(this).data("id");
        // var _quantity = $("#quant").val();
        var _quantity = $("#quantity_"+_id);
        var quantity1 = _quantity.val();
        
        // alert(_id);
        // alert(quantity1);
         $.ajax({
        url  : "{{url('/updatequantity')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type : "POST",
        cache: true,
        data : {cart_id:_id,cart_service_quantity:quantity1},
        success:function(response){
        //   alert(response);
          if(response.result == true)
                {
                    location.reload();
                }
                else{
                    alert(response.result.message);
                }
          
        }
         });

    });

    $(".decrease").on("click",function(e){
        // alert('hii');
         e.preventDefault();

        var _id=$(this).data("id");
        // var _quantity = $("#quant").val();
        var _quantity = $("#quantity_"+_id);
        var quantity1 = _quantity.val();
        
        // alert(_id);
        // alert(quantity1);
         $.ajax({
        url  : "{{url('/updatequantity')}}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type : "POST",
        cache: true,
        data : {cart_id:_id,cart_service_quantity:quantity1},
        success:function(response){
        //   alert(response);
          if(response.result == true)
                {
                    location.reload();
                }
                else{
                    alert(response.result.message);
                }
          
        }
         });

    });
</script>
@endsection