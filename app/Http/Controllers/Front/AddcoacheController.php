<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Coache;

class AddcoacheController extends Controller
{

   public function __construct()
   {
       $this->middleware('auth');
   }

   public function show(){

      $coaches = Coache::all();
      
      return view('showcoaches',compact('coaches'));
   }

   
   public function insert(){
   
      return view('addcoache');
  }
  
  public function create(Request $request){

  
      $rules = [
       'firstname' => 'required|string|min:3|max:50',
       'lastname' => 'required|string|min:3|max:50',
       'email' => 'required|string|email|unique:coaches,email|min:9|max:255',
       'specialize' => 'required|string|max:20',
       'image' => 'nullable|mimes:jpeg,jpg,png',
    ];
    $validator = Validator::make($request->all(),$rules);
    if ($validator->fails()) {
       return redirect()->back()
       ->withInputs($request->all())
       ->withErrors($validator);
    }
    else{
          $data = $request->input();
       try{
         $coache = new Coache;
         $coache->firstname = $data['firstname'];
         $coache->lastname = $data['lastname'];
         $coache->specialize = $data['specialize'];
         $coache->email = $data['email'];
         if($request->hasfile('image')){
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/images/',$filename);
         $coache->image = $filename;
         }

         $coache->save();
          return redirect('addcoache/insert')->with('status',"Insert successfully");
       }
       catch(Exception $e){
          return redirect('addcoache/insert')->with('failed',"operation failed");
       }
    }
  }
}
