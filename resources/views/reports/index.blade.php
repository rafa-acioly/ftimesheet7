@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Relatórios por usuário
                    </div>
                </div>
                {!! Form::open(['route' => 'reports.byuser']) !!}
                <div class="panel-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <div class="col-md-6">
                        <label for="">Usuario</label>
                        {!! Form::select('user_id', $users, null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="">
                            Inicio
                            {!! Form::date('start', null, ['class' => 'form-control']) !!}
                        </label>
                        <label for="">
                            Fim
                            {!! Form::date('end', null, ['class' => 'form-control']) !!}
                        </label>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    {!! Form::submit('Filtrar', ['class' => 'btn btn-info']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Relatórios por setor
                    </div>
                </div>
                {!! Form::open(['route' => 'reports.bysector']) !!}
                <div class="panel-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <div class="col-md-6">
                        <label for="">Usuario</label>
                        {!! Form::select('id', $sectors, null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="">
                            Inicio
                            {!! Form::date('start', null, ['class' => 'form-control']) !!}
                        </label>
                        <label for="">
                            Fim
                            {!! Form::date('end', null, ['class' => 'form-control']) !!}
                        </label>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    {!! Form::submit('Filtrar', ['class' => 'btn btn-info']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Relatórios por clientes
                    </div>
                </div>
                {!! Form::open(['route' => 'reports.byclient']) !!}
                <div class="panel-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <div class="col-md-6">
                        <label for="">Usuario</label>
                        {!! Form::select('id', $clients, null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="">
                            Inicio
                            {!! Form::date('start', null, ['class' => 'form-control']) !!}
                        </label>
                        <label for="">
                            Fim
                            {!! Form::date('end', null, ['class' => 'form-control']) !!}
                        </label>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    {!! Form::submit('Filtrar', ['class' => 'btn btn-info']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
