<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{

    public function index(){
        //all todos from database
        //display them in the todos.index
        $todos = Todo::all();

        return view('todos.index')->with('todos',$todos);

    }
    public function show($todoId){
        $todo = Todo::find($todoId);
        return view('todos.show')->with('todo',$todo);




    }
    public function create(){
        return view('todos.create');
    }
    public function store(Request $request){
        $this->validate(request(),[
            'name' => 'required|min:6|max:12',
            'description' => 'required'

        ]);


        $todo = new Todo();
        $todo->name= $request->name;
        $todo->description = $request->description;
        $todo->completed=false;
        $todo->save();
      /*  $data = request()->all();

        $todo = new Todo();
        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $todo->completed = false;

        $todo->save();
        */
        session()->flash('status','Todo Created Successfully.');

        return redirect('/todos');




    }
    public function edit($todoId){
        $todo =Todo::find($todoId);

           return view('todos.edit')->with('todo',$todo);
    }
    public function update($todoId){
        $this->validate(request(),[
            'name' => 'required|min:6|max:12',
            'description' => 'required'

        ]);
         $data = request()->all();
         $todo = Todo::find($todoId);
        $todo->name = $data['name'];
        $todo->description = $data['description'];

        $todo->save();
        session()->flash('status','Todo Updated Successfully.');


        return redirect('/todos');

    }
    public function destroy($todoId){

        $todo=Todo::find($todoId);
        $todo->delete();
        session()->flash('status','Todo Deleted Successfully.');
        return redirect('/todos');

    }
    public function complete($todoId){

        $todo=Todo::find($todoId);
        $todo->completed=true;
        $todo->save();
        session()->flash('status','Todo Completed Successfully.');
        return redirect('/todos');

    }
}
