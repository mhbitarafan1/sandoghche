@extends('users.layouts.app')

@section('title')
دعوت از دوستان
@endsection
@section('title2')
دعوت از دوستان
@endsection

@section('content')



<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        {{-- <div class="page-title">
            <div class="title_left">
                <h3>
                	دعوت از دوستان
                </h3>
            </div>




        </div> --}}
        <div class="clearfix"></div>
        <div class="row" style="padding-top: 10px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    {{-- <div class="x_title">
                        <h2>دعوت از دوستان</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">تنظیمات 1</a>
                                    </li>
                                    <li><a href="#">تنظیمات 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div> --}}

{{--                    @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))--}}
{{--                        <div style="text-align: center;">--}}
{{--                            <div id="mediaad-qnVYz" ></div>--}}
{{--                        </div>--}}
{{--                    @endif--}}

                    <div class="x_content">
                        {{-- در این مرحله کافیست دوستان شما وارد صندوقچه شوند و درخواست عضویت در صندوق شما را ثبت نمایند.<br> --}}
                        اگر نمی خواهید خودتان اعضا را اضافه کنید دوستان خود را دعوت کنید و منتظر بمانید تا آنها وارد اپلیکیشن شوند و درخواست عضویت دهند.<br>

                    	@if ($errors->any()>0)
                        <div class="alert alert-danger">
                    		@foreach ($errors->all() as $error)
                    			<li>{{$error}}</li>
                    		@endforeach
                        </div>
                    	@endif


                        <br/>
                        <form method="POST"  action="{{ route('invite.friends.store') }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                        	@csrf


							 <input type="hidden" id="lotteryId" name="lotteryId" value="{{$lottery->id}}">




                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">نام صندوق
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="name" required="required" name="name"
                                           class="form-control col-md-7 col-xs-12" value="{{$lottery->name}}" readonly>
                                </div>
                            </div>




                            @for ($i = 1; $i <= 10; $i++)
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_number{{$i}}">شماره موبایل {{$i}}
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                           <input id="phone_number{{$i}}" type="tel" pattern="[0,۰]{1}[0-9,۰-۹]{10}" class="form-control @error('phone_number') is-invalid @enderror"
                                           name="phone_number{{$i}}"  placeholder="09xxxxxxxxx">
                                           @error('phone_number')
                                           <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                           </span>
                                       @enderror
                                </div>
                            </div>
                            @endfor






                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                                    <button type="submit" class="btn btn-success">ارسال دعوت</button>
                                    <a href="{{ route('my.lotteries') }}" class="btn btn-warning">تمایل ندارم</a>
                                </div>
                            </div>
                            <br><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<!-- /page content -->

@endsection

@section('scripts')
<script>
	function itpro(Number)
	  {
	       Number+= '';
	        Number= Number.replace(',', ''); Number= Number.replace(',', ''); Number= Number.replace(',', '');
	        Number= Number.replace(',', ''); Number= Number.replace(',', ''); Number= Number.replace(',', '');
	        x = Number.split('.');
	        y = x[0];
	        z= x.length > 1 ? '.' + x[1] : '';
	        var rgx = /(\d+)(\d{3})/;
	         while (rgx.test(y))
	          y= y.replace(rgx, '$1' + ',' + '$2');
	          return y+ z;
	  }

</script>

@endsection
