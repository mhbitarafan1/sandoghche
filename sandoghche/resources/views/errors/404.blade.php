@extends('errors.layouts.master')

@section('title')
صندوقچه | خطای 404
@endsection
@section('content')

<p>متاسفانه مشکلی پیش آمده است. لطفا دقایقی دیگر وارد شوید اگر مشکل برطرف نشد به پشتیبانی اطلاع دهید</p>
<a href="{{route('home')}}">تلاش مجدد</a>
@endsection


