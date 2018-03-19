@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar usuario - {{ $user->name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
                        {!! Form::label('Nome:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}

                        {!! Form::label('Email:') !!}
                        {!! Form::email('email', null, ['class' => 'form-control']) !!}

                        {!! Form::label('Setor:') !!}
                        {!! Form::select('sector_id', $sectors, null, ['class' => 'form-control']) !!}

                        {!! Form::label('Senha:') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}

                        {!! Form::submit('Salvar', ['class' => 'btn']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
