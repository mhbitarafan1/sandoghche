@extends('auth.layouts.master')

@section('content')
<div class="animate form">
  <section class="login_content">

    <div><img width="120" src="/users/build/images/logo/sandoghche.png" alt=""></div>

<form method="post" action="{{ route('login2') }}">
        @csrf
      <h1>کد فعالسازی</h1>
      <div>
            <input id="active_code" type="number"  class="form-control @error('active_code') is-invalid @enderror" name="active_code" required autocomplete="active_code" autofocus >

            @error('active_code')
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

          <a href="{{ route('show.activation.code') }}?phone_number={{$phoneNumber}}"
          class="to_register">ارسال مجدد رمز عبور</a>
        </p>
        @isset($dontSms)
           <span style="color:orange">*ارسال مجدد رمز عبور پس از ۲ دقیقه امکان پذیر می باشد</span>
        @endisset
        <div class="clearfix"></div>
        <br />

        <div>
            <h1>
                {{-- <i class="fa fa-briefcase"></i> --}}
                 صندوقچه</h1>
            {{-- <p>تمامی حقوق محفوظ. </p> --}}
          </div>
      </div>
    </form>







  </section>
</div>
@endsection
