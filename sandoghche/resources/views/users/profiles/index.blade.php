@extends('users.layouts.app')


@section('title')
پروفایل کاربری
@endsection
@section('title2')
پروفایل کاربری
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
                        <h2>مشخصات شما
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
                    <div class="x_content">
                        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                            <div class="profile_img">
                                <div id="crop-avatar">
                                    <!-- Current avatar -->




                                        <a href="{{ route('profiles.edit',auth()->user()->id) }}">

                                            <img  class="img-responsive avatar-view"

                                            @if (auth()->user()->avatar_url)
                                                src="{{auth()->user()->avatar_url}}"
                                            @else
                                                src="/users/build/images/profile/user.png"
                                            @endif


                                             alt="Avatar"
                                             title="Change the avatar">

                                         </a>


















                                </div>
                            </div>
                            <h3>{{auth()->user()->name}}</h3>

                            <a class="btn btn-success" href="{{ route('profiles.edit',auth()->user()->id) }}"><i class="fa fa-edit m-right-xs"></i>&nbsp;ویرایش پروفایل</a><br><br>

                            <ul class="list-unstyled user_data">
                                <li>
                                    <i class="fa fa-usd user-profile-icon"></i> موجودی  :
                                    {{auth()->user()->cash}} تومان
                                </li>
                                <li>
                                    <i class="fa fa-phone user-profile-icon"></i> شماره تماس:
                                    {{auth()->user()->phone_number}}
                                </li>
                                <li>
                                    <i class="fa fa-calendar user-profile-icon"></i> تاریخ عضویت: {{verta(auth()->user()->created_at)->formatDifference()}}
                                </li>



                            </ul>


                            <br/>



                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">

                            <div class="profile_title">
                                <h2>گزارش فعالیت کاربر</h2>
                                {{-- <div class="col-md-6">
                                    <h2>گزارش فعالیت کاربر</h2>
                                </div>
                                <div class="col-md-6">
                                    <div id="reportrange" class="pull-left"
                                         style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                    </div>
                                </div> --}}
                            </div>





                            {{-- امتیاز : ...  --}}




                            <!-- start of user-activity-graph -->
                            <div id="graph_bar" style="width:100%; height:280px;"></div>
                            <!-- end of user-activity-graph -->

                            {{-- <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab"
                                                                              role="tab" data-toggle="tab"
                                                                              aria-expanded="true">فعالیت اخیر</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab"
                                                                        data-toggle="tab" aria-expanded="false">پروژه مشغول به کار</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content3" role="tab"
                                                                        id="profile-tab2" data-toggle="tab"
                                                                        aria-expanded="false">پروفایل</a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1"
                                         aria-labelledby="home-tab">

                                        <!-- start recent activity -->
                                        <ul class="messages">
                                            <li>
                                                <img src="/users/build/images/img.jpg" class="avatar" alt="Avatar">
                                                <div class="message_date">
                                                    <h3 class="date text-info">۳</h3>
                                                    <p class="month">خرداد</p>
                                                </div>
                                                <div class="message_wrapper">
                                                    <h4 class="heading">دزموند دیویسون</h4>
                                                    <blockquote class="message">کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                                                    </blockquote>
                                                    <br/>
                                                    <p class="url">
                                                        <span class="fs1 text-info" aria-hidden="true"
                                                              data-icon=""></span>
                                                        <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                                    </p>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/users/build/images/img.jpg" class="avatar" alt="Avatar">
                                                <div class="message_date">
                                                    <h3 class="date text-error">۳۱</h3>
                                                    <p class="month">اردیبهشت</p>
                                                </div>
                                                <div class="message_wrapper">
                                                    <h4 class="heading">برایان مایکلز</h4>
                                                    <blockquote class="message">در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                                                    </blockquote>
                                                    <br/>
                                                    <p class="url">
                                                        <span class="fs1" aria-hidden="true" data-icon=""></span>
                                                        <a href="#" data-original-title="">دانلود</a>
                                                    </p>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/users/build/images/img.jpg" class="avatar" alt="Avatar">
                                                <div class="message_date">
                                                    <h3 class="date text-info">۳</h3>
                                                    <p class="month">خرداد</p>
                                                </div>
                                                <div class="message_wrapper">
                                                    <h4 class="heading">دزموند دیویسون</h4>
                                                    <blockquote class="message">کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد.
                                                    </blockquote>
                                                    <br/>
                                                    <p class="url">
                                                        <span class="fs1 text-info" aria-hidden="true"
                                                              data-icon=""></span>
                                                        <a href="#"><i class="fa fa-paperclip"></i> User Acceptance
                                                            Test.doc </a>
                                                    </p>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/users/build/images/img.jpg" class="avatar" alt="Avatar">
                                                <div class="message_date">
                                                    <h3 class="date text-error">۳۱</h3>
                                                    <p class="month">اردیبهشت</p>
                                                </div>
                                                <div class="message_wrapper">
                                                    <h4 class="heading">برایان مایکلز</h4>
                                                    <blockquote class="message">در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                                                    </blockquote>
                                                    <br/>
                                                    <p class="url">
                                                        <span class="fs1" aria-hidden="true" data-icon=""></span>
                                                        <a href="#" data-original-title="">دانلود</a>
                                                    </p>
                                                </div>
                                            </li>

                                        </ul>
                                        <!-- end recent activity -->

                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2"
                                         aria-labelledby="profile-tab">

                                        <!-- start user projects -->
                                        <table class="data table table-striped no-margin">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>نام پروژه</th>
                                                <th>شرکت مشتری</th>
                                                <th class="hidden-phone">ساعت صرف شده</th>
                                                <th>مشارکت</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>New Company Takeover Review</td>
                                                <td>Deveint Inc</td>
                                                <td class="hidden-phone">18</td>
                                                <td class="vertical-align-mid">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-success"
                                                             data-transitiongoal="35"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>New Partner Contracts Consultanci</td>
                                                <td>Deveint Inc</td>
                                                <td class="hidden-phone">13</td>
                                                <td class="vertical-align-mid">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-danger"
                                                             data-transitiongoal="15"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Partners and Inverstors report</td>
                                                <td>Deveint Inc</td>
                                                <td class="hidden-phone">30</td>
                                                <td class="vertical-align-mid">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-success"
                                                             data-transitiongoal="45"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>New Company Takeover Review</td>
                                                <td>Deveint Inc</td>
                                                <td class="hidden-phone">28</td>
                                                <td class="vertical-align-mid">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-success"
                                                             data-transitiongoal="75"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <!-- end user projects -->

                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content3"
                                         aria-labelledby="profile-tab">
                                        <p>در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- /page content -->
@endsection
