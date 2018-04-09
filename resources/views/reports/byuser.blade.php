@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Relatórios de {{ $user }} - {{ $data }}

                        <a href="{{ route('reports.index') }}" class="btn btn-info">Voltar</a>
                    </div>
                </div>
                <div class="panel-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Quantidade em horas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td>{{ $report->c }}</td>
                                    <td>{{ gmdate('H:i:s', $report->s) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
