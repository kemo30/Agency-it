<?php

namespace App\Http\Controllers\api\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\task;

class taskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tsaks =task::where('employee_id', '=',Auth::user()->id)->where('status','0')->paginate();
        return $tsaks;
    }

   

   
    public function show(task $task)
    {
        if($task->employee_id == Auth::user()->id){
        return $task;
    }else{
        return response()->json([
            'message' => 'error'
          ],404);
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,task $task)
    {
        if($task->status == 0){
            $request->validate([
                'submit_details' => 'required',
            ]);
            
            $task->update([
                'status' => 1,
                'submit_details' => $request->submit_details
            ]);
           
            return $task;
        
        
            }else{
                return response()->json([
                    'message' => 'this task already submited'
                  ],400);
            } 
    }

   
}
