<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Database\Factories\AppointmentFactory;
use Database\Seeders\AppointmentSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::all ();

        return $appointments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request -> all ();

        $rules = [
            'reason' => 'required',
            'date' => 'required',
        ];

        $messages = [
            'reason.required' => 'Reason field is required',
            'date.required' => 'Date field is required',
        ];

        $validator = validator::make ($input, $rules, $messages);

        if ($validator -> fails ()) {
            return response () -> json ([$validator -> errors ()], 400);
        }
        else {
            $appointment = Appointment::create ($input) -> makeHidden ('id');

            return $appointment;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show ($id)
    {
        $appointment = Appointment::find ($id) -> makeHidden (['created_at', 'updated_at']);

        return $appointment;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment -> delete ();
    }
}
