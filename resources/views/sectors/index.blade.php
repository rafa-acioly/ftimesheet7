@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Lista de setores
                        <a href="{{ route('sectors.create') }}" class="btn btn-info">Novo</a>
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
                                <th>ID</th>
                                <th>Setor</th>
                                <th>Data de cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sectors as $sector)
                                <tr>
                                    <th>{{ $sector->id }}</th>
                                    <th>{{ $sector->name }}</th>
                                    <th>{{ $sector->created_at->format('d/m/Y') }}</th>
                                    <th>
                                        <a href="{{ route('sectors.edit', $sector->id) }}" class="btn btn-success">Editar</a>
                                        <form action="{{ route('sectors.destroy', $sector->id) }}" method="POST">
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
