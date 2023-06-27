@extends('users.layouts.app')


@section('title')
مدیریت اقساط
@endsection
@section('title2')
مدیریت اقساط
@endsection
@section('content')
<!-- page content -->


<div class="right_col" role="main">
    <div class="">


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    {{-- <div class="x_title">
                        <h2>مدیریت اقساط
                            <small>+گزارش فعالیت‌ها</small>
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

                    @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))
                    <div style="text-align: center;">
                        <div id="mediaad-zv259" ></div>
                    </div>
                    @endif

                    <div class="x_content">



                        <p >
                         قسط {{$lot->number}} {{$lottery->name}}

                                                                {{-- ( {{verta($lot->time_holding)->format('j %B %Y ساعت G')}} ) --}}


                        </p>

                                                    <table class="table table-striped text-center">
                                                        <thead >
                                                        <tr >
                                                            <th class="text-center">سهم</th>
                                                            <th class="text-center">صاحب  سهم</th>
                                                            <th class="text-center">وضعیت قسط</th>

                                                            <th class="text-center">تغییر وضعیت</th>

                                                        </tr>
                                                        </thead>
                                                        <tbody>




                                                             @foreach ($lot->installments as $installment)


                                                                <tr>
                                                                    <td>{{$stocks->find($installment->lottery_stock_id)->number}}</td>
                                                                    <td>
                                                                        @if ($stokOwner= $stocks->find($installment->lottery_stock_id)->owner)
                                                                            {{$users->find($stokOwner)->name}}
                                                                        @else
                                                                        ---
                                                                        @endif
                                                                    </td>

                                                                    <td>



                               @if ($installment->paid)
                                    @if ($installment->confirmed_by == 'سامانه')

                                    <span class="label label-success">پرداخت  به سامانه</span>


                                    @elseif($installment->confirmed_by == 'مدیر قرعه کشی')
                                    <span class="label bg-green">

                                    تایید مدیر صندوق</span>

                                    @endif
                                @else
                                <span class="label label-danger">

                                    عدم پرداخت</span>



                                @endif



                                                                    </td>
                                                                    <td>
                                                                        <form action="{{ route('installments.update',$installment->id) }}" method="post">
                                                                            @csrf
                                                                            @method('PUT')

                                                                        @if ($installment->confirmed_by == 'سامانه')


                                                                        @else

                           @if(!$installment->paid)

                        <!-- Button trigger modal -->
<button type="submit" onclick="return confirm('مطمئن هستید؟ \nدقت نمایید که پس از تایید امکان تغییر وضعیت نمی باشد.')" class="btn btn-default btn-xs" data-toggle="modal" data-target="#exampleModal"><span class="docs-tooltip" data-toggle="tooltip"  >
                                  <span class="fa fa-check"></span>
                                </span>
  تایید دریافت

</button>




                           @endif









                                                                        </form>
                                                                        @endif




                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>


                        <a style="margin-right:0px;font-size: 17px; " href="{{ route('lotteries.show',$lottery->id) }}" class="btn btn-info  btn-block">
                            <i class="fa fa-backward"> </i>
                            برگشت به صفحه صندوق
                        </a><br>
                                                    @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))
                                                    <div style="text-align: center;">
                                                        <div id="mediaad-G7PR5"></div>
                                                    </div>
                                                    @endif





                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- /page content -->
@endsection
