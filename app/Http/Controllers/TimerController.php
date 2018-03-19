<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Time;

class TimerController extends Controller
{
    private $time;

    public function __construct(Time $time)
    {
        $this->time = $time;
    }
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $request = $request->all();
        $data = array_merge([
            'user_id' => Auth::user()->id,
        ], $request);

        $this->time->fill($data);
        $this->time->save();

        return response()->json($data, 200)->header('Content-Type', 'application/json');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    public function get($clientID)
    {
        $times = Auth::user()->times
            ->where('client_id', $clientID)
            ->where('created_at', '>=', \Carbon\Carbon::today());

        $now = \Carbon\Carbon::now();
        $time = \Carbon\Carbon::parse();

        $times->each(function ($record) use (&$time, &$n){
            list($hours, $minutes, $seconds) = explode(':', $record->duration);
            $time->addHours($hours);
            $time->addMinutes($minutes);
            $time->addSeconds($seconds);
        });

        return response()->json(['time' => $now->diffInSeconds($time) * 100], 200)->header('Content-Type', 'application/json');
    }
}
