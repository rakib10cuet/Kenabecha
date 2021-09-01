<div class="container" style="padding: 30px 0" xmlns:wire="http://www.w3.org/1999/xhtml">
    <style>
        .avatar {
            height: 50px;
            width: 50px;
        }
        .list-group-item:hover, .list-group-item:focus {
            background: rgba(24,32,23,0.37);
            cursor: pointer;
        }
        .chatbox {
            height: 65vh !important;
            overflow-y: scroll;
        }
        .message-box {
            height: 55vh !important;
            overflow-y: scroll;display:flex; flex-direction:column-reverse;
        }
        .single-message {
            background: #f1f0f0;
            border-radius: 12px;
            padding: 10px;
            margin-bottom: 10px;
            width: fit-content;
        }
        .received {
            margin-right: auto !important;
        }
        .sent {
            margin-left: auto !important;
            background :#3490dc;
            color: white!important;
        }
        .sent small {
            color: white !important;
        }
        .link:hover {
            list-style: none !important;
            text-decoration: none;
        }
        .online-icon {
            font-size: 11px !important;
        }
        .left-bar{
            margin-top: -46px;
        }
        .main-message-part{
            margin-top: 18px;
            /*margin-bottom: 0;*/
        }
        .message-part{
            /*height: 300px;*/
            margin-top: -23px;
        }
        .message-part-heading{
            padding-bottom: 16px;
            color: #2d3748;
        }
        .left-bar-heading{
            background: #2d3748;
        }
        .left-bar-heading-text{
            color: white;
        }
        .chatbox-name{
            margin-right: 6px;
            margin-left: 6px;
        }
    </style>
    <div class="row main-message-part">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 left-bar">
            <div class="panel-heading left-bar-heading">
                <h4 class="left-bar-heading-text">Community</h4>
            </div>
            <div class="card-body chatbox p-0">
                <ul class="list-group list-group-flush">
                    @foreach($onlineUsers as $onlineUser)
                        @php
                            $not_seen = App\Models\Messages::where('userId',$onlineUser->id)->where('receiverId',auth()->id())->where('is_seen',false)->get();
                            $not_seen = empty($not_seen) ? null : $not_seen;
                        @endphp
                        <li class="list-group-item link" wire:click="getUser({{$onlineUser->id}})">
                            <img class="img-fluid avatar" src="https://cdn.pixabay.com/photo/2017/06/13/12/53/profile-2398782_1280.png">
                            <span class="chatbox-name">{{$onlineUser->name}}</span>
                            @if($onlineUser->onlineStatus == true)
                                <i class="fa fa-circle text-success online-icon"></i>
                            @endif
                            @if(filled($not_seen))
                                <div class="badge badge-success rounded"> {{$not_seen->count()}} </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 message-part">
            <div class="row">
                <div class="panel panel-default message-part">
                    <div class="panel-heading message-part-heading">
                        <div class="row">
                            <div class="col-md-6">
                                @if(isset($sender))
                                    <img class="img-fluid avatar" src="https://cdn.pixabay.com/photo/2017/06/13/12/53/profile-2398782_1280.png"><span class="chatbox-name">{{$sender->name}}</span><i class="fa fa-circle text-success online-icon"></i>
{{--                                   <a href="#" class="btn btn-success pull-left">{{$sender->name}}</a>--}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel-body message-box" wire:poll="mountdata">
                        @if(filled($allMessages))
                            @foreach($allMessages as $msg)
                                <div class="single-message @if($msg->userId === Auth()->id()) sent @else received @endif">
                                    <p class="font-weight-bolder my-0">{{$msg->user->name}}</p>
                                    {{$msg->message}}
                                    <br><small class="text-muted w-100">Sent <em>{{$msg->created_at}}</em></small>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="panel-footer">
                        <form class="form-horizontal" wire:submit.prevent="SendMessage">
                            <div class="row">
                                <div class="col-md-8">
                                    <textarea class="form-control input-md" id="messages" placeholder="Type a message" wire:model="message"></textarea>
                                </div>
                                <div class="col-md-4" wire:ignore>
                                    <button type="submit" class="btn btn-info" style="margin-top: 10px"><i class="fa fa-paper-plane"></i>Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--@push('scripts')--}}
{{--    <script type="text/javascript">--}}
{{--        $(document).ready(function () {--}}
{{--            tinymce.init({--}}
{{--                selector: '#messages',--}}
{{--                setup: function (editor) {--}}
{{--                    editor.on('change',function (e) {--}}
{{--                        tinyMCE.triggerSave();--}}
{{--                        var text_message = $('#messages').val();--}}
{{--                    @this.set('messages',text_message);--}}
{{--                    })--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}
