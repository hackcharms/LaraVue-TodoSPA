<?php

namespace App\Http\Controllers\api\todo;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Todo;
use Illuminate\Http\Request;
use Laravel\Passport\HasApiTokens;

class TodoController extends Controller
{
    use HasApiTokens;

    public function __construct()
    {
        // $this->middleware(['auth:api']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Todo::oldest()->get();
        if(!empty($data))
            return Helper::ApiResponse(200,'data collection',$data,);
        else
            return Helper::ApiResponse(200,"No data Has been Addeed yet");

    }
    /**
     *Return array of Completed Todos
     *
     */
    public function completedTodo()
    {
        $data=Todo::where('completed',true)->oldest()->get();
        if(!empty($data))
            return Helper::ApiResponse(200,'Completed Todo data collection',$data,);
        else
            return Helper::ApiResponse(200,"No data Has been Addeed yet");

    }
    /**
     *Return array of Completed Todos
     *
     */
    public function incompletedTodo()
    {
        $data=Todo::where('completed',false)->oldest()->get();
        if(!empty($data))
            return Helper::ApiResponse(200,'Incompleted Todo data collection',$data,);
        else
            return Helper::ApiResponse(200,"No data Has been Addeed yet");

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'task'=>'required|string|max:50',
            'completed'=>'required|boolean'
        ]);
        $todo= new Todo;
        $todo->task=$request->task;
        $todo->completed=$request->completed;
        $todo->save();
        return Helper::ApiResponse(200,"Task Added Successfully",$todo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo=Todo::find($id);
        if(!empty($todo))
        return Helper::ApiResponse(200,'success',$todo);
        else
            return Helper::ApiResponse();

            // return response("Todo Task Not Found",404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $todo=Todo::find($id);
        if(!empty($todo)){
        $todo->task=$request->task;
        $todo->completed=$request->completed;
        $todo->save();
        return Helper::ApiResponse(200,"Successfully Data Updated",$todo);
        }
        else{
            return Helper::ApiResponse();
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
        $todo=Todo::find($id);
        if(!empty($todo)){
            $todo->delete();
            return Helper::ApiResponse(200,"Successfully Data Deleted");
            }
        else{
            return Helper::ApiResponse();
        }
    }
}
