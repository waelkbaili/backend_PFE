<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livetrip;
use App\Models\Tripdata;

class LivetripController extends Controller
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
        $livetrip=Livetrip::create([
            'date_start'=>$request['date_start'],
            'vin'=>$request['vin'],
            'user_id'=>$request['user_id']
        ]);
        if(!$livetrip){
            $response=[
                'status'=>'echec'
            ];
        }
        else{
            $response=[
                'status'=>'succes'
            ];
        }

         return response($response);
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

    public function findLiveTrip($user_id){
        $liveTrip=Livetrip::where('user_id','=',$user_id)->select('date_start')->get();
        if($liveTrip&&$liveTrip->count()==0){
            return[
                'status'=>'echec'
            ];
        }
        else{
            $date_start=$liveTrip[0]->date_start;
            $position=Tripdata::where([['user_id','=',$user_id],['created_at','>=',$date_start]])->select('latitude','longitude','created_at','zone')
                             ->orderBy('created_at')->get();
            $last_date=$position[count($position)-3];
            $last_date=$last_date->created_at->format('Y-m-d H:i:s');
            return[
                'status'=>'succes',
                'last'=>$last_date,
                'data'=>$position
            ];
        }

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
    public function destroy($user_id)
    {
        Livetrip::where('user_id','=',$user_id)->delete();
    }
}
