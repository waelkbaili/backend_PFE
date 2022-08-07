<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tripdata;
use App\Models\Trip;

class TripdataController extends Controller
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
        //Tripdata::create($request->all());
        $tripData=Tripdata::create([
            //'sensor'=>$request['sensor'],
            'latitude'=>$request['latitude'],
            'longitude'=>$request['longitude'],
            'speed'=>$request['speed'],
            'user_id'=>$request['user_id'],
            'engine_rpm'=>$request['engine_rpm'],
            'engine_load'=>$request['engine_load'],
            'ambiant_temp'=>$request['ambiant_temp'],
            'throttle_pos'=>$request['throttle_pos'],
            'inst_fuel'=>$request['inst_fuel'],
            'zone'=>$request['zone'],
            'place'=>$request['place'],
        ]);
        if(!$tripData){
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

    public function getPosition(Request $request){
        $date_start=$request->date_start;
        $user_id=$request->user_id;
        $date_end=Trip::where([['user_id','=',$user_id],['date_start','=',$date_start]])
                        ->selectRaw('date_end')->get();
        $date_end=$date_end[0]->date_end;
        $tripId=Trip::where([['user_id','=',$user_id],['date_start','=',$date_start],['date_end','=',$date_end]])
        ->selectRaw('id')->get();
        $tripId=$tripId[0]->id;
        $position=Tripdata::where([['user_id','=',$user_id],['created_at','>=',$date_start],
                             ['created_at','<=',$date_end]])->select('latitude','longitude','created_at','zone')
                             ->orderBy('created_at')->get();

        if(count($position)<15){
            Trip::destroy($tripId);
            return[
                'status'=>'succes',
                'data'=>$position
            ];
        }
        else{
            return[
                'status'=>'succes',
                'data'=>$position
            ];
        }

    }

    public function getLastPosition(Request $request){
        $date_start=$request->date_start;
        $user_id=$request->user_id;
        $position=Tripdata::where([['user_id','=',$user_id],['created_at','>=',$date_start]]
        )->select('latitude','longitude','speed')
                             ->orderBy('created_at')->get();
        if(count($position)>0){
            return[
                'status'=>'succes',
                'data'=>$position
            ];
        }
        else{
            return[
                'status'=>'echec'
            ];
        }


    }

    public function last($user_id){
        $lastTrip_start=Trip::where('user_id','=',$user_id)->orderBy('date_start','desc')->selectRaw('date_start')->first();
        $lastTrip_end=Trip::where('user_id','=',$user_id)->orderBy('date_end','desc')->selectRaw('date_end')->first();
        $lastTrip_id=Trip::where('user_id','=',$user_id)->orderBy('date_end','desc')->selectRaw('id')->first();

        $lastTrip_start=$lastTrip_start->date_start;
        $lastTrip_end=$lastTrip_end->date_end;
        $position=Tripdata::where([['user_id','=',$user_id],['created_at','>=',$lastTrip_start],
                             ['created_at','<=',$lastTrip_end]])->select('latitude','longitude','created_at','zone')
                             ->orderBy('created_at')->get();
        if(count($position)<15){
            $tripId=Trip::find($lastTrip_id);
            Trip::destroy($tripId);
            return $this->last($user_id);
        }
        else{
            return[
                'status'=>'succes',
                'data'=>$position
            ];
        }

    }
}
