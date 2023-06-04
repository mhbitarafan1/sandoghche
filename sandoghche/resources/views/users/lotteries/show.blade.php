@extends('users.layouts.app')


@section('title')
{{$lottery->name}}
@endsection
@section('title2')
{{ mb_substr($lottery->name,0,30) }}
@endsection



@section('content')

<div class="right_col" role="main">
    <div class="">
        {{-- <div class="page-title">
            <div class="title_left">
                <h3>قرعه کشی  {{$lottery->name}}
                    <small> طراحی</small>
                </h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="جست و جو برای...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">برو!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel" style="padding-left: 5px;padding-right: 5px;">

                    @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))
                    <div style="text-align: center;">
                        <div id="mediaad-v9RA2"></div>
                    </div>
                    @endif
                    {{-- <div class="x_title">
                        <h2>صندوق  {{$lottery->name}}</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
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

                    <div class="x_content" style="padding-left: 0px;padding-right: 0px;">

                        <div class="col-md-9 col-sm-9 col-xs-12 p-0">
{{--
                            <ul class="stats-overview">
                                <li>
                                    <span class="name"> بودجه تخمینی </span>
                                    <span class="value text-success"> 2300 </span>
                                </li>
                                <li>
                                    <span class="name"> مجموع پرداخت ها </span>
                                    <span class="value text-success"> 2000 </span>
                                </li>
                                <li class="hidden-phone">
                                    <span class="name"> تخمین مدت پروژه </span>
                                    <span class="value text-success"> 20 </span>
                                </li>
                            </ul>
                            <br> --}}



                            <div>


                                <div class="x_content">








                                    <div>
                                        {{$amIManager = false}}
                                        {{$amIMember = false}}
                                        @if ($amIManager = auth()->user()->id == $users->find($lotteryManagers->find($lottery->lottery_manager_id)->user_id)->id )
                                        @endif
                                        @if ($amIMember = $lotteryStocks->where('lottery_id',$lottery->id)->where('owner',auth()->user()->id)->all())

                                        @endif


                                           <div class="col-sm-12 col" >
                                               {{-- <h4 class="brief"><strong><i class="fa fa-caret-left"></i> اطلاعات صندوق :</strong></h4> --}}





                                           </div>

                               </div>







                               <div
                               {{-- class="panel-body"  --}}
                               style="display: inline;">

                                @if ($nextLot)
                                <div class="alert fade in " style="border: 2px solid #e6e9ed;margin-bottom: 5px;" >
                                <script>
                                    var end = new Date("{{$nextLot->time_holding}}");
                                    var now = new Date();
                                    // console.log(now > end);
                                    var _second = 1000;
                                    var _minute = _second * 60;
                                    var _hour = _minute * 60;
                                    var _day = _hour * 24;
                                    var timer;

                                    function showRemaining() {
                                        var now = new Date();
                                        var distance = end - now;
                                        if (distance < 0) {
                                            clearInterval(timer);
                                            document.getElementById('countdown').innerHTML = 'EXPIRED!';
                                            return;
                                        }
                                        var days = Math.floor(distance / _day);
                                        var hours = Math.floor((distance % _day) / _hour);
                                        var minutes = Math.floor((distance % _hour) / _minute);
                                        var seconds = Math.floor((distance % _minute) / _second);
                                        if (now < end ) {
                                            document.getElementById('countdown').innerHTML = '<i class="fa fa-clock-o"></i> &nbsp;&nbsp;';
                                            if (days != 0) {
                                                document.getElementById('countdown').innerHTML += days + ' روز ';
                                            }
                                            if (hours != 0) {
                                                document.getElementById('countdown').innerHTML += hours + ' ساعت ';
                                            }
                                            if (minutes != 0) {
                                                document.getElementById('countdown').innerHTML += minutes + ' دقیقه ';
                                            }
                                            document.getElementById('countdown').innerHTML += seconds + ' ثانیه';

                                        }
                                    }

                                    timer = setInterval(showRemaining, 1000);
                                </script>

                                {{-- <div class="" id="countdown"></div> --}}
                                <h4 class="text-center " > <i class="fa fa-ticket"></i> قرعه پیش رو  </h4>
                                <strong> <i class="fa fa-flash"></i> &nbsp;&nbsp;  قرعه شماره {{$nextLot->number}} </strong>
                                <br>



                                <strong> <i class="fa fa-calendar-o"></i> &nbsp; تاریخ برگزاری : </strong>   {{verta($nextLot->time_holding)->format('j %B %Y ساعت G')}}<br>

                                @isset($nextLot->log)
                                <div style="color: rgb(240, 198, 83)"><i class="fa fa-bell"></i>&nbsp;&nbsp;{{$nextLot->log}}</div>
                                @endisset

                                @if ($nextLot->time_holding < now() && $lottery->type_of_choose_winner == 'مدیر قرعه کشی' )
                                <div style="color: rgb(240, 198, 83)"><i class="fa fa-bell"></i>&nbsp;&nbsp;در انتظار انتخاب برنده توسط مدیر صندوق</div>
                                @endif

                                {{-- <strong> <i class="fa fa-money"></i> &nbsp; مبلغ قرعه : </strong>   {{number_format($nextLot->amount)}} تومان<br><br> --}}

                                {{-- <strong> <i class="fa fa-pie-chart"></i> &nbsp; سهام های بدهکار :</strong>

                                @foreach ($nextLot->installments as $installment)

                                @if ($installment->paid==0)

                                {{$stocks->find($installment->lottery_stock_id)->number}}
                                @endif
                                @endforeach --}}








                                @if (!$amIManager)
                                @if ($amIMember)
                                        @if ($lottery->type_of_choose_winner=='مدیر قرعه کشی' && $nextLot->time_holding < now())
                                            <span style="color: rgb(240, 198, 83)"><i class="fa fa-bell"></i>&nbsp;&nbsp;منتظر اعلام برنده توسط مدیر صندوق</span>
                                        @endif
                                {{-- <div class="text-center">
                                <input class="btn btn-warning btn-lg" type="submit" value="پرداخت قسط  این قرعه">
                                </div> --}}

                                @endif



                                @else


                                {{-- <form action="{{ route('installments.manage',$nextLot->id) }}">
                                    @csrf
                                    <div class="text-center"><br>
                                    <input class="btn btn-default btn-lg" type="submit" value="مدیریت اقساط این قرعه">
                                    </div>
                                </form> --}}



                                @if ($lottery->type_of_choose_winner=='مدیر قرعه کشی' && $nextLot->time_holding < now())
                                <br>
                                <form method="post" class="form-inline" action="{{ route('lots.choose.winner') }}">
                                    @csrf

                                    <input type="hidden" id="lot_id" name="lot_id" value="{{$nextLot->id}}">







                                    @if ($lottery->type_of_income=='firstlot' && $nextLot->number==1)


                                    @if ($firstManagerStock = $lottery->lotterystocks->where('owner',$lotteryManagerUserId)->first())
                                    <div><label for="winnerId">انتخاب و معرفی برنده قرعه  ی شماره {{$nextLot->number}}: </label></div>
                                    <div class="input-group">
                                        <select class="form-control" name="stock_winner" id="stock_winner">
                                            <option value="{{$firstManagerStock->id}}">سهام شماره ی {{$firstManagerStock->number}} متعلق به برگزار کننده ی قرعه کشی</option>
                                        </select>
                                        <span class="input-group-btn">
                                            <button onclick="return confirm('مطمئن هستید؟ \nدقت نمایید که پس از تایید امکان تغییر  برنده نمی باشد')" type="submit" class="btn btn-primary"><i class="fa fa-caret-left"></i> انتخاب  برنده</button>
                                        </span>
                                        @endif

                                        @else



                                        @if ($stocksDontWinned)

                                        @foreach ($stocksDontWinned as $stockDontWinned)
                                        @php
                                        $paidInstallments = $stockDontWinned->installments->where('lot_id','<=',$nextLot->id)->where('paid',true);
                                        @endphp


                                        @if(count($paidInstallments) >= $nextLot->number)
                                        @php
                                        $inclodedStocksOnLotId[] =  $stockDontWinned->id;
                                        @endphp

                                        @endif
                                        @endforeach
                                        @endif

                                        @if(isset($inclodedStocksOnLotId))
                                        <div><label for="winnerId">انتخاب و معرفی برنده قرعه  ی شماره {{$nextLot->number}}: </label></div>
                                        <div class="input-group">
                                            <select class="form-control" name="stock_winner" id="stock_winner">

                                                @foreach ($inclodedStocksOnLotId as $inclodedStockOnLotId)
                                                <option value="{{$inclodedStockOnLotId}}">سهام شماره ی {{$stocks->where('id',$inclodedStockOnLotId)->first()->number}} متعلق به
                                                    @if ($stockUserId= $stocks->where('id',$inclodedStockOnLotId)->first()->owner)
                                                    {{$users->find($stockUserId)->name}}
                                                    @else
                                                    هیچکس
                                                    @endif

                                                </option>
                                                @endforeach

                                            </select>
                                            <span class="input-group-btn">
                                                <button onclick="return confirm('مطمئن هستید؟ \nدقت نمایید که پس از تایید امکان تغییر  برنده نمی باشد')" type="submit" class="btn btn-primary"><i class="fa fa-caret-left"></i>انتخاب  برنده </button>
                                            </span>

                                        @else
                                            <span style="color:rgb(240, 198, 83);">* جهت انتخاب برنده ابتدا می بایست پرداخت اقساط اعضا را تایید نمایید</span>

                                            @endif









                                            @endif


                                        </div>

                                    </form>
                                    @endif


                                    @endif


                                </div>
                                 @endif

                                @if ($lastLot)







                                 <div class="alert fade in" style="border: 2px solid #e6e9ed;margin-bottom: 5px;">

                                    <h4 class="text-center " > <i class="fa fa-ticket"></i> قرعه قبلی  </h4>
                                <strong> <i class="fa fa-flash"></i> &nbsp;&nbsp;  قرعه شماره {{$lastLot->number}}   </strong>
                                <br>

                                <strong> <i class="fa fa-calendar-o"></i> &nbsp; تاریخ برگزاری : </strong>   {{verta($lastLot->time_holding)->format('j %B %Y ساعت G')}}<br>




                                    {{-- <strong>مبلغ قرعه: </strong>   {{number_format($lastLot->amount)}} تومان<br> --}}


                                    <strong><i class="fa fa-trophy"></i> &nbsp;&nbsp;برنده  :</strong>
                                    @if ($winnerStockId=$lastLot->stock_winner)
                                    سهام شماره
                                    {{$stocks->find($winnerStockId)->number}}

                                    @if($user= $users->find($stocks->find($winnerStockId)->owner))
                                     ({{$user->name}})
                                    @else
                                    (بی نام)
                                    @endif
                                    @else
                                    ...

                                    @endif<br>






                                    {{-- <strong>سهام های بدهکار:</strong>

                                    @foreach ($lastLot->installments as $installment)

                                    @if ($installment->paid==0)

                                    {{$stocks->find($installment->lottery_stock_id)->number}}
                                    @endif
                                    @endforeach --}}







                                    @if (!$amIManager)
                                    @if ($amIMember)

                                    {{-- <div class="text-center">
                                    <input class="btn btn-warning btn-lg" type="submit" value="پرداخت قسط  این قرعه">
                                    </div> --}}
                                    @endif



                                    @else


                                    <form  action="{{ route('installments.manage',$lastLot->id) }}">
                                        @csrf
                                        <div class="text-center"><br>
                                        <input class="btn btn-danger btn-lg" type="submit" value="مدیریت اقساط این قرعه">
                                        </div>
                                    </form>


                                    @endif




                                </div>

                                @endif


                            </div>










                                    @if (!$amIManager)

                                    @if ($myStockRequest)
                                        <div class="alert alert-warning d-flex align-items-center"
                                        style="padding-top:5px;padding-bottom:5px;">
                                            شما درخواست
                                            @if ($myStockRequest->type_of_request=='buy')
                                            خرید
                                            @else
                                            <strong>واگذاری</strong>
                                            @endif
                                            {{$myStockRequest->count_of_stock}} سهم داده اید .
                                            &nbsp;
                                            <form method="post" action="{{ route('stockrequests.destroy',$myStockRequest->id) }}">
                                                @csrf
                                                @method('delete')


                                                <input type="submit" class="btn btn-danger" name="no" value="انصراف">
                                            </form><br>

                                        </div>
                                    @endif



                                @else
                                                {{-- @if ($stockRequests->count()==0 and $lottery->status == 'در حال عضوگیری')
                                                    <div class="alert alert-warning d-flex align-items-center"
                                                    style="padding-top:5px;padding-bottom:5px;">
                                                    جهت افزودن اعضا به صندوق به بخش مدیریت سهام های صندوق بروید و یا با درخواست عضویت آنها موافقت نمایید.
                                                     </div>
                                                @endif --}}
                                        @foreach ($stockRequests as $stockRequest)
                                            <div class="alert alert-warning d-flex align-items-center"
                                            style="padding-top:5px;padding-bottom:5px;">
                                                <strong class="name_asker">{{$users->where('id',$lotteryMembers->where('id',$stockRequest->lottery_member_id)->first()->user_id)->first()->name}} </strong> &nbsp;&nbsp;&nbsp;
                                                <span>
                                                    با شماره تلفن
                                                    {{$users->where('id',$lotteryMembers->where('id',$stockRequest->lottery_member_id)->first()->user_id)->first()->phone_number}}
                                                    درخواست
                                                    @if ($stockRequest->type_of_request=='buy')
                                                    خرید
                                                    @else
                                                    <strong>واگذاری</strong>
                                                    @endif
                                                    {{$stockRequest->count_of_stock}} سهم دارد . آیا قبول می کنید :

                                                </span>
                                                &nbsp;
                                                <form class="" method="post" action="{{ route('stock.request.answer',$stockRequest->id) }}">
                                                    @csrf
                                                    <input type="submit" class="btn btn-success btn-sm-block" name="yes" value="بله">
                                                    <input type="submit" class="btn btn-danger btn-sm-block" name="no" value="خیر">
                                                </form><br>


                                            </div>
                                        @endforeach

                                @endif

























                                 <div class="clearfix"></div>














                                    </div>












                                    {{-- <h3> سهام های صندوق :</h3> --}}




{{--
                                      <!-- start accordion -->
                                      <div class="accordion" id="accordionOne" role="tablist" aria-multiselectable="true">
                                        @foreach ($stocks as $stock)
                                        <div class="panel"  id="stocksLocation">
                                            <button class="btn panel-heading mx-0  @if ($stock->number != 1)
                                                collapsed
                                            @endif" role="tab" id="headingOne{{$stock->number}}" data-toggle="collapse" data-parent="#accordionOne" data-href="#collapseOne{{$stock->number}}" aria-expanded="@if ($stock->number != 1)
                                                false
                                                @else
                                                true
                                                @endif" aria-controls="collapseOne{{$stock->number}}">
                                                <p class="panel-title">سهام {{$stock->number}} <i class="fa fa-caret-down"></i>
                                                    @if ($stock->owner)
                                                        به نام
                                                        {{$users->find($stock->owner)->name}}
                                                        @else
                                                        بی نام
                                                    @endif

                                                </p>
                                            </button>
                                            <div id="collapseOne{{$stock->number}}" class="panel-collapse collapse @if ($stock->number == 1)
                                                in
                                                @endif" role="tabpanel" aria-labelledby="headingOne{{$stock->number}}" >


                                                <div class="panel-body">

                                                    <strong>تعداد اقساط پرداخت شده : </strong>
                                                    {{count($stock->installments->where('paid',true))}} قسط <br><br>
                                                    <strong>مجموع پرداختی : </strong>
                                                    {{number_format($stock->total_payment)}} تومان <br><br>
                                                    <strong>قبلا برنده شده ؟ </strong>
                                                    @if ($stock->winned)
                                                    بله در قرعه ی شماره
                                                    {{$lots->where('stock_winner',$stock->id)->first()->number}}
                                                    @else
                                                    خیر
                                                    @endif
                                                    <br><br>

                                                    <strong>تعداد اقساط پرداختی : </strong>
                                                    {{count($stock->installments->where('paid',true))}} قسط

                                                    <br>

                                                    @if ($stock->owner)

                                                    @if ($amIManager)
                                                    <form class="text-left" method="post" action="{{ route('stocks.change.owner',$stock->id) }}">
                                                        <input class="btn btn-warning btn-sm" type="submit" value="لغو مالکیت  این سهام">
                                                        @csrf

                                                    </form>
                                                    @endif

                                                    @elseif($amIManager)
                                                    <form class="text-left" method="post" action="{{ route('add.stocks.for.manager',$stock->id) }}">
                                                        <input class="btn btn-info btn-sm" type="submit" value="برداشتن این سهم برای خودم">
                                                        @csrf

                                                    </form>

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                    <!-- end of accordion -->
 --}}







                                </div>


                            </div>

                            <!-- start project-detail sidebar -->
                            <div class="col-md-3 col-sm-3 col-xs-12">

                                <section class="panel">


                                    <div class="panel-body" style="padding: 5px;">





















                                        <a style="margin-right:0px;font-size: 17px; " href="{{ route('stocks.lottery.index',$lottery->id) }}" class="btn btn-info  btn-block">
                                            <i class="fa fa-group"> </i>
                                            @if ($amIManager && $nextLot->number < 2 )  &nbsp;افزودن اعضاء @else  &nbsp;اعضای صندوق  @endif
                                        </a>
                                        <a style="margin-right:0px;font-size: 17px; " href="{{ route('lottery.info.show',$lottery->id)}}" class="btn btn-info  btn-block">
                                            <i class="fa fa-bank"> </i>  &nbsp;مشخصات صندوق
                                        </a>
                                        <a style="margin-right:0px;font-size: 17px; "
                                        href=" @if ($nextLot && $nextLot->number < 3) {{route('lots.withoutadvertise.show',$lottery->id)}} @else {{route('lots.show',$lottery->id)}} @endif " class="btn btn-info  btn-block">
                                            <i class="fa fa-flash"> </i>
                                            @if ($amIManager)&nbsp;قرعه ها و اقساط @else جزئیات قرعه ها @endif
                                        </a>
                                        {{-- <h3 class="green"><i class="fa fa-paint-brush"></i> عملیات ها</h3> --}}
                                        <div class="mtop20">
                                            @if (!$amIManager)
                                            @if($amIMember)


                                            <a style="margin-right:0px;font-size: 17px; " href="{{ route('stockrequests.create',[$lottery->id,'buy']) }}" class="btn btn-info  btn-block">
                                                <i class="fa fa-arrow-circle-up"> </i>  خرید سهام بیشتر
                                            </a>
                                            <a style="margin-right:0px;font-size: 17px; " href="{{ route('stockrequests.create',[$lottery->id,'sell']) }}"  class="btn btn-info  btn-block">
                                                <i class="fa fa-arrow-circle-down"> </i> واگذاری سهام
                                            </a>


                                            @else
                                            <a style="margin-right:0px;font-size: 17px; " href="{{ route('stockrequests.create',[$lottery->id,'buy']) }}" class="btn btn-info  btn-block">
                                                <i class="fa fa-plus"> </i>
                                                درخواست عضویت
                                            </a>
                                            @endif
                                            @else

                                            @if ($amIManager && $lottery->upgraded == false)
                                            <a style="margin-right:0px;font-size: 17px; " href="{{ route('lottery.upgrade.showpage',$lottery->id) }}" class="btn btn-info  btn-block">
                                                <i class="fa fa-plus-square"> </i>  &nbsp;ارتقاء صندوق
                                            </a>
                                            @endif

                                                @if ($lottery->status == 'در حال عضوگیری')
                                                <form method="post" class="" action="{{ route('lotteries.destroy',$lottery->id) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('مطمئن هستید؟ \nبعد از حذف دیگر امکان بازگردانی  اطلاعات نمی باشد')" class="btn btn-info btn-block"
                                                    style="display: inline-block;margin-right:0px;font-size: 17px; "  type="submit" value="delete"><i class="fa fa-trash"> </i>&nbsp; حذف صندوق</button>
                                                </form>
                                                @endif


                                            @endif


                                        </div>

                                        <br>

                                        <div class="project_detail">













                                            @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))
                                            <div style="text-align: center;">
                                            <div id="mediaad-MGAx2"></div>
                                            <div id="mediaad-DA6PP"></div>
                                            </div>
                                            @endif

                                            @if (!$amIManager)
                                            <br>
                                            <a href="{{route('lottery.report.create',$lottery->id)}}"><li class="fa fa-info-circle"></li> گزارش تخلف صندوق (محتوای نامناسب)</a>
                                            @endif

</div>


<br>















{{--

                                            <p class="title">شرکت مشتری</p>
                                            <p>شرکت مجازی</p>
                                            <p class="title">رهبر پروژه</p>
                                            <p>مرتضی کریمی</p>
                                        </div>

                                        <br>
                                        <h5>فایل های پروژه</h5>
                                        <ul class="list-unstyled project_files">
                                            <li><a href=""><i class="fa fa-file-word-o"></i>
                                            Functional-requirements.docx</a>
                                        </li>
                                        <li><a href=""><i class="fa fa-file-pdf-o"></i> UAT.pdf</a>
                                        </li>
                                        <li><a href=""><i class="fa fa-mail-forward"></i> Email-from-flatbal.mln</a>
                                        </li>
                                        <li><a href=""><i class="fa fa-picture-o"></i> Logo.png</a>
                                        </li>
                                        <li><a href=""><i class="fa fa-file-word-o"></i> Contract-10_12_2014.docx</a>
                                        </li>
                                    </ul>
                                    <br> --}}


                                </div>

                            </section>

                        </div>
                        <!-- end project-detail sidebar -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
