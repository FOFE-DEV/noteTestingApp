<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class NoteApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $notes=Note::all();
        return response()->json(data: $notes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
       $validator=Validator::make($request->all(),[
           'name'=>'required',
           'tel'=>'required',
           'email'=>'required',
           'content'=>'required|min:1',
        ]);
        if ($validator->fails()){
            return response()->json(data: ['errors'=>$validator->errors()], status: 422);
        }
        Note::create($request->all());
        return  response()->json(["message"=>"Note Saved"],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $note=Note::find($id);
        //dd($id,$note);
        return response()->json(data: $note, status: 200);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'tel'=>'required',
            'email'=>'required',
            'content'=>'required|min:1',
        ]);
        if ($validator->fails()){
            return response()->json(data: ['errors'=>$validator->errors()], status: 422);
        }
        $note=$request->all();
        $oldNote=Note::find($id);
        $oldNote->name=$request->name;
        $oldNote->save();
        return response()->json(["message"=>"updated ok"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
