<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/','LotteryController@redirectToLogin');

Route::get('clear','LotteryController@clearCache')->name('clear.cache');
Route::get('sendsms/{type}','LotteryController@sendSms')->name('sms.send');
// Route::get('migrate',function ()
// {
//     Artisan::call('migrate');
//     dd(Artisan::output());
// });

Auth::routes();
Route::get('home/showactivecodeform2','ActivationCode2Controller@showForm')->name('show.activation.code2');
Route::post('register2','Register2Controller@register')->name('register2');
Route::get('home/showactivecodeform','ActivationCodeController@showForm')->name('show.activation.code');
Route::post('login2','Login2Controller@login')->name('login2');
Route::get('policy','LotteryController@showPolicy')->name('policy');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'LotteryController@index')->name('home');
    Route::get('/home/mylotteries', 'LotteryController@myLotteries')->name('my.lotteries');
    Route::get('/home/lottery/{lotteryId}/upgrade', 'LotteryController@lotteryUpgradeShowPage')->name('lottery.upgrade.showpage');
    Route::get('/home/lottery/{lotteryId}/pay/{productId}', 'LotteryController@lotteryPayShowPage')->name('lottery.upgrade.pay');
    Route::post('/home', 'LotteryController@lotterySearch')->name('lottery.search');
    Route::get('/home/invitefriends/{lotteryId}', 'LotteryController@inviteFriendsCreate')->name('invite.friends.create');
    Route::get('/home/{lotteryId}/lotteryinfo', 'LotteryController@showLotteryInfo')->name('lottery.info.show')->middleware(['checkUpgradeLottery']);
    Route::post('/home/invitefriends', 'LotteryController@inviteFriendsStore')->name('invite.friends.store');
    Route::resource('home/lotteries','LotteryController')->middleware(['checkUpgradeLottery']);
    Route::resource('home/lots','LotController')->middleware(['checkUpgradeLottery']);
    Route::get('/home/lotswithoutadvertise/{lotId}', 'LotController@showWithoutAdvertise')->name('lots.withoutadvertise.show')->middleware(['checkUpgradeLottery']);
    Route::resource('home/profiles','ProfileController');
    Route::resource('home/stockrequests', 'StockRequestController')->except(['create']);
    Route::get('home/stockrequests/{id}/{type}/create','StockRequestController@create')->name('stockrequests.create');
    Route::post('home/stockrequests/{id}/answer/','StockRequestController@answerStockRequest')->name('stock.request.answer');
    Route::post('home/{id}/stockrequestchange','StockRequestController@changeStockOwner')->name('stocks.change.owner');
    Route::get('home/lottery/{id}/stocks','LotteryController@lotteryStocksShowPage')->name('stocks.lottery.index')->middleware(['checkUpgradeLottery']);


    Route::resource('home/installments','InstallmentController');
    Route::get('home/{lotId}/manageofinstallments','InstallmentController@manageInstallments')->name('installments.manage')->middleware(['checkUpgradeLottery']);
    Route::post('home/choosewinnerbymanager', 'LotteryController@chooseWinnerByManager')->name('lots.choose.winner');
    Route::post('home/{stockId}/addStockforLotteryManager', 'StockRequestController@addStockforLotteryManager')->name('add.stocks.for.manager');
    Route::post('home/{stockId}/addStockforLotteryMember', 'StockRequestController@addStockforLotteryMember')->name('add.stocks.for.member');
    Route::get('home/lottery/{lottery}/like','LotteryController@like')->name('lotteries.like');

    Route::resource('home/orders','OrderController');
    Route::resource('home/payments','PaymentController');
    Route::get('home/checkoutrequest','PaymentController@checkoutRequest' )->name('checkout.request');
    Route::put('home/checkoutrequest','PaymentController@checkout' )->name('checkout');

    Route::resource('home/tickets','TicketController');
    Route::post('home/closeticket','TicketController@dontNeedAnswerTicket')->name('ticket.dontneedanswer');
    Route::get('home/documents','LotteryController@usersDocuments')->name('ducument');
    Route::get('home/donate','LotteryController@usersDonates')->name('donate');
    Route::get('home/reportlottery/{id}','LotteryController@reportLotteryCreate')->name('lottery.report.create');
    Route::post('home/reportlottery','LotteryController@reportLotteryStore')->name('lottery.report.store');




    //for advertise
    Route::get('home/donate/showadvertise','LotteryController@donateAdvertise')->name('donate.advertise.show');
    Route::get('home/lotteries/{lotteryId}/upgrade','LotteryController@lotteryUpgrade')->name('lottery.upgrade');
    Route::get('home/showadvertise','LotteryController@advertiseShow')->name('advertise.show');





});










