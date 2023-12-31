<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RoleManagement;
use App\Http\Requests\RoleManagementRequest;

class RoleManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        switch ($status) {
            case "active":
            case null:
            default:
                $status = 1;
                break;
            case "deactivated":
                $status = 0;
                break;
        }
        $RoleManagement = RoleManagement::withTrashed()
        ->where(function($query) use($status){
            $query->where('is_active', $status);
        })
        ->orderby('created_at', 'DESC')
        ->useFilters()
        ->dynamicPaginate();

        foreach($RoleManagement as $access){
            $access_permission = explode(", ", $access->access_permission);
        
            $access['access_permission'] = $access_permission;
        }

        return $RoleManagement;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleManagementRequest $request)
    {
        $role_name = $request->role_name;
        $access_permission = $request->access_permission;
        $accessConvertedToString = implode(", ",$access_permission);
        $create = RoleManagement::create([
            'role_name' => $role_name,
            'access_permission' => $accessConvertedToString,
            'is_active' => 1
        ]);
        return response()->json(['message' => 'Successfully Created', 'data'=>$create]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleManagementRequest $request, $id)
    {
        $role_name = $request->role_name;
        $access_permission = $request->access_permission;
        $accessConvertedToString = implode(", ",$access_permission);
        $RoleManagement = RoleManagement::find($id);
        if(!$RoleManagement){
            return response()->json(['error' => 'Role Management Route Not Found'], 404);
        }
        if($RoleManagement->where('role_name', $role_name)->exists()){
            $get_permission = $RoleManagement->access_permission;
            $permission_to_array = explode(", ", $get_permission);
            $compare_permission = (array_diff($permission_to_array,$access_permission) || array_diff($access_permission,$permission_to_array));
            if(empty($compare_permission)){
                return response()->json(['message' => 'No Changes'], 200);
            }
        }
        $update = RoleManagement::where('id',$id)
         ->update([
            'role_name' => $role_name,
            'access_permission' => json_encode($accessConvertedToString),
            'is_active' => 1
        ]);
        return response()->json(['message' => 'Successfully Updated!'], 200);
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

    public function archived(RoleManagementRequest $request, $id){
        $status = $request->status; 
        $RoleManagement = RoleManagement::query();
        if(!$RoleManagement->withTrashed()->where('id',$id)->exists()){
            return response()->json(['error' => 'Role Management Route Not Found'], 404);
        }
        if(User::where('role_id', $id)->exists()){
            if($status == true){
                return response()->json(['message' => 'No Changes'],200);
            }
            else{
                return response()->json(['message' => 'Unable to Archive, Role already in used!'],409);
            }
        }
        
        if($status == false){
            if(!RoleManagement::where('id', $id)->where('is_active', true)->exists()){
                return response()->json(['message' => 'No Changes'], 200);
            }
            else{
                $updateStatus = $RoleManagement->where('id', $id)->update(['is_active' => false]);
                $RoleManagement->where('id',$id)->delete();
                return response()->json(['message' => 'Successfully Deactived!'], 200);
            }
        }
        if($status == true){
            if(RoleManagement::where('id', $id)->where('is_active', true)->exists()){
                return response()->json(['message' => 'No Changes'], 200);

            }
            else{              
                $restoreUser = $RoleManagement->withTrashed()->where('id',$id)->restore();
                $updateStatus = $RoleManagement->update(['is_active' => true]); 
                return response()->json(['message' => 'Successfully Activated!'], 200);
            }
        }
    }
}
