<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use Exception;

class UserController extends Controller
{
    private $path ='user';

    public function index(){

        $data = User::all();
        return view($this->path.'.index', compact('data'));
    }

    public function create(){
        
        return view($this->path.'.create');
    }

    public function store(Request $request){
        /*
         * Register user.
         * */
        try{
            $user = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect()->route('users.index');
        }
        catch(Exception $e){

            return "Fatal error - ".$e->getMessage();
        }
    }

    public function destroy($id){
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('users.index');
        } catch (Exception $e){

            return "Fatal error - ".$e->getMessage();
        }

    }

    public function edit($id){
        $user = User::findOrFail($id);
        return view($this->path.'.edit', compact('user'));
    }

    public function update(Request $request, $id){

        $user = User::findOrFail($id);
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('users.index');
    }
}
