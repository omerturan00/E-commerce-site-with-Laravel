@extends('_inc.master')
@section('pageContent')
   @if(empty($emptyShoppingBagMessage) && !empty($carts))
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                    <tr>
                        <th>Resim</th>
                        <th>Ürünler</th>
                        <th>Fiyat</th>
                        <th>Adet</th>
                        <th>Ara Toplam</th>
                        <th>Sepetten Kaldır</th>
                    </tr>
                    </thead>
                    <tbody class="align-middle">
                    @php
                    $genelTotal = 0;
                    @endphp
                    @foreach($carts as $cart)
                        @php
                        $genelTotal += $cart['total'];
                        @endphp
                        <tr>
                        <td class="align-middle"><img src="{{$cart['image']}}" alt="" style="width: 50px;"> </td>
                        <td class="align-middle">{{$cart['name']}}</td>
                        <td class="align-middle">{{$cart['price']['discount_price']}}{{$cart['price']['currency_symbol']}}</td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <div class="input-group-btn">
                                    <a class="btn btn-sm btn-primary btn-minus"  href="{{route('shoppingBagDec', ['id' => $cart['id']])}}" data-id="{{$cart['id']}}">
                                        <i class="fa fa-minus"></i>
                                    </a>
                                </div>
                                <input type="text" disabled class="form-control form-control-sm bg-secondary border-0 text-center" value="{{$cart['quantity']}}">
                                <div class="input-group-btn">
                                    <a class="btn btn-sm btn-primary btn-plus"  href="{{route('shoppingBagInc', ['id' => $cart['id']])}}"  data-id="{{$cart['id']}}">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">{{$cart['total']}}{{$cart['price']['currency_symbol']}}</td>
                        <td class="align-middle"><a href="{{route('deleteToCart', ['id' => $cart['id']])}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Toplam</h5>
                            <h5>{{$genelTotal}}{{$cart['price']['currency_symbol']}}</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
                        <a href="{{route('shoppingBagReset')}}" class="btn btn-block btn-danger font-weight-bold my-3 py-3">Sepeti Boşalt</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
   @else
       <div class="container-fluid">
           <div class="row px-xl-5">
               <div class="col-12">
                   <nav class="breadcrumb bg-light mb-30">
                       {{$emptyShoppingBagMessage}}
                   </nav>
               </div>
           </div>
       </div>
   @endif
@endsection
@section('pageJs')
    <script>
        $(document).ready(function (){

        });
    </script>
@endsection
