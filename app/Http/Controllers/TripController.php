<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;

class TripController extends Controller
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
        $trip=Trip::create([
            'date_start'=>$request['date_start'],
            'date_end'=>$request['date_end'],
            'vin'=>$request['vin'],
            'user_id'=>$request['user_id']
        ]);
        if(!$trip){
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

    }

    public function showListTrip(Request $request){
        $user_id=$request->user_id;
        $date_deb=$request->date_deb;
        $date_end=$request->date_end;
        $listTrip=Trip::where([['user_id','=',$user_id],['date_start','>=',$date_deb],['date_end','<=',$date_end]])->selectRaw('date_start')->orderBy('created_at','desc')->paginate(15);
        if($listTrip&&$listTrip->total()>0){
            $list=$listTrip->items();
            return[
                'status'=>'succes',
                'data'=>$list,
                'nbr'=>$listTrip->total()
            ];
        }
        else{
            return[
                'status'=>'echec'
            ];
        }

    }

    public function getListTripByVin($vin){
        $listTrip=Trip::where('vin','=',$vin)->select('date_start','user_id')->orderBy('created_at','desc')->paginate(15);
        if($listTrip&&$listTrip->total()>0){
            $list=$listTrip->items();
            return[
                'status'=>'succes',
                'data'=>$list,
                'nbr'=>$listTrip->total()
            ];
        }
        else{
            return[
                'status'=>'echec'
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
    public function destroy($id)
    {
        //
    }


}
