<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="container" style="padding: 30px 0">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h1>Edit Slide</h1>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('admin.homeSlider')}}" class="btn btn-success pull-right">All Slides</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                        @endif
                        <form class="form-horizontal" enctype="multipart/form-data" wire:submit.prevent="updateSlider()">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Title</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Title" class="form-control input-md" wire:model="title">
                                    @error('title') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>   {{--Title--}}

                            <div class="form-group">
                                <label class="col-md-4 control-label">Subtitle</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Subtitle" class="form-control input-md" wire:model="subTitle">
                                    @error('subTitle') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>   {{--Subtitle--}}

                            <div class="form-group">
                                <label class="col-md-4 control-label">Price</label>
                                <div class="col-md-4">
                                    <input class="form-control input-md" placeholder="Price" wire:model="price">
                                    @error('price') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>  {{--Price--}}

                            <div class="form-group">
                                <label class="col-md-4 control-label">Link</label>
                                <div class="col-md-4">
                                    <input class="form-control input-md" placeholder="Link" wire:model="link">
                                    @error('link') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div>  {{--Link--}}

                            <div class="form-group">
                                <label class="col-md-4 control-label">Image</label>
                                <div class="col-md-4">
                                    <input type="file" class="input-file" wire:model="newimage">
                                    @if($newimage)
                                        <img src="{{$newimage->temporaryUrl()}}" width="120">
                                        @error('newimage') <p class="text-danger">{{$message}}</p>@enderror
                                    @else
                                        <img src="{{asset('assets/images/sliders')}}/{{$image}}" width="120">
                                    @endif
                                </div>
                            </div>   {{--Image--}}

                            <div class="form-group">
                                <label class="col-md-4 control-label">Status</label>
                                <div class="col-md-4">
                                    <select class="form-control input-md" wire:model="status">
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                    @error('status') <p class="text-danger">{{$message}}</p>@enderror
                                </div>
                            </div> {{--Status--}}

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
