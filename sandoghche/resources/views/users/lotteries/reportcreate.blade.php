@extends('users.layouts.app')

@section('title')
گزارش صندوق متخلف
@endsection
@section('title2')
گزارش صندوق متخلف
@endsection

@section('content')



<!-- page content -->
<div class="right_col" role="main">
    <div class="">


        {{-- <div class="page-title">
            <div class="title_left">
                <h3>ایجاد قرعه کشی جدید</h3>
            </div> --}}




        </div>
        <div class="clearfix"></div>
        <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>ثبت تخلف یا محتوای نامناسب
                            {{-- <small>امکان ویرایش صندوق پس از ایجاد وجود ندارد</small> --}}
                        </h2>
                        {{-- <ul class="nav navbar-right panel_toolbox">
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
                        </ul> --}}
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">


                    	@if ($errors->any()>0)
                        <div class="alert alert-danger">
                    		@foreach ($errors->all() as $error)
                    			<li>{{$error}}</li>
                    		@endforeach
                        </div>
                    	@endif


                        <br/>
                        <form method="POST"  action="{{ route('lottery.report.store') }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                        	@csrf
                            <input type="hidden" id="lottery_id" name="lottery_id" value="{{$lotteryId}}">


                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">عنوان
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="title" required="required" name="title"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>




                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">توضیحات

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<textarea class="form-control col-md-7 col-xs-12" id="description" name="description" ></textarea>

                                </div>
                            </div>


                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                                    <button type="submit" class="btn btn-success">ثبت تخلف</button>
                                    <a href="{{ route('home') }}" class="btn btn-warning">انصراف</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

<br>

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
