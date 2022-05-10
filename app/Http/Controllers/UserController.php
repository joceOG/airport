<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Rfc4122\UuidV4;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all() ;  
       // return  User::orderBy('created_at', 'DESC')->get();
         return response()->json( $users , 200);
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
        $newItem = new User();
        $newItem->user_id = UuidV4::uuid4();
        $newItem->first_name = $request->user['first_name'];
        $newItem->email = $request->user['email'];
        $newItem->password = $request->user['password'];
        $newItem->save();

        return $newItem;
    }

    public function check(Request $request)
    {   
        $user = User::where('email','=', $request->user['email'])->first();
        if($user) {
            if( $user->password == $request->user['password'] )
            {
                return response()->json(['status'=>'true','message'=>'Authentification Reussie']);  
            }else{
                return response()->json(['status'=>'false','message'=>'Mot de Passe Incorrect']);
            }          
        } else {
            return response()->json(['status'=>'false', 'message'=>'Email Incorrect']);
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
        $existingAd = User::find($id);

        if ($existingAd) {
            $existingAd->departure = $request->ad['departure'];
            $existingAd->destination = $request->ad['destination'];
            $existingAd->departure_date = $request->ad['departure_date'];
            $existingAd->arrival_date = $request->ad['arrival_date'];
            $existingAd->space = $request->ad['space'];
            $existingAd->packages_accepted = $request->ad['packages_accepted'];
            $existingAd->save();

            return $existingAd;
        } else {
            return "Ad not found";
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
        $existingItem = Ads::find($id);

        if ($existingItem ) {
            $existingItem ->delete();
            return "Ad successfully deleted";
        } else {
            return "Ad not found";
        }

    }
}
