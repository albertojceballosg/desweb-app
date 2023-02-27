@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Detalle del Usuario') }}</div>
                <div class="card-body">
                    @if(Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            <div class="alert-text">{{ Session::get('success') }}</div>
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger" role="alert">
                            <div class="alert-text">{{ Session::get('error') }}</div>
                        </div>
                    @endif
                    <a href="{{ route('users.index') }}" class="btn btn-info"><i class="fa fa-list"></i> Listar</a>
                    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</a>
                    <a href="{{ route('users.edit', encrypt($user->id)) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Modificar</a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-trash"></i> Eliminar</button>
                    <br><br>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <img src="{{ $user->photo_url }}" style="width:120px; border-radius: 10px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-12 mb-2">
                                <b>Nombre:</b> {{ $user->name }}
                            </div>
                            <div class="col-md-12 mb-2">
                                <b>Email:</b> {{ $user->email }}
                            </div>
                            <div class="col-md-12 mb-2">
                                <b>Fecha de Nacimiento:</b> {{ date("d-m-Y", strtotime($user->birthdate)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                Elimninar este registro
            </div>
            <form action="{{ route('users.destroy', encrypt($user->id)) }}" method="POST">
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection