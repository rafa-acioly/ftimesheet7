@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cadastrar novo usuário</div>

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

                    {!! Form::open(['route' => 'users.store']) !!}
                        {!! Form::label('Nome:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}

                        {!! Form::label('Email:') !!}
                        {!! Form::email('email', null, ['class' => 'form-control']) !!}

                        {!! Form::label('Setor:') !!}
                        {!! Form::select('sector_id', $sectors, null, ['class' => 'form-control']) !!}

                        {!! Form::label('Senha:') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}

                        {!! Form::submit('Salvar', ['class' => 'btn btn-info']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
