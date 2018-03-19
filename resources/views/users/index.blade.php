@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Lista de usuarios
                    <a href="{{ route('users.create') }}" class="btn btn-info">Novo</a>
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
                            <th>Nome</th>
                            <th>Setor</th>
                            <th>Email</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th>{{ $user->name }}</th>
                                <th>{{ optional($user->sectors)->name ?? '#' }}</th>
                                <th>{{ $user->email }}</th>
                                <th>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success">Editar</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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
@endsection
