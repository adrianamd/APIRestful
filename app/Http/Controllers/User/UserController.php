<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { /*a treves del metodo get en postman*/
       $usuarios = User::all();
       return $this->showAll($usuarios); 
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { /*a traves del metodo post en postman*/
        $reglas = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed ' 
        ];

        $this->validate($request, $reglas);

        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        $campos['verification_token'] = User::generarVerificationToken();
        $campos['admin'] = User::USUARIO_REGULAR();

        $usuario = User::create($campos);

        return $this->showOne($usuario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
       return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {  /*a traves de put en postman y con x-www-form...*/
       $reglas = [
            'email' => 'email|unique:users,email,'. $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
       ];    

       $this->validate($request, $reglas); 

        if($request->has('name')){
         $user->name = $request->name; 
        } /*fin de if-name*/

       if ($request->has('email') && $user->email != $request->email) {
           $user->verified = User::USUARIO_NO_VERIFICADO;
           $user->verification_token = User::generarVerificationToken();
           $user->email = $request->email;
       }/*fin de if-email*/

       if($request->has('password')){
          $user->password = bcrypt($request->name); 
        } /*fin de if-password*/


        if($request->has('admin')){
            if(!$user->esVerificado()){
                return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor de administrador',409); 
            } /*fin de if-esVerificado*/          

            $user->admin = $request->admin;
        } /*fin de if-admin*/

        if($user->isDyrty()){
           return $this->errorResponse('se debe especificar al menos un valor diferente para actualizar',422);
        }

        $user->save();

        return $this->showOne($user);

    } /*fin de funcion update*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {  /*con el metodo delete en postman*/
        $user->delete();
        return $this->showOne($user);       
    }
}
