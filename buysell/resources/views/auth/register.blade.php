<x-guest-layout>
    <main id="main" class="main-site left-sidebar">
        <div class="container">
            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="/" class="link">home</a></li>
                    <li class="item-link"><span>Register</span></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 col-md-offset-3">
                    <div class=" main-content-area">
                        <div class="wrap-login-item ">
                            <div class="register-form form-item ">
                                <x-jet-validation-errors class="mb-4" />
                                <form class="form-stl" action="{{route('register')}}" name="frm-login" method="POST" >
                                    @csrf
                                    <fieldset class="wrap-title">
                                        <h3 class="form-title">Create an account</h3>
                                        <h4 class="form-subtitle">Personal information</h4>
                                    </fieldset>
                                    <fieldset class="wrap-input">
                                        <label for="frm-reg-lname">Name*</label>
                                        <input type="text" id="frm-reg-lname" name="name" placeholder="Your Name" required autofocus autocomplete="name">
                                    </fieldset>
                                    <fieldset class="wrap-input">
                                        <label for="frm-reg-email">Email Address*</label>
                                        <input type="email" id="frm-reg-email" name="email" placeholder="Email address" value="{{ old('email') }}">
                                    </fieldset>
                                    <fieldset class="wrap-input">
                                        <label for="frm-reg-email">Phone No:*</label>
                                        <input type="text" id="frm-reg-lname" name="phone" placeholder="Phone Number" value="{{ old('phone') }}">
                                    </fieldset>
                                    <fieldset class="wrap-input" style="margin-top: 16px; margin-bottom: 8px;">
                                        <label class="col-md-5 control-label" style="padding-left: 4px;">Authentication Level*</label>
                                        <div class="col-md-4" style="margin-top: 10px; margin-left: 80px;">
                                            <label>
                                                <select class="form-control input-md" name="utype" required>
                                                    <option value="">User Type:</option>
                                                    <option value="1">Admin</option>
                                                    <option value="2">Retailer</option>
                                                    <option value="3">User</option>
                                                </select>
                                            </label>
                                        </div>
                                    </fieldset>
                                    <fieldset class="wrap-input">
                                        <label class="col-md-4 control-label" style="padding-left: 4px;">Address</label>
                                        <input type="text" id="frm-reg-lname" name="address" placeholder="Address" value="{{ old('address') }}">
                                    </fieldset>
{{--                                    <fieldset class="wrap-input" style="margin-top: 16px; margin-bottom: 8px;">--}}
{{--                                        <label class="col-md-6 control-label" style="padding-left: 4px;">Profile Picture</label>--}}
{{--                                        <div class="col-md-4" style="margin-top: 14px;">--}}
{{--                                            <input type="file" class="input-file"  name="image" enctype="multipart/form-data">--}}
{{--                                            @if($image)--}}
{{--                                                <img src="{{$image->temporaryUrl()}}" width="120">--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </fieldset>--}}
                                    <fieldset class="wrap-title">
                                        <h3 class="form-title">Login Information</h3>
                                    </fieldset>
                                    <fieldset class="wrap-input item-width-in-half left-item ">
                                        <label for="frm-reg-pass">Password *</label>
                                        <input type="password" id="frm-reg-pass" name="password" placeholder="Password" required autocomplete="new-password">
                                    </fieldset>
                                    <fieldset class="wrap-input item-width-in-half ">
                                        <label for="frm-reg-cfpass">Confirm Password *</label>
                                        <input type="password" id="frm-reg-cfpass" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                                    </fieldset>
                                    <input type="submit" class="btn btn-sign" value="Register" name="register">
                                </form>
                            </div>
                        </div>
                    </div><!--end main products area-->
                </div>
            </div><!--end row-->

        </div><!--end container-->

    </main>
</x-guest-layout>
