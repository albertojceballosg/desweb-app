<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::simplePaginate(20);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'photo' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users',
            'birthdate' => 'required',
        ];
        $customMessages = [
            'photo.required' => 'El campo foto es requerido',
            'name.required' => 'El campo nombre es requerido',
            'email.required' => 'El campo email es requerido',
            'birthdate.required' => 'El campo fecha de nacimiento es requerido',
        ];

        $validatedData = $request->validate($rules, $customMessages);

        $file = $request->file('photo');
        $path = $_SERVER['DOCUMENT_ROOT'].'/public_html/avatar/';
        $url = 'http://'.$_SERVER['HTTP_HOST'].'/public_html/avatar/';

        if($file){
            if(strtolower($file->extension()) != 'png' && strtolower($file->extension()) != 'jpg' && strtolower($file->extension()) != 'jpeg'){
                return redirect()->back()->with('error', 'Photos must be uploaded in formats png,jpg');
            }
            
            $fileName = $file;
            
            $rand = rand(100000, 999999);
            $fileName = $rand.'-'.$file->getClientOriginalName();
            $file->move($path, $fileName);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->birthdate = $request->birthdate;
        $user->photo = $fileName;
        $user->photo_local = $path.$fileName;
        $user->photo_url = $url.$fileName;
        if($user->save()){
            return redirect()->route('users.show', encrypt($user->id))->with('success', 'Registro creado exitosamente.');
        }else{
            return redirect()->route('users.show', encrypt($user->id))->with('error', 'Error al insertar.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'birthdate' => 'required',
        ];
        $customMessages = [
            'name.required' => 'El campo nombre es requerido',
            'email.required' => 'El campo email es requerido',
            'birthdate.required' => 'El campo fecha de nacimiento es requerido',
        ];
        $validatedData = $request->validate($rules, $customMessages);

        $file = $request->file('photo');
        $path = $_SERVER['DOCUMENT_ROOT'].'/public_html/avatar/';
        $url = 'http://'.$_SERVER['HTTP_HOST'].'/public_html/avatar/';

        if($file){
            if(strtolower($file->extension()) != 'png' && strtolower($file->extension()) != 'jpg' && strtolower($file->extension()) != 'jpeg'){
                return redirect()->back()->with('error', 'Photos must be uploaded in formats png,jpg');
            }
            
            $fileName = $file;
            
            $rand = rand(100000, 999999);
            $fileName = $rand.'-'.$file->getClientOriginalName();
            $file->move($path, $fileName);
        }

        $id = Crypt::decrypt($id);
        $user = User::findOrFail($id);
        if($user->email != $request->email){
            $flag = User::where('email', $request->email)->count();
            if($flag > 0){
                return redirect()->back()->with('error', 'Ya exite un resgistro con este correo.');
            }
        }
        $user->email = $request->email;
        $user->name = $request->name;
        $user->birthdate = $request->birthdate;
        if($file){
            $user->photo = $fileName;
            $user->photo_local = $path.$fileName;
            $user->photo_url = $url.$fileName;
        }
        if($user->save()){
            return redirect()->route('users.show', encrypt($user->id))->with('success', 'Registro modificado exitosamente.');
        }else{
            return redirect()->route('users.show', encrypt($user->id))->with('error', 'Error al modificar.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::findOrFail($id);

        if($user->photo){
            unlink($user->photo_local);
        }

        if($user->delete()){
            return redirect()->route('users.index')->with('success', 'Registro eliminado exitosamente.');
        }else{
            return redirect()->route('users.index')->with('error', 'Error al eliminar.');
        }
    }
}
