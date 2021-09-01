<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="container" style="padding: 30px 0">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h1>All Slides</h1>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('admin.addHomeSlider')}}" class="btn btn-success pull-right">Add New Slide</a>
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
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Price</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($sliders as $key => $slider)
                                <tr>
                                    <td >{{$slider->id}}</td>
                                    <td><img src="{{asset('assets/images/sliders')}}/{{$slider->image}}" width="120"></td>
                                    <td>{{$slider->title}}</td>
                                    <td>{{$slider->subTitle}}</td>
                                    <td>{{$slider->price}}</td>
                                    <td>{{$slider->link}}</td>
                                    <td>{{$slider->status == 1 ? 'Active' : 'Inactive'}}</td>
                                    <td>{{$slider->created_at}}</td>
                                    <td>
                                        <a href="{{route('admin.editHomeSlider',['sliderId'=>$slider->id])}}"><i  class="fa fa-edit fa-2x"></i></a>
                                        <a href="#" onclick="confirm('Are You sure,You want to delete this Slide?') || event.stopImmediatePropagation()" wire:click.prevent="deleteHomeSlide({{$slider->id}})" style="margin-left: 10px"><i class="fa fa-times fa-2x text-danger"></i></a>
                                    </td>
                                </tr>
                            @endforeach()
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
