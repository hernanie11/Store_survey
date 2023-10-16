<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
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
        $Company = Company::where(function($query) use($status){
            $query->where('is_active', $status);
        })
        ->orderby('created_at', 'DESC')
        ->useFilters()
        ->dynamicPaginate();
        return $Company;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $company_request = $request->all('result.companies');
        if(empty($request->all())){
            return response()->json(['message' => 'Data not Ready']);
        }
        
        foreach($company_request as $companies){
            foreach($companies as $company){
                foreach($company as $com){
                    $code = $com['code'];
                    $name = $com['name'];
                    $is_active = $com['status'];

                    $sync = Company::updateOrCreate([
                        'company_code' => $code],
                        ['company_name' => $name, 'is_active' => $is_active],
                    );
                    // $sync = Company::upsert([
                    //     ['company_code' => $code, 'company_name' => $name,  'is_active' => $is_active]
                    //     ], ['company_code'], ['is_active']);
                    
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
