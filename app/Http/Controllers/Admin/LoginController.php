<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Helpers\ResponseBuilder;
use Session;
use App\Models\Customer;

class LoginController extends Controller
{
    public $successStatus = 200;
    public $failureStatus = 400;

    public function index()
    {
        try{
            $page_name = "Login";
            return view('login')->with('title',$page_name);
        }catch(\GuzzleHttp\Exception\ServerException $e){
            return Redirect::to('vendor/dashboard');
        }catch(\GuzzleHttp\Exception\RequestException $e){
            return Redirect::to('vendor/dashboard');
        }
    }

    public function Login(Request $request)
    {
        try{
            $user_id  = Session::get('user_id');

            $input = $request->all();
            //print_r($input); exit;
            $rules = [
                'user_name' => ['otp']
            ];
            
            $validator = app('validator')->make($input, $rules);

            $error = $result = array();
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $key => $value) {
                    $error[] = is_array($value) ? implode(',', $value) : $value;
                }
                $errors = implode(', \n ', $error);
                return ResponseBuilder::responseResult($this->failureStatus, $errors);
            }


            $data['otp'] = $input['otp'];
            $data['user_id'] = $user_id;
            $result = Customer::verifyOtp('users',$data);
            if(!empty($result)){
			    return ResponseBuilder::responseResult($this->successStatus, 'Logged In Successfully', $user_id);
            }
			return ResponseBuilder::responseResult($this->failureStatus, 'Failed To Log In');

            
        }catch(\GuzzleHttp\Exception\ServerException $e){
            return Redirect::to('vendor/dashboard');
        }catch(\GuzzleHttp\Exception\RequestException $e){
            return Redirect::to('vendor/dashboard');
        }
    }
    
    public function Dasboard()
    {
        try{
            $page_name = "Thank You";
            return view('dasboard')->with('title',$page_name);
        }catch(\GuzzleHttp\Exception\ServerException $e){
            return Redirect::to('vendor/dashboard');
        }catch(\GuzzleHttp\Exception\RequestException $e){
            return Redirect::to('vendor/dashboard');
        }
    }

}
