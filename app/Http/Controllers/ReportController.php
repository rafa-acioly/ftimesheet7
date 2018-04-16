<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'users' => \App\User::all()->pluck('name', 'id'),
            'sectors' => \App\Sector::all()->pluck('name', 'id'),
            'clients' => \App\Client::all()->pluck('name', 'id'),
        ];
        
        return view('reports.index', $data);
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
        //
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

    public function filterByUser(Request $request)
    {
        $userReport = \App\User::find($request->user_id)
            ->times()
            ->whereBetween('created_at', [$request->start, $request->end])
            ->orderBy('client_id', 'asc')
            ->get();

        
        $reports = $userReport->groupBy('client_id');

        $tm = \Carbon\Carbon::now();
        $reports->each(function ($item) use ($tm) {
            $item->s = \Carbon\Carbon::now();
            $item->each(function ($t) use (&$item) {
                $item->c = $t->clients->name;
                list($h, $m, $s) = explode(':', $t->duration);
                $item->s->addHour($h)->addMinutes($m)->addSeconds($s);
            });
            $item->s = $tm->diffInSeconds($item->s);
        });

        return view('reports.byuser', [
            'reports' => $reports, 
            'data' => (new \DateTime($request->start))->format('d/m/Y') . " e " . (new \DateTime($request->end))->format('d/m/Y'),
            'user' => \App\User::find($request->user_id)->name
        ]);
    }

    public function filterBySector(Request $request)
    {
        $sectorsTime = \App\Sector::find($request->id)
            ->times()
            ->whereBetween('created_at', [$request->start, $request->end])
            ->get()
            ->groupBy('client_id');

        $tm = \Carbon\Carbon::now();
        $sectorsTime->each(function ($s) use ($tm) {
            $s->t = \Carbon\Carbon::now();
            $s->each(function ($time) use (&$s) {
                $s->client = $time->clients->name;
                list($h, $m, $sec) = explode(':', $time->duration);
                $s->t->addHour($h)->addMinutes($m)->addSeconds($sec);
            });
            $s->t = $tm->diffInSeconds($s->t);
        });

        return view('reports.bysector', [
            'sector' => \App\Sector::find($request->id)->name,
            'reports' => $sectorsTime,
            'data' => (new \DateTime($request->start))->format('d/m/Y') . " e " . (new \DateTime($request->end))->format('d/m/Y'),
        ]);
    }

    public function filterByClient(Request $request)
    {
        $client = \App\Client::find($request->id)->times()->whereBetween('created_at', [
            \Carbon\Carbon::parse($request->start),
            \Carbon\Carbon::parse($request->end)->addDay(1)
        ])->get();

        $now = \Carbon\Carbon::now();
        $total = \Carbon\Carbon::now();
        foreach($client as $time) {
            list($h, $m, $sec) = explode(':', $time->duration);
            $total->addHour($h)->addMinutes($m)->addSeconds($sec);
        }

        return response()->json([
            'time' => $now->diff($total)->format('%H:%M:%S'),
        ], 200)->header('Content-Type', 'application/json');
    }

    public function history()
    {
        $history = \Auth::user()->times()->orderBy('created_at', 'desc')->get();

        return view('reports.history', compact('history'));
    }
}
