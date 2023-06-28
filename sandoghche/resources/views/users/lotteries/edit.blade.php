@extends('users.layouts.app')

@section('title')
    ویرایش صندوق
@endsection
@section('title2')
    ویرایش صندوق
@endsection
@section('content')



    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            {{-- <div class="page-title">
                <div class="title_left">
                    <h3>ویرایش پروفایل</h3>
                </div>




            </div> --}}
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>مشخصات شما
                                {{-- <small>فرم را با دقت پر نمایید</small> --}}
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
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            @endif


                            <br/>
                            <form method="POST"  action="{{ route('lotteries.update',$lottery->id) }}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">نام صندوق
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="name" required="required" name="name"
                                               class="form-control col-md-7 col-xs-12" value="{{$lottery->name}} " disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="short_description">توضیحات کوتاه

                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea class="form-control col-md-7 col-xs-12" id="short_description" name="short_description">{{$lottery->short_description}}</textarea>

                                    </div>
                                </div>






                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                                        <button type="submit" class="btn btn-success">ذخیره</button>

                                        <a href="{{ route('lotteries.show',$lottery->id) }}" class="btn btn-warning">انصراف</a>
                                    </div>
                                </div>

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
