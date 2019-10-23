<?php

namespace App\Http\Controllers\Admin;

use App\Email;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\AdminOffersFilter;
use Session;

class EmailsController extends Controller
{
    
    protected $emails;

    public function __construct(Email $emails)
    {
        $this->emails = $emails;
    }

    public function index(Request $request)
    {
        $counter = Email::all();
        
        $emails = Email::orderBy('created_at','DESC');
        
        $emails = (new AdminOffersFilter($emails, $request->all()))->apply()->simplePaginate(10);

        $data = [
            'emails' => $emails,
            'counter' => $counter,
        ];

        return view('backend.emails.index', $data);
    }

    public function show(Email $email)
    {

        $data = [
            'email' => $email,
        ];
        
        if (auth()->user()->unreadnotifications->count()):
        
            $id = auth()->user()->unreadNotifications[0]->id;

            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        
        endif;

        return view('backend.emails.show', $data);

    }

    public function destroy(Request $request)
    {
		
		 $input = $request->except('_token');
        
        $validator = Validator::make($input, [
            'email_id' => 'required',
        ]);
        
        if($validator->fails()) {
            return   redirect(Session::get('_previous')['url'])->withErrors($validator)->withInput();
        }
        
        $emails = Email::find($request->email_id);

        
        foreach($emails as $email){//loop through an Eloquent collection instance
            $email->delete();
        }

        return redirect(Session::get('_previous')['url']);
    }
}
