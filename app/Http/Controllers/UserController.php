<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        if($status == NULL ){
            $status = 1;
        }
        if($status == "active"){
            $status = 1;
        }
        if($status == "deactivated"){
            $status = 0;
        }
        if($status != "active" || $status != "deactivated"){
            $status = 1;
        }
        $user = User::withTrashed()
        ->where(function($query) use($status){
            $query->where('is_active', $status);
        })
        ->orderby('created_at', 'DESC')
        ->useFilters()
        ->dynamicPaginate();
        
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users = User::create([
            "id_prefix" => $request["personal_info"]["id_prefix"],
            "id_no" => $request["personal_info"]["id_no"],
            "first_name" => $request["personal_info"]["first"],
            "middle_name" => $request["personal_info"]["middle"],
            "last_name" => $request["personal_info"]["last"],
            "sex" => $request["personal_info"]["sex"],
            "role_id" => $request["role_id"],
            "location_name" => $request["location"],
            "department_name" => $request["department"],
            "company_name" => $request["company"],
            "username" =>  $request["personal_info"]["username"],
            "password" => Crypt::encryptString($request["personal_info"]["username"])
        ]);

        return response()->json(['message' => 'Successfully Created'], 201);
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


    public function search(){
        $user = User::useFilters()
        ->dynamicPaginate();
        return $user;
    }

    public function archive(Request $request, $id){
        // $auth_id = auth('sanctum')->user()->id;
        // if($id == $auth_id){
        //     return response()->json(['message' => 'Unable to Archive, User already in used!'],409);
        // }
        $status = $request->status; 
        $User = User::query();
        if(!$User->withTrashed()->where('id',$id)->exists()){
            return response()->json(['error' => 'User Route Not Found'], 404);
        } 
        if($status == false){
            if(!User::where('id', $id)->where('is_active', true)->exists()){
                return response()->json(['message' => 'No Changes'], 200);
            }
            else{
                $updateStatus = $User->where('id', $id)->update(['is_active' => false]);
                $User->where('id',$id)->delete();
                return response()->json(['message' => 'Successfully Deactived!'], 200);
            }
        }
        if($status == true){
            if(User::where('id', $id)->where('is_active', true)->exists()){
                return response()->json(['message' => 'No Changes'], 200);
            }
            else{              
                $restoreUser = $User->withTrashed()->where('id',$id)->restore();
                $updateStatus = $User->update(['is_active' => true]); 
                return response()->json(['message' => 'Successfully Activated!'], 200);
            }
        }

    }
}
