<?php

namespace App\Http\Controllers;

use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Http\Request;
//Validacion//
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles= Role::orderBy('id','desc')->paginate();

        return view('roles.index', compact('roles'));
    }


        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
          $permissions = Permission::get();
            return view('roles.create',compact('permissions'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(RoleStoreRequest $request)
        {
          //dd( $role->id);

           $role = Role::create($request->all());
           //Actualizar Permisos
           $role->permissions()->sync($request->get('permissions'));

           return redirect()->route('roles.create', $role->id)
            ->with('info','Role guardado con exito');
        }



    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
       $permissions = Permission::get();
       return view('roles.edit', compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        //actualizar role
        $role->update($request->all());

        //Actualizar Permisos
        $role->permissions()->sync($request->get('permissions'));

        return redirect()->route('roles.edit', $role->id)
         ->with('info','Role actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
    $role->delete();

    return back()->with('info','Eliminado Correctamente');
    }
}
