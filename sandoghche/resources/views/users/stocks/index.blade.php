@extends('users.layouts.app')


@section('title')
سهام های صندوق
@endsection
@section('title2')
سهام های صندوق
@endsection
@section('content')
<!-- page content -->


<div class="right_col" role="main">
    <div class="">


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="padding-left: 5px;padding-right: 5px;">
                    {{-- <div class="x_title">
                        <h2>سهام های صندوق
                            {{$lottery->name}}
                            <small>واریزها و برداشت ها</small>

                        </h2>
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
{{--                                    <div style="text-align: center;">--}}
{{--                                        <div id="mediaad-Eg4Yg" ></div>--}}
{{--                                    </div>--}}
{{--                                     @endif--}}


                    <div class="x_content" style="padding-left: 0px;padding-right: 0px;">

                        <div class="panel-body" style="padding: 5px;">








                            <div class="col-md-12 col-sm-12 col-xs-12" >
                                <div>


                                     <div class="x_title">
                                        <h2>
                                            اعضای صندوق
                                        </h2>

                                        <div class="clearfix"></div>
                                    </div>

                                    @if($amIManager && $nextLot && $nextLot->number <= 2)
                                        <div style="color: #393">
                                            <p>* در این قسمت می توانید اعضا را مدیریت نمایید. با افزودن اعضا پیامک های اطلاع رسانی برایشان ارسال شده و با وارد شدن به حساب کاربری خود می توانند اطلاعات صندوق را مشاهده نمایند.</p>
                                        </div>
                                    @endif


                                    <ul class="list-unstyled top_profiles scroll-view">
                                        @foreach ($stocks as $stock)
                                        <li class="media event">
                                            <a class="pull-left

                                            @if ($nextLot and $nextLot->installments->where('lottery_stock_id',$stock->id)->first()->paid)
                                            border-green
                                            @elseif(!$nextLot and $lastLot->installments->where('lottery_stock_id',$stock->id)->first()->paid)
                                            border-green
                                            @elseif($lastLot and $lastLot->installments->where('lottery_stock_id',$stock->id)->first()->paid)
                                            border-aero
                                            @elseif(!$lastLot and $nextLot->installments->where('lottery_stock_id',$stock->id)->first()->paid)
                                            border-green
                                            @elseif(!$lastLot and !$nextLot->installments->where('lottery_stock_id',$stock->id)->first()->paid)
                                            border-aero
                                            @else
                                            border-red
                                            @endif
                                                profile_thumb">
                                                <img style="margin-top: -9px;margin-right:-12px;"
                                                width="44"

                                                @if ($stock->owner == null)
                                                    src="/users/build/images/lotterystock/binam.png"

                                                @elseif ($users->where('id',$stock->owner)->first()->avatar_url == null)
                                                    src="/users/build/images/profile/user.png"
                                                @else
                                                    src="{{$users->where('id',$stock->owner)->first()->avatar_url}}"
                                                @endif

                                                 alt="" class="img-circle ">

                                            </a>
                                            <div class="media-body">

                                                <a class="title" href="#">سهام {{$stock->number}} <i class="fa fa-caret-left"></i>
                                                        @if ($stock->owner)
                                                            به نام
                                                            {{$users->find($stock->owner)->name}}
                                                            @else
                                                            بی نام
                                                        @endif

                                                </a><br>

                                                {{-- <strong>تعداد اقساط پرداخت شده : </strong>
                                                {{count($stock->installments->where('paid',true))}} قسط <br> --}}
                                                مجموع پرداختی :
                                                {{number_format($stock->total_payment)}} تومان <br>
                                                {{-- <strong>قبلا برنده شده ؟ </strong> --}}
                                                @if ($stock->winned)
                                                <span style="color: #393">
                                                برنده شده در قرعه ی شماره
                                                {{$lots->where('stock_winner',$stock->id)->first()->number}}
                                                </span>
                                                @else
                                                <span style="color: #923">هنوز برنده نشده !</span>
                                                @endif
                                                <br>

                                                {{-- <strong>تعداد اقساط پرداختی : </strong>
                                                {{count($stock->installments->where('paid',true))}} قسط --}}



                                                @if ($stock->owner)

                                                @if ($amIManager)
                                                <form class="text-left" method="post" action="{{ route('stocks.change.owner',$stock->id) }}">
                                                    <input   class="btn btn-danger btn-sm" type="submit" value="لغو مالکیت این سهم ">
                                                    @csrf

                                                </form>
                                                @endif

                                                @elseif($amIManager)
                                                {{-- <form class="text-left" method="post" action="{{ route('add.stocks.for.manager',$stock->id) }}">
                                                    <input class="btn btn-info btn-sm" type="submit" value="این سهم برای خودم">
                                                    @csrf
                                                </form> --}}

                                                <form class="text-left" method="post" action="{{ route('add.stocks.for.member',$stock->id) }}">




                                                    <div class="form-group">

                                                        <div class="col-md-5 col-sm-4 col-xs-4" style="padding-left: 0px;">
                                                            <input id="name" type="text" class="form-control" name="name" required  placeholder="نام و فامیلی" style="border-bottom-right-radius: 4px;
                                                            border-top-right-radius: 4px;padding-left: 3px;padding-right: 3px;" >
                                                        </div>

                                                        <div class="col-md-7 col-sm-8 col-xs-8" style="padding-right: 0px;" >
                                                            <div class="input-group" style="z-index: 0;">
                                                                <input type="tel" pattern="[0,۰]{1}[0-9,۰-۹]{10}" id="phone_number" name="phone_number" class="form-control" style="border-bottom-right-radius: 0px;
                                                                border-top-right-radius: 0px;padding-left: 3px;padding-right: 3px;"  required  placeholder="تلفن 09xxxxx">
                                                                <span class="input-group-btn">
                                                                    <input type="submit" class="btn btn-primary" style="padding-left: 5px;padding-right: 5px;" value=" + افزودن">
                                                                </span>
                                                            </div>                                                                            </div>



                                                    </div>

                                                    @csrf
                                                </form>

                                                @endif


                                            </div>
                                        </li>
                                        @endforeach

                                    </ul>



                                </div>
                            </div>



                            <div style="color: #393">
                                <p>* حتما می بایست پرداخت اقساط اعضا تایید شود تا در قرعه کشی پیش رو شرکت داده شوند.
                                    @if($amIManager && $nextLot && $nextLot->number <= 2)
                                        جهت مدیریت اقساط وارد صفحه قرعه ها و اقساط شوید. </p>
                                @endif
                            </div>
                            <a style="margin-right:0px;font-size: 17px; "
                               href=" @if ($nextLot && $nextLot->number < 3) {{route('lots.withoutadvertise.show',$lottery->id)}} @else {{route('lots.show',$lottery->id)}} @endif " class="btn btn-info  btn-block">
                                <i class="fa fa-backward"> </i>
                                قرعه ها و اقساط
                            </a>
                            <a style="margin-right:0px;font-size: 17px; " href="{{ route('lotteries.show',$lottery->id) }}" class="btn btn-info  btn-block">
                                <i class="fa fa-backward"> </i>
                                رفتن به صفحه صندوق
                            </a>


                            @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))
                                    <div style="text-align: center;">
                                        <div id="mediaad-1dp6B" ></div>
                                        <div id="mediaad-45Wnr" ></div>
                                    </div>
                            @endif


                            <br><br>

















                                </div>
                            </div>

















                        </div>







                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- /page content -->
@endsection
