@extends('layouts.app')
@section('content')
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNK2NX9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@include('layouts.header')
<main class="main__content_wrapper">      
        <!-- my account section start -->
        <section class="my__account--section section--padding">
            <div class="container">
                <div class="my__account--section__inner border-radius-10">
                    <div class="account__wrapper">
                        <div class="account__content">
                            <h3 class="account__content--title mb-20">Request History</h3>
                            <div class="account__table--area">
                                <table class="account__table">
                                    <thead class="account__table--header">
                                        <tr class="account__table--header__child">
                                            <th class="account__table--header__child--items">Request Id</th>
                                             <th class="account__table--header__child--items">Date</th>
                                            <th class="account__table--header__child--items">Amount</th>	 	 	
                                           
                                            <th class="account__table--header__child--items">Request Status</th>
                                            <th class="account__table--header__child--items"></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody class="account__table--body mobile__none">
                                       @foreach($order_data as $key => $item)
                                        <tr class="account__table--body__child">
                                            <td class="account__table--body__child--items">{{$item['order_id']}}</td>
                                            <td class="account__table--body__child--items">{{date('j F, Y, g:i a',strtotime($item['created_at']))}}</td>

                                            <td class="account__table--body__child--items">₹ {{$item['order_discount_amount']}}</td>

                                            <?php 
                                             $order_type = '';
                                             if($item['order_type']== 1){
                                                 $order_type ='pending';
                                             }
                                             else if($item['order_type'] == 2){
                                                 $order_type ='accepted';
                                             }
                                             else if($item['order_type'] == 3){
                                                 $order_type ='work in progress';
                                             }
                                             else if($item['order_type'] == 4){
                                                 $order_type ='completed';
                                             }
                                             else{
                                                 $order_type ='cancelled';
                                             }
                                            ?>

                                            <td class="account__table--body__child--items">{{$order_type}}</td>
                                          
                                            <td class="account__table--body__child--items">
                                            <a href="{{ url('orderdetails/'.$item['order_id']) }}" class="primary__btn">View</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>                              
                                </table>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </section>
        <!-- my account section end -->
    </main>
@include('layouts.footer')
@endsection
