<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Car;
use App\Util\Utils;
use Illuminate\Support\Facades\Auth;
use Response;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->type_id == 1){
            $cars = Car::orderBy('id', 'desc')->paginate(5);
            $cars->load(['user']);
            return $cars;
        }

        if(Auth::user()->type_id == 2){
            $cars = Car::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(5);
            $cars->load(['user']);
            return $cars;
        }
    }

    /**
     * Display a listing of the resource by search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

        if(Auth::user()->type_id == 1){
            $asd = $request->input('brand');
            $cars = Car::join('users', 'users.id', '=', 'cars.user_id')
            ->where('brand','like','%'.$request->input('brand').'%')
            ->where('license_plate_number','like','%'.$request->input('license_plate_number').'%')
            ->where('name','like','%'.$request->input('user').'%')
            ->orderBy('cars.id', 'desc')->paginate(5);
            $cars->load(['user']);
            return $cars;
        }

        if(Auth::user()->type_id == 2){
            $cars = Car::where('user_id', Auth::user()->id)
            ->where('brand','like','%'.$request->input('brand').'%')
            ->where('license_plate_number','like','%'.$request->input('license_plate_number').'%')
            ->orderBy('id', 'desc')->paginate(5);
            $cars->load(['user']);
            return $cars;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request);

        $input = $request->all();
        $car = Car::create($input);
        $car->load(['user']);
        return response()->json($car, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Car  $Car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $input = $request->all();

        $this->validator($request, $car->id);

        $car->update($input);
        $car->load(['user']);
        return $car;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Car  $Car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return response()->json(null, 204);
    }

    private function validator(Request $request, $id = null)
    {
        //TODO
        $request->validate([
            'license_plate_number' => 'required|regex:/[A-Z]{1,5}[\-]{1}[0-9]{1,5}/',
            'brand' => 'required|max:191',
            'vintage' => 'required|digits:4',
        ],[
            'license_plate_number.regex' => __('cars.invalid_license_plate_number_format')
        ]);
    }
}