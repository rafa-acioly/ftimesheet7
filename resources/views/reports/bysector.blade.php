@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Relatórios do setor {{ $sector }} - {{ $data }}

                        <a href="{{ route('reports.index') }}" class="btn btn-info">Voltar</a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        <h3>Total: {{ gmdate('H:i:s', $sum) }}</h3>
                    </div>
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
                                    <td>{{ $report->client }}</td>
                                    <td>{{ gmdate('H:i:s', $report->t) }}</td>
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
