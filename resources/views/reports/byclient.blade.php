@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Relatórios do client {{ $client }} - {{ $data }}

                        <a href="{{ route('reports.index') }}" class="btn btn-info">Voltar</a>
                    </div>
                </div>
                <div class="panel-body text-center">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <h1>{{ gmdate('H:i:s', $time) }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
