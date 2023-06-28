



@extends('users.layouts.app')


@section('title')
{{-- <img width="20" src="/users/build/images/logo/sandoghche.png" alt=""> --}}
صندوقچه
@endsection

@section('title2')
<img width="20" src="/users/build/images/logo/sandoghche.png" alt="">
صندوقچه
@endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">




        {{--
        <div class="page-title">
            <div class="col-md-6 col-sm-7 col-xs-12 form-group pull-right top_search">
                <a href="{{ route('lotteries.create') }}" type="button" class="btn btn-danger btn-lg"><li class="fa fa-plus"></li> ایجاد وام جدید</a>
            </div>
        </div>
        --}}



        {{-- <div class="page-title">
            <div class="title_left">
                <h3>قرعه کشی ها
                    <small>خانوادگی و دوستانه</small>
                </h3>

            </div>





                <div class="title_right">
                    <div class="col-md-6 col-sm-7 col-xs-12 form-group pull-right top_search">


                        <a href="{{ route('lotteries.create') }}" type="button" class="btn btn-danger btn-lg"><li class="fa fa-plus"></li>ایجاد </a>


                    </div>
                </div>







        </div> --}}

        <div class="clearfix"></div>







        @if (isset($justMyLotteries))
        <div class="row">

        <div class="col-md-12">

            <div class="x_panel" >



                <div class="x_content">

                    <div class="x_title">
                       <h2><strong>صندوق های من <span class="fa fa-sort-down"></span></strong></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                {{-- <div class="input-group form-group  top_search">
                                    <input type="text" class="form-control" placeholder="جستجو در قرعه کشی های من">
                                    <span class="input-group-btn">
                                  <button class="btn btn-default" type="button">بگرد!</button>
                                </span>
                                </div> --}}
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>


                    <div class="row">


                    <div class="col-md-12 col-sm-12 col-xs-12 text-center"></div>

                    <div class="clearfix"></div>
                    <div class="clearfix"></div>

                    @foreach ($myLotteries as $lottery)
                        {{$amIManager = false}}
                        {{$amIMember = false}}
                        @if ($amIManager = auth()->user()->id == $users->find($lotteryManagers->find($lottery->lottery_manager_id)->user_id)->id )
                        @endif
                        @if ($amIMember = $lotteryStocks->where('lottery_id',$lottery->id)->where('owner',auth()->user()->id)->all())

                        @endif

                                       <div class="col-md-6 col-sm-6 col-xs-12 profile_details" style="padding-left: 0px;padding-right: 0px;">
                                           <div class="well profile_view" style="margin-bottom:5px;">
                                               <a href="{{ route('lotteries.show',$lottery->id) }}"><div class="col-sm-12" >
                                                   <div class="left col-xs-8" style="padding-left: 0px;">
                                                    <h4 class="brief"><strong><i class="fa fa-caret-left"></i> {{$lottery->name}}</strong></h4><br>
                                                    {{-- <h2>{{$lottery->count_of_lots}} قسطی</h2> --}}

                                                       <p><strong>وام: </strong>{{number_format($lottery->amount)}} تومان</p>
                                                       <p><strong>{{$lottery->cycle}}</strong> {{number_format($lottery->amount/$lottery->count_of_lots)}} تومان</p>
                                                       <p><strong>شروع: </strong>
                                                           {{verta($lottery->time_of_first_lot)->format('j %B %Y ساعت G')}}
                                                       </p>
                                                       <p><strong>نقش شما:</strong>
                                                        @if ($amIManager && $amIMember)
                                                          مدیر و سهامدار
                                                          <p><strong>تعداد سهام  شما:</strong>
                                                              {{count($lottery->lotterystocks->where('owner',auth()->user()->id))}}
                                                           سهم</p>
                                                          @else
                                                           @if ($amIManager)
                                                            مدیر
                                                            <p><strong>تعداد سهام  شما:</strong>
                                                              0
                                                           سهم</p>
                                                          @endif
                                                           @if ($amIMember)
                                                             سهامدار
                                                             <p><strong>تعداد سهام  شما:</strong>
                                                                 {{count($lottery->lotterystocks->where('owner',auth()->user()->id))}}
                                                              سهم</p>
                                                           @endif

                                                        @endif


                                                      </p>
                                                      <p><strong>انجام قرعه کشی :</strong> توسط
                                                          {{$lottery->type_of_choose_winner}}
                                                       </p>
                                                        {{-- <p><strong>قابل خرید:</strong>
                                                            {{count($lottery->lotterystocks->where('owner',null))}}
                                                         سهم</p> --}}






                                                   </div>
                                                   <div class="right col-xs-4 text-center">


                                                  <img
                                                      @if ($imgSrc = $users->where('id',$lotteryManagers->find($lottery->lottery_manager_id)->user_id)->first()->avatar_url)
                                                        src="{{$imgSrc}}"
                                                        @else
                                                         src="/users/build/images/profile/user.png"
                                                      @endif


                                                        alt="" class="img-circle img-responsive"><strong>مدیریت:</strong><br>

                                                        {{$users->find($lotteryManagers->find($lottery->lottery_manager_id)->user_id)->name}}<br><strong>پیشرفت:</strong><br>
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




                                                           </div>
                                                           <p>
                                                           <span class="label label-default">{{$lottery->status}}</span>
                                                          </p>






                                                   </div>




                                               </div></a>
                                               <div class="col-xs-12 bottom text-center">
                                                   <div class="col-xs-4 col-sm-3 emphasis">
                                                       <p class="ratings">
                                                           <a>{{number_format($lottery->count_of_like )}}</</a>
                                                           <a href="{{ route('lotteries.like',$lottery->id) }}"><span class="fa fa-heart" style="display: inline-block;"></span></a>
                                                           <a>{{number_format($lottery->count_of_view)}}</a>
                                                           <span class="fa fa-eye" style="display: inline-block;"></span>

                                                       </p>
                                                   </div>
             <div class="col-xs-8 col-sm-9 emphasis">


                @if ($amIManager)
                  {{-- expr --}}

                                            <a href="{{ route('lotteries.show', [$lottery->id]) }}" style="font-size: 100%;" class="label label-info">
                                                <i class="fa fa-shopping-cart"> </i>ورود
                                            </a>&nbsp;
{{--                                            <a href="{{ route('invite.friends.create',[$lottery->id]) }}" style="font-size: 100%;" class="label label-warning">--}}
{{--                                                <i class="fa fa-send"> </i> دعوت دوستان--}}
{{--                                            </a>--}}
                     <a style="font-size: 100%;" class="label label-warning" href="{{ route('stocks.lottery.index',$lottery->id) }}" >
                         <i class="fa fa-group"> </i>
                         &nbsp;اعضای صندوق
                     </a>
                @else

                     <a href="{{ route('lotteries.show', [$lottery->id]) }}#stocksLocation" style="font-size: 100%;" class="label label-info">
                         <i class="fa fa-shopping-cart"> </i>ورود
                     </a>&nbsp;
{{--                 --}}
{{--                <a href="{{ route('stockrequests.create',[$lottery->id,'buy']) }}" style="font-size: 100%;" class="label label-primary">--}}
{{--                                                <i class="fa fa-arrow-circle-up"> </i>افزایش سهام--}}
{{--                                            </a>&nbsp;--}}
                <a href="{{ route('stockrequests.create',[$lottery->id,'sell']) }}" style="font-size: 100%;" class="label label-danger">
                                                <i class="fa fa-arrow-circle-down"> </i> واگذاری سهم
                                            </a>



                @endif
                                                   </div>
                                               </div>
                                           </div>
                                       </div>

                    @endforeach


                        @if(count($myLotteries)==0)
                            <div class="alert alert-warning">شما در هیچ صندوق قرعه کشی عضو نیستید!
                            <br><br><a href="{{ route('lotteries.create') }}" class="btn btn-primary center-block"><i class="fa fa-plus-circle"></i> ایجاد صندوق جدید</a>
                            </div>

                        @endif




                    </div>

                    <div style="text-align: center;"> {{$myLotteries->appends(['otherLotteries' => $otherLotteries->currentPage()])->links()}} </div>

                </div>






            </div>
        </div>


        </div>

        @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))
        <div id="pos-article-display-74594"></div>
        @endif
        <br><br>

        @else


                @if ($lotteryInvites)





                <div class="row">

                    <div class="col-md-12">
                        <div class="x_panel" >



                            <div class="x_content">

                                <div class="x_title">
                                    <h2><strong>صندوق های دعوت شده <span class="fa fa-sort-down"></strong></h2>
                                    {{-- <form method="POST" action="{{ route('lottery.search') }}">
                                        @csrf
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <div class="input-group form-group  top_search">
                                                <input  id="searchlottery" name="searchlottery" type="text" class="form-control" placeholder="نام قرعه کشی مورد نظر">
                                                <span class="input-group-btn">
                                              <button class="btn btn-default" type="submit">بگرد!</button>
                                            </span>
                                            </div>
                                        </li>
                                    </ul>
                                    </form> --}}

                                    <div class="clearfix"></div>
                                </div>


                                <div class="row">


                                <div class="col-md-12 col-sm-12 col-xs-12 text-center"></div>

                                <div class="clearfix"></div>




                                @foreach ($lotteryInvites as $lottery)



                                {{$amIManager = false}}
                                {{$amIMember = false}}
                                @if ($amIManager = auth()->user()->id == $users->find($lotteryManagers->find($lottery->lottery_manager_id)->user_id)->id )
                                @endif
                                @if ($amIMember = $lotteryStocks->where('lottery_id',$lottery->id)->where('owner',auth()->user()->id)->all())

                                @endif




                                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details" style="padding-left: 0px;padding-right: 0px;">
                                        <div class="well profile_view" style="margin-bottom:5px;">

                                            <a href="{{ route('lotteries.show',$lottery->id) }}"><div class="col-sm-12" >
                                                <div class="left col-xs-8" style="padding-left: 0px;">
                                                    <h4 class="brief"><strong><i class="fa fa-caret-left"></i> {{$lottery->name}}</strong></h4>
                                                    <div style="margin-top: 5px">
                                                        <span  class="label label-primary">{{$lottery->status}}</span>
                                                    </div>
                                                       <br>
                                                    <p><strong>وام: </strong>{{number_format($lottery->amount)}} تومان<br></p>
                                                    <p><strong>تعداد اقساط: </strong>{{$lottery->count_of_lots}} قسط</p>
                                                    {{-- <p><strong>{{$lottery->cycle}}</strong> {{number_format($lottery->amount/$lottery->count_of_lots)}} تومان</p> --}}
                                                    <p><strong>شروع: </strong>
                                                        {{verta($lottery->time_of_first_lot)->format('j %B %Y ساعت G')}}
                                                    </p>
                                                    {{-- <p><strong>تعداد قرعه انجام شده:</strong>
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

                                                       </div></p> --}}

                                                    <p><strong>قرعه کشی : </strong> توسط
                                                        {{$lottery->type_of_choose_winner}}
                                                     </p>
                                                    {{-- <p><strong>قابل خرید: </strong>
                                                        {{count($lottery->lotterystocks->where('owner',null))}}
                                                     سهم</p> --}}


                                                        <br>



                                                </div>
                                                <div class="right col-xs-4 text-center">
                                                    <img
                                                    @if ($imgSrc=$users->where('id',$lotteryManagers->find($lottery->lottery_manager_id)->user_id)->first()->avatar_url)
                                                      src="{{$imgSrc}}"
                                                      @else
                                                       src="/users/build/images/profile/user.png"
                                                    @endif

                                                     alt="" class="img-circle img-responsive">

                                                     <strong>مدیریت:</strong><br>
                                                        {{$users->find($lotteryManagers->find($lottery->lottery_manager_id)->user_id)->name}}

                                                        <br>
                                                        <div style="color: #f6c255;font-size: 0.78rem; ">
                                                            <li class="fa fa-star-o"></li>
                                                            <li class="fa fa-star-o"></li>
                                                            <li class="fa fa-star-o"></li>
                                                            <li class="fa fa-star-o"></li>
                                                            <li class="fa fa-star"></li>
                                                        </div>







                                                </div>




                                            </div></a>
                                            {{-- <div class="col-xs-12 bottom text-center">
                                                <div class="col-xs-4 col-sm-4 emphasis">
                                                  <p class="ratings">
                                                      <a>{{number_format($lottery->count_of_like )}}</</a>
                                                      <a href="{{ route('lotteries.like',$lottery->id) }}"><span class="fa fa-heart" style="display: inline-block;"></span></a>
                                                      <a>{{number_format($lottery->count_of_view)}}</a>
                                                      <span class="fa fa-eye" style="display: inline-block;"></span>

                                                  </p>


                                                </div>
                                                <div class="col-xs-8 col-sm-8 emphasis">

                                                    @if ($amIManager)
                                                      <a href="{{ route('lotteries.show', [$lottery->id]) }}#stocksLocation" style="font-size: 100%;" class="label label-info">
                                                            <i class="fa fa-shopping-cart"> </i> مدیریت سهام ها
                                                        </a>
                                                    @else

                                                        @if ($amIMember)
                                                        <a href="{{ route('stockrequests.create',[$lottery->id,'buy']) }}" style="font-size: 100%;" class="label label-primary">
                                                            <i class="fa fa-arrow-circle-up"> </i>افزایش سهام
                                                        </a>&nbsp;
                            <a href="{{ route('stockrequests.create',[$lottery->id,'sell']) }}" style="font-size: 100%;" class="label label-danger">
                                                            <i class="fa fa-arrow-circle-down"> </i> واگذاری
                                                        </a>
                                                        @else
                                                        <a href="{{ route('stockrequests.create',[$lottery->id,'buy']) }}" style="font-size: 100%;" class="label label-warning">
                                                              <i class="fa fa-shopping-cart"> </i>
                                                              درخواست عضویت
                                                          </a>
                                                      @endif
                                                    @endif


                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>


                                @endforeach


                                </div>

{{--                                <div style="text-align: center;">    {{$otherLotteries->appends(['myLotteries' => $myLotteries->currentPage()])->links()}}    </div>--}}


                            </div>




                        </div>
                    </div>


                    </div>







                @endif





















                    @if (isset($bestLotteries) && !isset($_GET['otherLotteries']))





                        <div class="row">

                            <div class="col-md-12">
                                <div class="x_panel" >



                                    <div class="x_content">

                                        <div class="x_title">
                                            {{-- <h2><strong>صندوق های برگزیده <span class="fa fa-sort-down"></strong></h2> --}}
                                            <form method="POST" action="{{ route('lottery.search') }}">
                                                @csrf
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li>
                                                        <div class="input-group form-group  top_search">
                                                            <input  id="searchlottery" name="searchlottery" type="text" class="form-control" placeholder="نام صندوق مورد نظر">
                                                            <span class="input-group-btn">
                                  <button class="btn btn-default" type="submit">بگرد!</button>
                                </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </form>

                                            <div class="clearfix"></div>
                                        </div>


                                        <div class="row">


                                            <div class="col-md-12 col-sm-12 col-xs-12 text-center"></div>

                                            <div class="clearfix"></div>




                                            @foreach ($bestLotteries as $key => $lottery)


                                                @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))

                                                    @if (($key+1) == 4)
                                                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details" style="padding-left: 0px;padding-right: 0px;">
                                                            <div class="well profile_view" style="margin-bottom:5px; background-color: #fff;">
                                                                <div id="pos-article-display-74756"></div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (($key+1) == 10)
                                                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details" style="padding-left: 0px;padding-right: 0px;">
                                                            <div class="well profile_view" style="margin-bottom:5px; background-color: #fff;">
                                                                <div id="pos-article-display-74757"></div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (($key+1) == 16)
                                                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details" style="padding-left: 0px;padding-right: 0px;">
                                                            <div class="well profile_view" style="margin-bottom:5px; background-color: #fff;">
                                                                <div id="pos-article-display-75036"></div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                                {{$amIManager = false}}
                                                {{$amIMember = false}}
                                                @if ($amIManager = auth()->user()->id == $users->find($lotteryManagers->find($lottery->lottery_manager_id)->user_id)->id )
                                                @endif
                                                @if ($amIMember = $lotteryStocks->where('lottery_id',$lottery->id)->where('owner',auth()->user()->id)->all())

                                                @endif




                                                <div class="col-md-4 col-sm-4 col-xs-12 profile_details" style="padding-left: 0px;padding-right: 0px;">
                                                    <div class="well profile_view" style="margin-bottom:5px;">

                                                        <a href="{{ route('lotteries.show',$lottery->id) }}"><div class="col-sm-12" >
                                                                <div class="left col-xs-8" style="padding-left: 0px;">
                                                                    <h4 class="brief"><strong><i class="fa fa-caret-left"></i> {{$lottery->name}}</strong></h4>
                                                                    <div style="margin-top: 5px">
                                            <span  class="label
                                            @switch($lottery->status)
                                                @case('در حال برگزاری')
                                                label-success
                                                    @break

                                                @case('پایان یافته')
                                                label-danger
                                                    @break

                                                @case('در حال عضوگیری')
                                                label-primary
                                                    @break
                                                @default
                                                label-info
                                            @endswitch

                                            ">{{$lottery->status}}</span>
                                                                    </div>
                                                                    <br>
                                                                    <p><strong>وام: </strong>{{number_format($lottery->amount)}} تومان {{$lottery->count_of_lots}} قسط<br></p>
{{--                                                                    <p><strong>تعداد اقساط: </strong>{{$lottery->count_of_lots}} قسط</p>--}}
                                                                    {{-- <p><strong>{{$lottery->cycle}}</strong> {{number_format($lottery->amount/$lottery->count_of_lots)}} تومان</p> --}}
                                                                    <p><strong>شروع: </strong>
                                                                        {{verta($lottery->time_of_first_lot)->format('j %B %Y ساعت G')}}
                                                                    </p>
                                                                    {{-- <p><strong>تعداد قرعه انجام شده:</strong>
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

                                                                       </div></p> --}}

