<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="container" style="padding: 30px 0">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Manage Home Categories
                    </div>
                    <div class="panel-body">
                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                        @endif
                        <form class="form-horizontal" wire:submit.prevent="updateHomeCategory">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Choose Categories</label>
                                <div class="col-md-4" wire:ignore>
                                    <label>
                                        <select class="form-control sel-categories" name="categories[]" multiple="multiple" wire:model="selectedCategories">
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('selectedCategories') <p class="text-danger">{{$message}}</p>@enderror
                                    </label>
                                </div>
                            </div>   {{--Choose Categories--}}

                            <div class="form-group">
                                <label class="col-md-4 control-label">No of Products</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="No of Products" class="form-control input-md" wire:model="numberOfProducts">
                                    @error('numberOfProducts') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>   {{--No of Products--}}

                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
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
<script>
    $(document).ready(function () {
        $('.sel-categories').select2();
        $('.sel-categories').on('change',function (ev) {
            var data = $('.sel-categories').select2("val");
            @this.set('selectedCategories',data);
        });
    })
</script>
@endpush

