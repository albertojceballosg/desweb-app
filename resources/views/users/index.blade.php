@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Listado de Usuarios') }}</div>
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
                	<a href="{{ route('users.create') }}" class="btn btn-primary"><i style="font-size: 10px;" class="fa fa-plus"></i> Agregar</a>
                	<br><br>
                    <table class="table table-hover">
                        <thead>
                          	<tr>
                            	<th>Nombre</th>
                            	<th>Email</th>
                            	<th>Fecha de Nacimiento</th>
                            	<th>Acciones</th>
                          	</tr>
                        </thead>
                        <tbody>
                        	@if(count($users) > 0)
	                        	@foreach($users as $key => $value)
		                          	<tr>
		                            	<td>{{ $value->name }}</td>
		                            	<td>{{ $value->email }}</td>
		                            	<td>{{ date("d-m-Y", strtotime($value->birthdate)) }}</td>
		                            	<td>
		                            		<div class="btn-group" role="group" aria-label="Basic example">
		                            		  	<a href="{{ route('users.show', encrypt($value->id)) }}" class="btn btn-info"><i class="fa fa-search"></i></a>
		                            		  	<a href="{{ route('users.edit', encrypt($value->id)) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
		                            		  	<button href="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-{{ $value->id }}"><i class="fa fa-trash"></i></button>
		                            		  	<div class="modal fade" id="exampleModal-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
		                            		  	      		<form action="{{ route('users.destroy', encrypt($value->id)) }}" method="POST">
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
		                            		</div>
		                            	</td>
		                          	</tr>
		                        @endforeach
		                    @else
		                    	<tr>
		                    		<td colspan="4"><p class="text-center">No hay usuarios registrados</p></td>
		                    	</tr>
		                    @endif
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection