@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Lista de clientes
                        <a href="{{ route('clients.create') }}" class="btn btn-info">Novo</a>
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
                                <th>#</th>
                                <th>Nome</th>
                                <th>Data de cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <th>{{ $client->id }}</th>
                                    <th>{{ $client->name }}</th>
                                    <th>{{ $client->created_at->format('d/m/Y') }}</th>
                                    <th>
                                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-success">Editar</a>
                                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button class="btn" type="submit">Excluir</button>
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
@endsection
