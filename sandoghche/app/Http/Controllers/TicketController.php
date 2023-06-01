<?php

namespace App\Http\Controllers;

use App\Notifications\AnswerTicket;
use Illuminate\Http\Request;
use App\Ticket;
use App\User;
use Carbon\Carbon;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->id == config('lottery.adminsandoghcheuserid.key')) {
            $tickets = Ticket::where('parent_ticket',NULL)->where('status','open')->latest()->paginate(20);
        }else{
            $tickets = Ticket::where('user_id',auth()->user()->id)->where('parent_ticket',NULL)->latest()->paginate(10);
        }
        return view('users.tickets.index',compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (isset($request->parent)) {
            if (auth()->user()->id == config('lottery.adminsandoghcheuserid.key')) {
                Ticket::create([
                    'user_id'=>auth()->user()->id,
                    'title'=>$request->title,
                    'body'=>$request->body,
                    'parent_ticket' => $request->parent,
                ]);
                $parentTicket = Ticket::find($request->parent);
                $parentTicket->status = 'answered';
                $parentTicket->save();

                //send sms

                if ($userParentTicket = User::where('id',$parentTicket->user_id)->first()) {
                    $userName = $userParentTicket->name;
                    $phoneNumber = $userParentTicket->phone_number;
                    $titleTicket = $parentTicket->title;
                    $userParentTicket->notify(new AnswerTicket($userName,$titleTicket,$phoneNumber));
                }


            }else
            {
                Ticket::create([
                    'user_id'=>auth()->user()->id,
                    'title'=>$request->title,
                    'body'=>$request->body,
                    'parent_ticket' => $request->parent,
                    'status' => 'open',
                ]);
                $parentTicket = Ticket::find($request->parent);
                $parentTicket->status = 'open';
                $parentTicket->save();
            }

        }else{
           Ticket::create([
               'user_id'=>auth()->user()->id,
               'title'=>$request->title,
               'body'=>$request->body,
           ]);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $ticket = Ticket::find($id);
        $ticketReplys = Ticket::where('parent_ticket',$id)->get();
        $users = User::all();

        if (auth()->user()->id != $ticket->user_id and auth()->user()->id != config('lottery.adminsandoghcheuserid.key')  ) {
            return 'شما دسترسی ندارید به این بخش';
        }

       return view('users.tickets.show',compact('ticket','ticketReplys','users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function dontNeedAnswerTicket(Request $request)
    {
        if (isset($request->ticketid)) {
            if (auth()->user()->id == config('lottery.adminsandoghcheuserid.key')) {
                $thisTicket = Ticket::find($request->ticketid);
                $thisTicket->status = 'answered';
                $thisTicket->save();

            }
        }

        return redirect(route('tickets.index'));
    }
}
