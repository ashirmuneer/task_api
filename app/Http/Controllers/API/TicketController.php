<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\ResponseSendController;
use App\Models\Models\TicketMessage as ModelsTicketMessage;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Validator;

class TicketController extends ResponseSendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
          $user =  Auth::user();


           if(in_array("admin",$user->role)){

            $success['data'] =  TicketMessage::all();

            return $this->successResponse($success, 'All Ticket Detail');

           }else{

            return $this->erroResponse('Unauthorised.', ['error'=>'Only Admin Can Access Ticket List']);
           }

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


        try{
            $validator = Validator::make($request->all(), [
                'message' => 'required',
            ]);

            if($validator->fails()){
                return $this->erroResponse('Validation Error.', $validator->errors());
            }

            $user = Auth::user();
            $user_id = $user->id;

            $ticket_message = new TicketMessage();
            $ticket_message->user_id = $user_id;
            $ticket_message->message = $request->message;
            $ticket_message->save();

            $success['datat'] =  $ticket_message;

            return $this->successResponse($success, 'Ticket Submitted Successfully');


        } catch (\Illuminate\Database\QueryException $e) {

            $response['message'] = 'Error Occured,Try Again ';
            return $this->erroResponse('Validation Error.', $response);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
