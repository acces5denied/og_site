<?php

namespace App\Http\Controllers;

use App\Email;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NotifyEmails;

class EmailController extends Controller
{
    public function send(Request $request) {
        
        $input = $request->except(['_token', 'broker']);
        
        $messages = array(
            'name.required' => 'Поле не заполнено',
            'name.max' => 'Слишком длинное имя',
            'phone.required_without' => 'Поле не заполнено',
            'email.required_without' => 'Поле не заполнено',
            'email.email' => 'Некорректно введен E-mail',
        );
        
        $validator = Validator::make($input, [
            'name' => 'required|max:30',
            'phone' => 'required_without:email',
            'email' => 'required_without:phone|nullable|email',
        ], $messages);
        
        dd($input);
        
        if($validator->fails()) {
            return   $validator->messages()->toArray();
        }
        
        $user = User::find($request->broker);
        $email = Email::create($input);
        $email->user()->associate($user);
        $user->notify(new NotifyEmails($email));

    }
}
