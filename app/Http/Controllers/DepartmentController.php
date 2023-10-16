<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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
        $Department = Department::where(function($query) use($status){
            $query->where('is_active', $status);
        })
        ->orderby('created_at', 'DESC')
        ->useFilters()
        ->dynamicPaginate();
        return $Department;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $department_request = $request->all('result.departments');
        if(empty($request->all())){
            return response()->json(['message' => 'Data not Ready']);
        }
        
        foreach($department_request as $departments){
            foreach($departments as $department){
                foreach($department as $dept){
                    $code = $dept['code'];
                    $name = $dept['name'];
                    $is_active = $dept['status'];

                    $sync = Department::updateOrCreate([
                        'department_code' => $code],
                        ['department_name' => $name, 'is_active' => $is_active],
                    );
                    
                }
            
            }
        }
        return response()->json(['message' => 'Successfully Synched!']);
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
}
