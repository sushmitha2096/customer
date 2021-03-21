<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Helpers\ResponseBuilder;
use Session;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public $successStatus = 200;
    public $failureStatus = 400;

    public function Register()
    {
        try{
            $page_name = "Register";
            return view('register')->with('title',$page_name);
        }catch(\GuzzleHttp\Exception\ServerException $e){
            return Redirect::to('vendor/dashboard');
        }catch(\GuzzleHttp\Exception\RequestException $e){
            return Redirect::to('vendor/dashboard');
        }
    }
  
    public function StoreUser(Request $request)
    {
		try{
			$input = $request->all();
            //print_r($input); exit;
            $rules = [
                'user_name' => ['required'],
                'email' => ['required','unique:users,email'],
                'phone' => ['required','min:10','unique:users,phone'],
                'g-recaptcha-response' => ['required','recaptcha']
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

            $data['user_name'] = $input['user_name'];
            $data['email'] = $input['email'];
            $data['phone'] = $input['phone'];
            $data['unique_code'] = rand (10,100000);
            $data['otp'] = rand (0,999999);

             $user_id = Customer::register('users',$data);
             Session::put('user_id', $user_id);

              $customer_email =  $input['email'];
                $from_email = env('MAIL_FROM_ADDRESS');
                $from_name = env('MAIL_USERNAME');
                $user_name = $input['user_name'];
                $message = "Registered successfully. ".$data['otp']. " is your One Time Password(OTP)";
                $subject = "Registration";
                $data1 = array('order_placed_message' => $message, 'user_name' => $user_name);
                
                Mail::send('emails.otp', $data1, function ($message) use ($user_name, $customer_email, $subject, $from_email) {
                    $message->to($customer_email, $user_name)
                        ->subject($subject);
                    $message->from($from_email, 'ABCD');
                    });
            	
			return ResponseBuilder::responseResult($this->successStatus, 'User Registered Successfully', $user_id);
            
		}catch(\GuzzleHttp\Exception\ServerException $e){
            echo $e->getMessage(); exit;
        }catch(\GuzzleHttp\Exception\RequestException $e){
            return Redirect::to('vendor/dashboard');
        }

    }
    
   
}
