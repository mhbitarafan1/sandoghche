@extends('auth.layouts.master')

@section('content')




<div class="animate form">
    <section class="login_content">

        <div><img width="120" src="/users/build/images/logo/sandoghche.png" alt=""></div>




            <form method="get" action="{{ route('show.activation.code2') }} ">

              <h1>ایجاد حساب</h1>
              <div>

                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="نام و نام خانوادگی" >

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror


              </div>
              <div>

                <input type="tel" pattern="[0,۰]{1}[0-9,۰-۹]{10}" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone-number') }}" required autocomplete="phone_number" placeholder="تلفن همراه 09xxxxxxxxx">

                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
<br>

              <div>
                <button type="submit" class="btn btn-primary">
                    ثبت نام
                </button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p>
                    ثبت نام به منزله پذیرش&nbsp;&nbsp; <a href="{{ route('policy') }}" style="color: blue">قوانین و مقررات</a> می باشد
                </p>
                <p class="change_link">در حال حاضر عضو هستید؟
                  <a href="{{ route('login') }}" class="to_register" style="color: blue"> ورود </a>
                </p>

                <div class="clearfix"></div>
                <br />

                {{-- <div>
                    <h1><i class="fa fa-briefcase"></i> صندوقچه</h1>
                    <p>تمامی حقوق محفوظ. </p>
                  </div> --}}


              </div>
            </form>







          </section>
        </div>



@endsection
