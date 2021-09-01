<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="container" style="padding: 30px 0">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="height: 50px">
                        <div class="col-lg-2">
                            <h4 style="margin-top: 5px">Ordered Details</h4>
                        </div>
                        <div class="col-lg-10">
                            <a href="{{route('user.orders')}}" class="btn btn-success pull-right">My Orders</a>
                            @if($order->status == 'order')
                                <a href="#" wire:click.prevent="cancelOrder" style="margin-right: 20px" class="btn btn-warning pull-right">Cancel Orders</a>
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>Order Id</th>
                                <td>{{$order->id}}</td>
                                <th>Order Date</th>
                                <td>{{$order->created_at}}</td>
                                <th>Status</th>
                                <td>{{$order->status}}</td>
                                @if($order->status == 'delivered')
                                    <th>Delivered Date</th>
                                    <td>{{$order->deliveredDate}}</td>
                                @elseif($order->status == 'delivered')
                                    <th>Cancellation Date</th>
                                    <td>{{$order->cancelledDate}}</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="height: 50px">
                        <div class="col-lg-2">
                            <h4 style="margin-top: 5px">Ordered Items</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="wrap-iten-in-cart">
                            <h3 class="box-title">Products Name</h3>
                            <ul class="products-cart">
                                @foreach($order->OrderItems as $item)
                                    <li class="pr-cart-item">
                                        <div class="product-image">
                                            <figure><img src="{{asset('assets/images/products')}}/{{$item->product->image}}" alt="{{$item->product->name}}"></figure>
                                        </div>
                                        <div class="product-name">
                                            <a class="link-to-product" href="{{route('product.details',['slug'=>$item->product->slug])}}">{{$item->product->name}}</a>
                                        </div>
                                        <div class="price-field produtc-price"><p class="price">${{$item->price}}</p></div>
                                        <div class="quantity">
                                            <h5>{{$item->quantity}}</h5>
                                        </div>
                                        <div class="price-field sub-total"><p class="price">${{$item->price * $item->quantity}}</p></div>

                                        @if($order->status == 'delivered' && $item->rstatus == false)
                                            <div class="price-field sub-total"><p class="price"><a href="{{route('user.review',['orderItemId'=>$item->id])}}">Write Review</a></p></div>
                                        @endif

                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="summary">
                            <div class="order-summary">
                                <h4 class="title-box">Order Summary</h4>
                                <p class="summary-info"><span class="title">Subtotal</span><b class="index">${{$order->subtotal}}</b></p>
                                <p class="summary-info"><span class="title">Tax</span><b class="index">${{$order->tax}}</b></p>
                                <p class="summary-info"><span class="title">Shipping</span><b class="index">Free Shipping</b></p>
                                <p class="summary-info"><span class="title">Total</span><b class="index">${{$order->total}}</b></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="height: 50px">
                        <div class="col-lg-2">
                            <h4 style="margin-top: 5px">Billing Details</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>First Name</th>
                                <td>{{$order->firstName}}</td>
                                <th>Last Name</th>
                                <td>{{$order->lastName}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{$order->email}}</td>
                                <th>Mobile</th>
                                <td>{{$order->mobile}}</td>
                            </tr>
                            <tr>
                                <th>Line1</th>
                                <td>{{$order->line1}}</td>
                                <th>Line2</th>
                                <td>{{$order->line2}}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{$order->city}}</td>
                                <th>Province</th>
                                <td>{{$order->province}}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{$order->country}}</td>
                                <th>Zipcode</th>
                                <td>{{$order->zipcode}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if($order->isShippingDifferent)
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="height: 50px">
                            <div class="col-lg-2">
                                <h4 style="margin-top: 5px">Shipping Details</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th>First Name</th>
                                    <td>{{$order->shipping->firstName}}</td>
                                    <th>Last Name</th>
                                    <td>{{$order->shipping->lastName}}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{$order->shipping->email}}</td>
                                    <th>Mobile</th>
                                    <td>{{$order->shipping->mobile}}</td>
                                </tr>
                                <tr>
                                    <th>Line1</th>
                                    <td>{{$order->shipping->line1}}</td>
                                    <th>Line2</th>
                                    <td>{{$order->shipping->line2}}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{$order->shipping->city}}</td>
                                    <th>Province</th>
                                    <td>{{$order->shipping->province}}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{$order->shipping->country}}</td>
                                    <th>Zipcode</th>
                                    <td>{{$order->shipping->zipcode}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="height: 50px">
                        <div class="col-lg-2">
                            <h4 style="margin-top: 5px">Transaction</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>Transaction Mode</th>
                                <td>{{$order->transaction->mode == 'cod' ? 'Cash On Delivery' : $order->transaction->mode}}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{$order->transaction->status}}</td>
                            </tr>
                            <tr>
                                <th>Transaction Date</th>
                                <td>{{$order->transaction->created_at}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
