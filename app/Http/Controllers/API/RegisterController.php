<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ResponseSendController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends ResponseSendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        try {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',

        ]);

        if($validator->fails()){
            return $this->erroResponse('Validation Error.', $validator->errors());
        }

      $user = new User();
      $user->first_name = $request->first_name;
      $user->last_name = $request->last_name;
      $user->role =  $request->role;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->save();
      $success['token'] =  $user->createToken('MyApp')->accessToken;
      $success['name'] =  $user->first_name.' '.$user->last_name;

      return $this->successResponse($success, 'User registered successfully.');

    } catch (\Illuminate\Database\QueryException $e) {

        $response['message'] = 'Error Occured, Try Again ';
        return $this->erroResponse('Validation Error.', $response);


    }



    }


    public function login(Request $request)
    {

        try{
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->erroResponse('Validation Error.', $validator->errors());
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->first_name.' '.$user->last_name;

            return $this->successResponse($success, 'User login successfully.');
        }
        else{
            return $this->erroResponse('Unauthorised.', ['error'=>'Unauthorised']);
        }

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
    public function show()
    {
        try{
        $success['data'] =  Auth::user();

            return $this->successResponse($success, 'user Detail');

        } catch (\Illuminate\Database\QueryException $e) {

            $response['message'] = 'Error Occured,Try Again ';
            return $this->erroResponse('Validation Error.', $response);


        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        if($validator->fails()){
            return $this->erroResponse('Validation Error.', $validator->errors());
        }

        $login_user = Auth::user();

        $user = User::find($login_user->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->update();

        $success['data'] =  $user;

        return $this->successResponse($success, 'User detail updatd successfully.');

    } catch (\Illuminate\Database\QueryException $e) {

        $response['message'] = 'Error Occured,Try Again ';
        return $this->erroResponse('Validation Error.', $response);


    }

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
