<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="container" style="padding: 30px 0">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Edit Product</h4>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('admin.product')}}" class="btn btn-success pull-right">All Products</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                        @endif
                        <form class="form-horizontal" enctype="multipart/form-data" wire:submit.prevent="updateProduct">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Product Name</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Product Name" class="form-control input-md" wire:model="name" wire:keyup="generateSlug">
                                    @error('name') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>   {{--Product Name--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Product Slug</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Product Slug" class="form-control input-md" wire:model="slug">
                                    @error('slug') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>   {{--Product Slug--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Short Description</label>
                                <div class="col-md-4">
                                    <textarea class="form-control input-md" id="shortDescription" placeholder="Short Description" wire:model="shortDescription"></textarea>
                                    @error('shortDescription') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>  {{--Short Description--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Description</label>
                                <div class="col-md-4">
                                    <textarea class="form-control input-md" id="description" placeholder="Description" wire:model="description"></textarea>
                                    @error('description') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>  {{--Description--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Product Price</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Product Price" class="form-control input-md" wire:model="regularPrice">
                                    @error('regularPrice') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>  {{--Product Price--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Sale Price</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Sale Price" class="form-control input-md" wire:model="salePrice">
                                    @error('salePrice') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>  {{--Sale Price--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label">SKU</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="SKU" class="form-control input-md" wire:model="SKU">
                                    @error('SKU') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>  {{--SKU--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Stock</label>
                                <div class="col-md-4">
                                    <select class="form-control input-md" wire:model="stockStatus">
                                        <option value="instock">Instock</option>
                                        <option value="outofstock">Out of stock</option>
                                    </select>
                                    @error('stockStatus') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div> {{--Stock--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Featured</label>
                                <div class="col-md-4">
                                    <select class="form-control input-md" wire:model="featured">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div> {{--Featured--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Quantity</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Quantity" class="form-control input-md" wire:model="quantity">
                                    @error('quantity') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>   {{--Quantity--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Product Image</label>
                                <div class="col-md-4">
                                    <input type="file" class="input-file" wire:model="newimage">
                                    @if($newimage)
                                        <img src="{{$newimage->temporaryUrl()}}" width="120">
                                        @error('newimage') <p class="text-danger">{{$message}}</p>@enderror
                                    @else
                                        <img src="{{asset('assets/images/products')}}/{{$image}}" width="120">
                                    @endif

                                </div>
                            </div>   {{--Product Image--}}

                            <div class="form-group">
                                <label class="col-md-4 control-label">Product Gallery</label>
                                <div class="col-md-4">
                                    <input type="file" class="input-file" wire:model="newimages" multiple>
                                    @if($newimages)
                                        @foreach($newimages as $newimg)
                                            <img src="{{$newimg->temporaryUrl()}}" width="120">
                                        @endforeach
{{--                                        @error('newimages') <p class="text-danger">{{$message}}</p>@enderror--}}
                                    @else
                                        @if(!empty($images))
                                            @foreach($images as $img)
                                                <img src="{{asset('assets/images/products')}}/{{$img}}" width="120">
                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                            </div>   {{--Product Gallery--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Category</label>
                                <div class="col-md-4">
                                    <select class="form-control input-md" wire:model="categoryId">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('categoryId') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div> {{--Category--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        /*date time er kaj ta solve korte hobe*/
        $(document).ready(function () {
            tinymce.init({
                selector: '#shortDescription',
                setup: function (editor) {
                    editor.on('change',function (e) {
                        tinyMCE.triggerSave();
                        var sd_data = $('#shortDescription').val();
                    @this.set('shortDescription',sd_data);
                    })
                }
            });
            tinymce.init({
                selector: '#description',
                setup: function (editor) {
                    editor.on('change',function (e) {
                        tinyMCE.triggerSave();
                        var d_data = $('#description').val();
                    @this.set('description',d_data);
                    })
                }
            });
        });
    </script>
@endpush