{{--                                                                    <p><strong>قرعه کشی : </strong> توسط--}}
{{--                                                                        {{$lottery->type_of_choose_winner}}--}}
{{--                                                                    </p>--}}
                                                                    {{-- <p><strong>قابل خرید: </strong>
                                                                        {{count($lottery->lotterystocks->where('owner',null))}}
                                                                     سهم</p> --}}


                                                                    <br>



                                                                </div>
                                                                <div class="right col-xs-4 text-center">
                                                                    <img
                                                                        @if ($imgSrc=$users->where('id',$lotteryManagers->find($lottery->lottery_manager_id)->user_id)->first()->avatar_url)
                                                                            src="{{$imgSrc}}"
                                                                        @else
                                                                            src="/users/build/images/profile/user.png"
                                                                        @endif

                                                                        alt="" class="img-circle img-responsive">

                                                                    <strong>مدیریت:</strong><br>
                                                                    {{$users->find($lotteryManagers->find($lottery->lottery_manager_id)->user_id)->name}}

                                                                    <br>
                                                                    <div style="color: #f6c255;font-size: 0.78rem; ">
                                                                        <li class="fa fa-star-o"></li>
                                                                        <li class="fa fa-star-o"></li>
                                                                        <li class="fa fa-star-o"></li>
                                                                        <li class="fa fa-star-o"></li>
                                                                        <li class="fa fa-star"></li>
                                                                    </div>







                                                                </div>




                                                            </div></a>
                                                        {{-- <div class="col-xs-12 bottom text-center">
                                                            <div class="col-xs-4 col-sm-4 emphasis">
                                                              <p class="ratings">
                                                                  <a>{{number_format($lottery->count_of_like )}}</</a>
                                                                  <a href="{{ route('lotteries.like',$lottery->id) }}"><span class="fa fa-heart" style="display: inline-block;"></span></a>
                                                                  <a>{{number_format($lottery->count_of_view)}}</a>
                                                                  <span class="fa fa-eye" style="display: inline-block;"></span>

                                                              </p>


                                                            </div>
                                                            <div class="col-xs-8 col-sm-8 emphasis">

                                                                @if ($amIManager)
                                                                  <a href="{{ route('lotteries.show', [$lottery->id]) }}#stocksLocation" style="font-size: 100%;" class="label label-info">
                                                                        <i class="fa fa-shopping-cart"> </i> مدیریت سهام ها
                                                                    </a>
                                                                @else

                                                                    @if ($amIMember)
                                                                    <a href="{{ route('stockrequests.create',[$lottery->id,'buy']) }}" style="font-size: 100%;" class="label label-primary">
                                                                        <i class="fa fa-arrow-circle-up"> </i>افزایش سهام
                                                                    </a>&nbsp;
                                        <a href="{{ route('stockrequests.create',[$lottery->id,'sell']) }}" style="font-size: 100%;" class="label label-danger">
                                                                        <i class="fa fa-arrow-circle-down"> </i> واگذاری
                                                                    </a>
                                                                    @else
                                                                    <a href="{{ route('stockrequests.create',[$lottery->id,'buy']) }}" style="font-size: 100%;" class="label label-warning">
                                                                          <i class="fa fa-shopping-cart"> </i>
                                                                          درخواست عضویت
                                                                      </a>
                                                                  @endif
                                                                @endif


                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>


                                            @endforeach


                                        </div>
                                        <br><br>

{{--                                                                        <div style="text-align: center;">    {{$bestLotteries->appends(['myLotteries' => $myLotteries->currentPage()])->links()}}    </div>--}}


                                    </div>




                                </div>
                            </div>


                        </div>







                    @endif


















                    @if(isset($lotteriesSearched))

        <div class="row">

        <div class="col-md-12">
            <div class="x_panel" >



                <div class="x_content">

                    <div class="x_title">

{{--                            <h2><strong> جستجو جدیدترین صندوق ها <span class="fa fa-sort-down"></strong></h2>--}}
                        <form method="POST" action="{{ route('lottery.search') }}">
                            @csrf
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <div class="input-group form-group  top_search">
                                    <input  id="searchlottery" name="searchlottery" type="text" class="form-control" placeholder="نام صندوق مورد نظر">
                                    <span class="input-group-btn">
                                  <button class="btn btn-default" type="submit">بگرد!</button>
                                </span>
                                </div>
                            </li>
                        </ul>
                        </form>

                        <div class="clearfix"></div>
                    </div>


                    <div class="row">


                    <div class="col-md-12 col-sm-12 col-xs-12 text-center"></div>

                    <div class="clearfix"></div>


                    @if (count($otherLotteries)==0)
                    <p class="alert alert-warning">هیچ صندوقی جهت نمایش وجود ندارد ...</p>

                    @endif

                    @foreach ($otherLotteries as $key => $lottery)

                    @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))

                    @if (($key+1) == 4)
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details" style="padding-left: 0px;padding-right: 0px;">
                        <div class="well profile_view" style="margin-bottom:5px; background-color: #fff;">
                            <div id="pos-article-display-74756"></div>
                        </div>
                    </div>
                    @endif
                    @if (($key+1) == 10)
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details" style="padding-left: 0px;padding-right: 0px;">
                        <div class="well profile_view" style="margin-bottom:5px; background-color: #fff;">
                            <div id="pos-article-display-74757"></div>
                        </div>
                    </div>
                    @endif
                    @if (($key+1) == 16)
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details" style="padding-left: 0px;padding-right: 0px;">
                        <div class="well profile_view" style="margin-bottom:5px; background-color: #fff;">
                            <div id="pos-article-display-75036"></div>
                        </div>
                    </div>
                    @endif
                    @endif


                    {{$amIManager = false}}
                    {{$amIMember = false}}
                    @if ($amIManager = auth()->user()->id == $users->find($lotteryManagers->find($lottery->lottery_manager_id)->user_id)->id )
                    @endif
                    @if ($amIMember = $lotteryStocks->where('lottery_id',$lottery->id)->where('owner',auth()->user()->id)->all())

                    @endif




                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details" style="padding-left: 0px;padding-right: 0px;">
                            <div class="well profile_view" style="margin-bottom:5px;">

                                <a href="{{ route('lotteries.show',$lottery->id) }}"><div class="col-sm-12" >
                                    <div class="left col-xs-8" style="padding-left: 0px;">
                                        <h4 class="brief"><strong><i class="fa fa-caret-left"></i> {{$lottery->name}}</strong></h4>
                                        <div style="margin-top: 5px">
                                            <span  class="label
                                            @switch($lottery->status)
                                                @case('در حال برگزاری')
                                                label-success
                                                    @break

                                                @case('پایان یافته')
                                                label-danger
                                                    @break

                                                @case('در حال عضوگیری')
                                                label-primary
                                                    @break
                                                @default
                                                label-info
                                            @endswitch

                                            ">{{$lottery->status}}</span>
                                        </div>
                                           <br>
                                        <p><strong>وام: </strong>{{number_format($lottery->amount)}} تومان<br></p>
                                        <p><strong>تعداد اقساط: </strong>{{$lottery->count_of_lots}} قسط</p>
                                        {{-- <p><strong>{{$lottery->cycle}}</strong> {{number_format($lottery->amount/$lottery->count_of_lots)}} تومان</p> --}}
                                        <p><strong>شروع: </strong>
                                            {{verta($lottery->time_of_first_lot)->format('j %B %Y ')}}
                                        </p>
                                        {{-- <p><strong>تعداد قرعه انجام شده:</strong>
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

                                           </div></p> --}}

                                        <p><strong>قرعه کشی : </strong> توسط
                                            {{$lottery->type_of_choose_winner}}
                                         </p>
                                        {{-- <p><strong>قابل خرید: </strong>
                                            {{count($lottery->lotterystocks->where('owner',null))}}
                                         سهم</p> --}}


                                            <br>



                                    </div>
                                    <div class="right col-xs-4 text-center">
                                        <img
                                        @if ($imgSrc=$users->where('id',$lotteryManagers->find($lottery->lottery_manager_id)->user_id)->first()->avatar_url)
                                          src="{{$imgSrc}}"
                                          @else
                                           src="/users/build/images/profile/user.png"
                                        @endif

                                         alt="" class="img-circle img-responsive">

                                         <strong>مدیریت:</strong><br>
                                            {{$users->find($lotteryManagers->find($lottery->lottery_manager_id)->user_id)->name}}

                                            <br>
                                            <div style="color: #f6c255;font-size: 0.78rem; ">

                                            {{-- <li class="fa fa-star-o"></li>
                                            <li class="fa fa-star-half"></li> --}}
                                            <li class="fa fa-star-o"></li>
                                            <li class="fa fa-star-o"></li>
                                            <li class="fa fa-star-o"></li>
                                            <li class="fa fa-star-o"></li>
                                            <li class="fa fa-star"></li>
                                            </div>







                                    </div>




                                </div></a>
                                {{-- <div class="col-xs-12 bottom text-center">
                                    <div class="col-xs-4 col-sm-4 emphasis">
                                      <p class="ratings">
                                          <a>{{number_format($lottery->count_of_like )}}</</a>
                                          <a href="{{ route('lotteries.like',$lottery->id) }}"><span class="fa fa-heart" style="display: inline-block;"></span></a>
                                          <a>{{number_format($lottery->count_of_view)}}</a>
                                          <span class="fa fa-eye" style="display: inline-block;"></span>

                                      </p>


                                    </div>
                                    <div class="col-xs-8 col-sm-8 emphasis">

                                        @if ($amIManager)
                                          <a href="{{ route('lotteries.show', [$lottery->id]) }}#stocksLocation" style="font-size: 100%;" class="label label-info">
                                                <i class="fa fa-shopping-cart"> </i> مدیریت سهام ها
                                            </a>
                                        @else

                                            @if ($amIMember)
                                            <a href="{{ route('stockrequests.create',[$lottery->id,'buy']) }}" style="font-size: 100%;" class="label label-primary">
                                                <i class="fa fa-arrow-circle-up"> </i>افزایش سهام
                                            </a>&nbsp;
                <a href="{{ route('stockrequests.create',[$lottery->id,'sell']) }}" style="font-size: 100%;" class="label label-danger">
                                                <i class="fa fa-arrow-circle-down"> </i> واگذاری
                                            </a>
                                            @else
                                            <a href="{{ route('stockrequests.create',[$lottery->id,'buy']) }}" style="font-size: 100%;" class="label label-warning">
                                                  <i class="fa fa-shopping-cart"> </i>
                                                  درخواست عضویت
                                              </a>
                                          @endif
                                        @endif


                                    </div>
                                </div> --}}
                            </div>

                        </div>

                        @endforeach



                    </div>

                     @if(!isset($lotteriesSearched))
                        <div style="text-align: center;">    {{$otherLotteries->appends(['myLotteries' => $myLotteries->currentPage()])->links()}}    </div>
                     @endif


                </div>




            </div>
        </div>


        </div>
                    <br><br>
                    @endif


    @endif


    </div>
</div>
<!-- /page content -->
@endsection
