<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Response;
use App\Models\Todo;
use Illuminate\Support\Facades\Validator;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::get();
        return Response::json($todos,200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
          'title' => 'required',
          'description' => 'required',
          'is_done'=>'required|numeric|boolean'
        ]);

        if ($validator->fails()){
          return Response::json(['response'=>$validator->messages(), 'success'=>false],400);
        }

        $todo = new Todo();
        $todo->title = $request->input('title');
        $todo->description = $request->input('description');
        $todo->is_done = $request->input('is_done');
        $todo->save();
        return Response::json($todo,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::find($id);
        if (empty($todo))
        {
          return Response::json(['response'=>'Todo with id='.$id.' does not exist' ],404);
        }
        return Response::json($todo,200);
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
      $validator = Validator::make($request->all(),[
        'title' => 'required',
        'description' => 'required',
        'is_done'=>'required|numeric|boolean'
      ]);

      if ($validator->fails()){
        return Response::json(['response'=>$validator->messages(), 'success'=>false],400);
      }

      $todo = Todo::find($id);
      if (empty($todo))
      {
        return Response::json(['response'=>'Todo with id='.$id.' does not exist' ],404);
      }
      $todo->title = $request->input('title');
      $todo->description = $request->input('description');
      $todo->is_done = $request->input('is_done');
      $todo->save();
      return Response::json($todo,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        if (empty($todo))
        {
          return Response::json(['response'=>'Todo with id='.$id.' does not exist' ],404);
        }
        $todo->delete();
        return Response::json(['response'=>'Todo deleted','success'=>true],200);
    }
}
