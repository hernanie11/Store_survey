<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
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
        $Location = Location::where(function($query) use($status){
            $query->where('is_active', $status);
        })
        ->orderby('created_at', 'DESC')
        ->useFilters()
        ->dynamicPaginate();
        return $Location;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location_request = $request->all('result.locations');
        if(empty($request->all())){
            return response()->json(['message' => 'Data not Ready']);
        }
        
        foreach($location_request as $locations){
            foreach($locations as $location){
                foreach($location as $loc){
                    $code = $loc['code'];
                    $name = $loc['name'];
                    $is_active = $loc['status'];

                    $sync = Location::updateOrCreate([
                        'location_code' => $code],
                        ['location_name' => $name, 'is_active' => $is_active],
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
