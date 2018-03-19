{!! Form::open($user, ['route' => 'users.store']) !!}
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