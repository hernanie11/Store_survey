<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreEngagementFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $ras_name = $request->ras_name;
        $ras_contact_details = $request->ras_contact_details;
        $store_name = $request->store_name;
        $sos_team_leader = $request->sos_team_leader;
        $objective_of_visit = $request->objective_of_visit;
        $strategy_determination = $request->strategy_determination;
        $activity_plan = $request->activity_plan;
        $findings = $request->findings;
        $notes = $request->notes;

        
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
