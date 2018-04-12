@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Meu histórico
                        </h3>
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
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Data</th>
                                    <th>Duração</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $times)
                                    <tr>
                                        <th>{{ $times->id }}</th>
                                        <th>{{ $times->clients->name }}</th>
                                        <th>{{ $times->created_at->format('d/m/Y') }}</th>
                                        <th>{{ $times->duration }}</th>
                                        <th>
                                            <!-- <a href="{{ route('time.edit', $times->id) }}" class="btn btn-success">Editar</a> -->
                                            <form action="{{ route('time.destroy', $times->id) }}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button class="btn btn-warning" type="submit">Excluir</button>
                                            </form>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
