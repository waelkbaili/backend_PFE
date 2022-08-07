<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Validator;


class CarController extends Controller
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
        $rules=array(
            'vin'=>'unique:cars'
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response=[
                'status'=>'vin existe'
            ];
        }
        else{
            Car::create($request->all());
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
    public function show($user_id)
    {
        $listCar=Car::where('user_id','=',$user_id)->selectRaw('vin')->orderBy('created_at','desc')->get();
        return[
            'status'=>'succes',
            'data'=>$listCar
        ];
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

    public function destroyByVIN(Request $request){
        $carVIN=$request->carVIN;
        $carId=Car::where('vin','=',$carVIN)->selectRaw('id')->get();
        $carId=$carId[0]->id;
        $car = Car::find($carId);
        if($car->delete()){
            return[
                'status'=>'succes'
            ];
        }
    }
}
