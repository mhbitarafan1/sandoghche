@extends('users.layouts.app')


@section('title')
امور مالی
@endsection
@section('title2')
امور مالی
@endsection
@section('content')
<!-- page content -->


<div class="right_col" role="main">
    <div class="">


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="padding: 0px;">
                    <div class="x_title">
                        <h2>صورتحساب من
                            <small>واریزها و برداشت ها</small>

                        </h2><div class="text-left"><small><strong>موجودی : </strong> {{auth()->user()->cash}} تومان<br></small></div>
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
                    <div class="x_content" style="padding: 0px;">






                          <table class="table table-striped text-center">
                              <thead >
                              <tr >

                                  <th class="text-center">توضیحات</th>

                                  <th class="text-center">تاریخ</th>

                                  <th class="text-center">مبلغ</th>
                                  <th class="text-center">موجودی</th>




                              </tr>
                              </thead>

                              <tbody>



                                  @foreach ($orders as $order)
                                  @foreach ($order->payments as $payment)

                                    <tr>
                                     <td class="text-center">
                                         @if ($order->type_of_order == 'addCash')
                                             واریز وجه
                                             @if ($payment->status == 'successful')
                                                 موفق
                                             @else
                                                ناموفق
                                             @endif
                                         @elseif($order->type_of_order == 'installment')
                                                برداشت بابت قسط



                                            @foreach ($order->installments as $installment)
                                                {{$lots->find($installment->lot_id)->number}} سهام
                                                {{$stocks->find($installment->lottery_stock_id)->number}} صندوق

                                                {{$lotteries->where('id',$lots->where('id',$installment->lot_id)->first()->lottery_id)->first()->name}}
                                            @endforeach



                                         @endif
                                         تایید {{$payment->type}}
                                     </td>

                                     <td class="text-center">{{verta($payment->created_at)->format('%Y/%m/j (H:i:s)')}}</td>


                                      <td class="text-center">
                                         {{number_format($orders->find($payment->order_id)->amount)}}
                                     @if ($order->return_order == 0)
                                             +
                                         @else
                                             -
                                         @endif
                                     </td>
                                     <td class="text-center">{{number_format($payment->user_cash_after_pay)}}</td>



                                    </tr>

                                @endforeach
                            @endforeach



                        </tbody>
                    </table>
                    <div style="text-align: center;">{{ $orders->links() }}</div>

                    @if ($orders->count() == 0)
                    <div class="alert alert-info fade in">هیچ تراکنشی یافت نشد</div>
                    @endif


                    {{-- <div class="text-left"><a href="{{ route('checkout.request') }}" type="button" class="btn btn-primary btn-lg" ><li class="fa fa-plus"></li>  برداشت از حساب</a></div> --}}

                    <br><br>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- /page content -->

<br>
@endsection
