@extends('users.layouts.app')


@section('title')
مشخصات صندوق {{$lottery->name}}
@endsection
@section('title2')
{{$lottery->name}}
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
                                               <h4 class="brief"><strong><i class="fa fa-caret-left"></i> اطلاعات صندوق :</strong></h4>
                                               <div style="padding-left: 0px;">
                                                   {{-- <h2>{{$lottery->count_of_lots}} قسطی</h2> --}}
                                                   <p><i class="fa fa-briefcase"></i>&nbsp;&nbsp;&nbsp;<strong>مدیریت :</strong>
                                                    {{$users->find($lotteryManagers->find($lottery->lottery_manager_id)->user_id)->name}}</p>
                                                    <p><i class="fa fa-medkit"></i>&nbsp;&nbsp;&nbsp;<strong>مبلغ وام : </strong>{{number_format($lottery->amount)}} تومان</p>
                                                        <p><i class="fa fa-money"></i>&nbsp;&nbsp;&nbsp;<strong>قسط {{$lottery->cycle}} :</strong> {{number_format($lottery->amount/$lottery->count_of_lots)}} تومان</p>
                                                            <p><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;<strong>شروع : </strong>
                                                       {{verta($lottery->time_of_first_lot)->format('j %B %Y ساعت G')}}
                                                    </p>

                                                   <p><i class="fa fa-trophy"></i>&nbsp;&nbsp;&nbsp;<strong>نحوه قرعه کشی :</strong> توسط
                                                      {{$lottery->type_of_choose_winner}}
                                                    </p>
                                                    {{-- <strong>تعداد سهام باقیمانده:</strong>
                                                        {{count($lottery->lotterystocks->where('owner',null))}}
                                                     سهم<br> --}}
                                                     <p><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;<strong>توضیحات :</strong> {{$lottery->short_description}}
                                                     </p>
                                                   @if($lottery->type_of_income!='none')
                                                       <i class='text-danger' >*قرعه ی اول برای مدیر می باشد.</i><br>
                                                   @endif





                                              {{-- <img
                                                  @if ($imgSrc=$users->where('id',$lotteryManagers->find($lottery->lottery_manager_id)->user_id)->first()->avatar_url)
                                                    src="{{$imgSrc}}"
                                                    @else
                                                     src="/users/build/images/profile/user.png"
                                                  @endif

                                                    alt="" class="img-circle img-responsive"> --}}



                                                    {{-- <strong>پیشرفت:</strong>
                                                    {{count($lottery->lots->where('stock_winner','!=',null))}}/{{count($lottery->lots)}}
                                                       <div class="progress progress_sm">
                                                        @if ($pastLots=count($lottery->lots->where('stock_winner','!=',0)))
                                                          @php
                                                            $percent=(count($lottery->lots->where('stock_winner','!=',null))/count($lottery->lots))*100;
                                                          @endphp
                                                          @if ($percent>70)
                                                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="{{$percent}}" style="width: {{$percent}}%;" aria-valuenow="{{$percent}}"></div>
                                                            @else
                                                            <div class="progress-bar bg-orange" role="progressbar" data-transitiongoal="{{$percent}}" style="width: {{$percent}}%;" aria-valuenow="{{$percent}}"></div>
                                                          @endif

                                                          @else

                                                          <div class="progress-bar bg-red" role="progressbar" data-transitiongoal="0" style="width: 0%;" aria-valuenow="0"></div>
                                                        @endif

                                                       </div> --}}


                                                       {{-- <p>
                                                       <span  class="label label-default">{{$lottery->status}}</span>
                                                      </p> --}}





                                                   <a style="margin-right:0px;font-size: 17px; " href="{{ route('lotteries.show',$lottery->id) }}" class="btn btn-info  btn-block">
                                                       <i class="fa fa-backward"> </i>
                                                       برگشت به صفحه صندوق
                                                   </a><br>


                                               </div>




                                           </div>

                               </div>










                                 <div class="clearfix"></div>









                                    </div>




                                    @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))
                                    <div style="text-align: center;">
                                        <div id="mediaad-5kvJR" ></div>
                                    </div>
                                     @endif






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










                                        <div class="project_detail">














{{--                                            <div id="pos-article-display-75024"></div>--}}














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
