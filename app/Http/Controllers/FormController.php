<?php

namespace App\Http\Controllers;

use App\Email;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NotifyEmails;

class FormController extends Controller
{
    public function callme(Request $request) {
        
        $input = $request->except(['_token']);
        
        $messages = array(
            'name.required' => 'Поле не заполнено',
            'name.max' => 'Слишком длинное имя',
            'phone.required' => 'Поле не заполнено',
        );
        
        $validator = Validator::make($input, [
            'name' => 'required|max:30',
            'phone' => 'required'
        ], $messages);
        
        if($validator->fails()) {
            return   $validator->messages()->toArray();
        }
		
        //admin
        $user = User::find(1);
        $email = Email::create($input);
        $email->user()->associate($user);
        $user->notify(new NotifyEmails($email));

    }
	
	public function plan(Request $request) {
        
        $input = $request->except(['_token']);
        
        $messages = array(
            'name.required' => 'Поле не заполнено',
            'name.max' => 'Слишком длинное имя',
            'phone.required' => 'Поле не заполнено',
			'email.required' => 'Поле не заполнено',
            'email.email' => 'Некорректно введен E-mail',
        );
        
        $validator = Validator::make($input, [
            'name' => 'required|max:30',
            'phone' => 'required',
			'email' => 'required|email',
        ], $messages);
        
        if($validator->fails()) {
            return   $validator->messages()->toArray();
        }
		
        //admin
        $user = User::find(1);
        $email = Email::create($input);
        $email->user()->associate($user);
        $user->notify(new NotifyEmails($email));

    }
	
	public function subscribe(Request $request) {
        
        $input = $request->except(['_token']);
        
        $messages = array(
            'email.required' => 'Поле не заполнено',
            'email.email' => 'Некорректно введен E-mail',
        );
        
        $validator = Validator::make($input, [
            'email' => 'required|email',
        ], $messages);
        
        if($validator->fails()) {
            return   $validator->messages()->toArray();
        }
		
        //admin
        $user = User::find(1);
        $email = Email::create($input);
        $email->user()->associate($user);
        $user->notify(new NotifyEmails($email));

    }
}
