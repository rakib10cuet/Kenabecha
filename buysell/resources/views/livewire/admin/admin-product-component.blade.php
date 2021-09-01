<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <style>
        nav svg{
            height: 20px;
        }
        nav .hidden{
            display: block !important;
        }
    </style>
    <div class="container" style="padding: 30px 0">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>All Products</h4>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('admin.addProduct')}}" class="btn btn-success pull-right">Add New Product</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                        @endif
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Sale Price</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key => $product)
                                    <tr>
                                        <td>{{$product->id}}</td>
                                        <td><img src="{{asset('assets/images/products')}}/{{$product->image}}" width="60"></td>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->stockStatus}}</td>
                                        <td>{{$product->regularPrice}}</td>
                                        <td>{{$product->salePrice}}</td>
                                        <td>{{$product->category->name}}</td>
                                        <td>{{$product->created_at}}</td>
                                        <td>
                                            <a href="{{route('admin.editProduct',['productSlug'=>$product->slug])}}"><i  class="fa fa-edit fa-2x"></i></a>
                                            <a href="#" onclick="confirm('Are You sure,You want to delete this Product?') || event.stopImmediatePropagation()" wire:click.prevent="deleteProduct({{$product->id}})" style="margin-left: 10px"><i class="fa fa-times fa-2x text-danger"></i></a>

                                        </td>
                                    </tr>
                                @endforeach()
                            </tbody>
                        </table>
                        {{$products->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
