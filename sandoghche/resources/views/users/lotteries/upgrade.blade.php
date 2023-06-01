@extends('users.layouts.app')


@section('title')
ارتقاء امکانات صندوق
@endsection
@section('title2')
ارتقاء امکانات صندوق
@endsection

@section('content')
<!-- page content -->


<div class="right_col" role="main">
    <div class="">


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                    ارتقاء صندوق {{$lottery->name}}
                    </div>
                    <div class="x_content">











<p style="font-size: 14px;text-align: justify;">
    {{-- <strong> نسخه رایگان:</strong><br> --}}
    {{-- استفاده از امکانات برنامه  رایگان بوده و سیاست صندوقچه بر این است تا بیشتر هزینه ها را از طریق تبلیغات درون برنامه ای تامین نماید.
    <br>

    صرفا تعداد محدودی از امکانات که در پایین مشاهده می نمایید غیررایگان بوده و در صورت تمایل می توانید نسخه کامل را تهیه نمایید.
    <br><br> --}}
    <strong>امکانات نسخه رایگان :</strong><br>
    <i class="fa fa-check blue" ></i> ایجاد،مدیریت و برگزاری صندوق وام فامیلی<br>
    <i class="fa fa-check blue" ></i> ثبت اطلاعات پرداختی اقساط اعضا<br>
    <i class="fa fa-check blue" ></i> امکان اجرای قرعه کشی تصادفی توسط سیستم<br>
    <i class="fa fa-check blue" ></i> اطلاع اعضای صندوق از وضعیت پرداخت سایر اعضا <br>
    <i class="fa fa-check blue" ></i> افزودن اعضای صندوق تا ۱۰۰ نفر<br>
    <i class="fa fa-check blue"></i> نمایش خلاصه عملکرد مالی<br>
    <strong>امکانات نسخه ارتقا یافته :</strong><br>
    <i class="fa fa-check green"></i> تمامی امکانات نسخه رایگان<br>
    <i class="fa fa-check green" ></i> اطلاع رسانی پیامکی تمام رویدادهای صندوق<br>
    <i class="fa fa-check green"></i> عدم نمایش اکثریت محتوای تبلیغاتی برنامه<br>
    <i class="fa fa-check green"></i> یادآوری اقساط به اعضا از طریق پیامک<br>
    <i class="fa fa-check green"></i> پشتیبانی (بکاپ) از اطلاعات صندوق<br>
    <i class="fa fa-check green"></i> پاسخگویی ۲۴ ساعته از قسمت پشتیبانی برنامه<br>
    <i class="fa fa-check green"></i> امکان گرفتن خروجی pdf از صندوق<br>
    {{-- <i class="fa fa-check green"></i> امکان استفاده از درگاه جهت پرداخت اقساط (به زودی)<br> --}}
    <span style="text-align: center" class="label label-primary">مبلغ قابل پرداخت برای کل دوره :

            @php
            $count = $lottery->count_of_lots;
            $cost = null;
            switch(true) {
                case $count <= 20: $cost = 50; break;
                case $count <= 40: $cost = 100; break;
                case $count <= 60: $cost = 150; break;
                case $count <= 80: $cost = 200; break;
                case $count <= 100: $cost = 250; break;
                default: $cost = 300; break;
            }
            @endphp

      {{$cost}}


        هزار تومان</span><br><br>

    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 text-center">
        <a style="margin-right:0px;" href="pay/{{$productId}}" class="btn btn-success ">
            <i class="fa fa-plus-square"> </i>  &nbsp;ارتقاء صندوق
        </a>
        <a style="margin-right:0px;" href="{{ URL::previous() }}" class="btn btn-warning ">
            <i class="fa fa-minus-square"> </i>  &nbsp;فعلا نه
        </a>
    </div>

</p>
<br><br><br><br>














                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- /page content -->
@endsection
