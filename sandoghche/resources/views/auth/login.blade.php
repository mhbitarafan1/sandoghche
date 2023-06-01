@extends('auth.layouts.master')

@section('content')
<div class="animate form">
  <section class="login_content">


    <div><img width="120" src="/users/build/images/logo/sandoghche.png" alt=""></div>






<form method="get" action="{{ route('show.activation.code') }}">

      <h1>شماره تلفن همراه</h1>
      <div>
            <input id="phone_number" type="tel" pattern="[0,۰]{1}[0-9,۰-۹]{10}" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number" autofocus placeholder="09xxxxxxxxx">

            @error('phone_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror


      </div>
<br>
      <div>
        <button class="btn btn-primary submit">ورود</button>

      </div>




      <div class="clearfix"></div>

      <div class="separator">
        <p class="change_link">
          <a href="{{ route('register') }}" class="to_register" style="color: blue">ثبت نام</a>
        </p>

        <div class="clearfix"></div>
        <br>

        {{-- <div>
          <h1><i class="fa fa-briefcase"></i> صندوقچه</h1>
          <p>تمامی حقوق محفوظ. </p>
        </div> --}}


      </div>


    </form>







  </section>
</div>
@endsection
