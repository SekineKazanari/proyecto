<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loan;
use Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasPermissionTo('crud users')){
            $users = User::all();
            return view('users.index',compact('users'));
        }
        return redirect()->back()->with("error","No tienes permisos"); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasPermissionTo('crud users')){
            $user = new User();
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'role_id' => $request['role_id']
            ]);
            $user->assignRole($user->role_id);
            if($user->name!=null){
                return  redirect()->back()->with('success', 'Se ha creado el usuario');
            }
            return  redirect()->back()->with('error', 'No se ha creado el usuario');
        }
        return redirect()->back()->with("error","No tienes permisos"); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->hasPermissionTo('crud users')){
            $user = User::find($id)->get();
            $loans = Loan::where('user_id', $id)->get();
            return view('users.details',compact('user','loans'));
        }
        return redirect()->back()->with("error","No tienes permisos"); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->hasPermissionTo('crud users')){
            $user = User::find($request['id']);
            if($user->Update($request->all())){
                return  redirect()->back()->with('success', 'El usuario se ha actualizado correctamente');
            }
            return  redirect()->back()->with('error', 'No se pudo actualizar el usuario');
        }
        return redirect()->back()->with("error","No tienes permisos"); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->hasPermissionTo('crud users')){
            $user = User::find($id);
            if($user!=null){
                Loan::where('user_id',$id)->delete();
                if($user->delete()){
                    return response()->json([
                        'message' => 'Se ha eliminado el usuario', 
                        'code' => '200'
                    ]);
                }
                return response()->json([
                        'message' => "No ha eliminado el usuario", 
                        'code' => '400'
                    ]);
            }
        }
        return response()->json([
            'message' => "No tienes permisos", 
            'code' => '403'
        ]);
    }
}
