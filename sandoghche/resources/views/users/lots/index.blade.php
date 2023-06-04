@extends('users.layouts.app')


@section('title')
مدیریت قرعه ها
@endsection

@section('title2')
مدیریت قرعه ها
@endsection


@section('content')
<!-- page content -->


<div class="right_col" role="main">
    <div class="">


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="padding-left: 5px;padding-right: 5px;">
                    @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))
                        <div style="text-align: center;">
                            <div id="mediaad-P80eX" ></div>
                        </div>
                    @endif

                    <div class="x_title">
                        <h2>قرعه های صندوق
                            {{ mb_substr($lottery->name,0,22) }}

                            {{-- <small>واریزها و برداشت ها</small> --}}

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



                    <div class="x_content" style="padding-left: 0px;padding-right: 0px;">

                        <div class="panel-body" style="padding: 5px;">








                            <div class="col-md-12 col-sm-12 col-xs-12" >
                                <div>


                                    {{-- <div class="x_title">
                                        <h2>قرعه های صندوق فلان</h2>
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



                                    <ul class="list-unstyled top_profiles scroll-view">
                                        @foreach ($lots as $lot)
                                        <li class="media event">
                                            <a class="pull-left
                                            @if ($lot->stock_winner == null)
                                            border-aero
                                            @else
                                            border-green
                                            @endif

                                            {{-- @php
                                                dd($stocks->where('id',$lot->stock_winner)->first()->owner);
                                            @endphp --}}


                                            profile_thumb">
                                                <img style="margin-top: -9px;margin-right:-12px;"
                                                width="44"
                                                @if ($lot->stock_winner == null)
                                                src="/users/build/images/lotterystock/whoiswinner.jpg"
                                                @elseif ($stocks->where('id',$lot->stock_winner)->first()->owner == null)
                                                src="/users/build/images/profile/user.png"
                                                @elseif ($users->where('id',$stocks->where('id',$lot->stock_winner)->first()->owner)->first()->avatar_url == null)
                                                src="/users/build/images/profile/user.png"
                                                @else
                                                src="{{$users->where('id',$stocks->where('id',$lot->stock_winner)->first()->owner)->first()->avatar_url}}"

                                                @endif


                                                 alt="" class="img-circle ">

                                            </a>
                                            <div class="media-body">

                                                <a class="title" href="#">قرعه ی {{$lot->number}} <i class="fa fa-caret-left"></i>

                                                </a><br>
                                                زمان برگزاری:
                                                {{verta($lot->time_holding)->format('j %B %Y ساعت G')}}<br>
                                                @if ($winnerStockId=$lot->stock_winner)
                                                برنده :
                                                سهام
                                                {{$stocks->find($winnerStockId)->number}}
                                                    @if($user= $users->find($stocks->find($winnerStockId)->owner))
                                                    ({{$user->name}})
                                                    @else
                                                    (بی نام)
                                                    @endif
                                                <br>
                                                @endif



                                                    <div class="text-center">
                                                @if ($amIManager)
                                                    <form  action="{{ route('installments.manage',$lot->id) }}">
                                                        @csrf
                                                    <input class="btn btn-info btn-sm" type="submit" value=" مدیریت اقساط قرعه {{$lot->number}}">


                                                            </form>
                                                @elseif($amIMember)


                                                    {{-- <input class="btn btn-warning btn-sm" type="submit" value="پرداخت قسط  این قرعه"> --}}


                                                @endif
                                                    </div>









                                            </div>
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>



                            @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))
                            <div style="text-align: center;">
                                <div id="mediaad-dYqvk" ></div>
                            </div>
                             @endif

















                                </div>
                            </div>















                        </div>







                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>


<!-- /page content -->
@endsection
