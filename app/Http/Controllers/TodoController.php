<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Moasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    private function tothetop($level){
        $all  = Todo::where('level',$level)->get();
        //$parent_id = $all[0]->collection_id;
        // if($parent_id !=0){
        foreach($all as $item){
            $sumofpercentage = 0;
            $this_parent_id = $item->id;
            $all_with_collection  = Todo::where('collection_id',$this_parent_id)->get();
            $count_with_collection = $all_with_collection->count();
            //dd($count_with_collection);
            foreach($all_with_collection as $item_with_collection){
                $sumofpercentage+=$item_with_collection->done_percentage;
            }
            if($sumofpercentage == 0){$d = 0;}else{
            $d = $sumofpercentage/$count_with_collection ;
        }
            $item->done_percentage = $d;
            $item->save();


            $all  = Todo::where('level',$level)->get();

// dd($item->done);
            if($item->done == 1){
                //dd($item);
                $item->done_percentage = 100;
                $item->save();
            }
            // }elseif($item->done == 0){
            //     //dd($item);
            //     $item->done_percentage = 0;
            //     $item->save();
            // }elseif($item->done == 2){
            //     //dd($item);
            //     $item->done_percentage = 50;
            //     $item->save();
            // }
        }
    }




    public function calculate_moasher_percentage(){
        $distinctKafaaIds = Moasher::distinct()->pluck('moasher_kafaa_id');
        


        foreach($distinctKafaaIds as $distinctKafaaId){
            //count all moashers with this moasher_kafaa_id
            $count = Moasher::where('moasher_kafaa_id',$distinctKafaaId)->count();


            //get all moashers with this moasher_kafaa_id
            $all = Moasher::where('moasher_kafaa_id',$distinctKafaaId)->get();
            //loop through all moashers with this moasher_kafaa_id
            $sum = 0;
            //empty array
            $uniquetask_id = [];
            foreach($all as $item){
                //get sum of done_percentage from todos model where id = task_id
                $todo = Todo::where('id',$item->task_id)->first();
                $sum += $todo->done_percentage;
                //append to $uniquetask_id the done_percentage
                $uniquetask_id[] = $todo->id;

                $uniquetask_id[] = $todo->done_percentage;

                //dd($sum);
                //get average of done_percentage
                //$average = $sum/$count;
                //dd($average);
                //update todos model with this average
                //$todo = Todo::find($item->task_id);
                //$todo->done_percentage = $average;
                //$todo->save();
            }
            //$uniquetask_id[] = $sum;
            // dd($uniquetask_id);
            $average = $sum/$count;
            $todo = Todo::find($distinctKafaaId);
                $todo->done_percentage = $average;
                $todo->save();
            
        }





        $distinctfa3liaIds = Moasher::distinct()->pluck('moasher_fa3lia_id');

        foreach($distinctfa3liaIds as $distinctfa3liaId){
            //count all moashers with this moasher_kafaa_id
            $count = Moasher::where('moasher_fa3lia_id',$distinctfa3liaId)->count();


            //get all moashers with this moasher_kafaa_id
            $all = Moasher::where('moasher_fa3lia_id',$distinctfa3liaId)->get();
            //loop through all moashers with this moasher_kafaa_id
            $sum = 0;
            //empty array
            $uniquetask_id = [];
            foreach($all as $item){
                //get sum of done_percentage from todos model where id = task_id
                $todo = Todo::where('id',$item->task_id)->first();
                $sum += $todo->done_percentage;
                //append to $uniquetask_id the done_percentage
                $uniquetask_id[] = $todo->id;

                $uniquetask_id[] = $todo->done_percentage;

                //dd($sum);
                //get average of done_percentage
                //$average = $sum/$count;
                //dd($average);
                //update todos model with this average
                //$todo = Todo::find($item->task_id);
                //$todo->done_percentage = $average;
                //$todo->save();
            }
            //$uniquetask_id[] = $sum;
            // dd($uniquetask_id);
            $average = $sum/$count;
            $todo = Todo::find($distinctfa3liaId);
                $todo->done_percentage = $average;
                $todo->save();
            
        }

    }






    public function calculate_percentage(){

        //create empty array
        // $uniquetask_id = [];

        // $moashers = Moasher::all();

        // dd($moashers);


        //get distenct moasher_kafaa_id from moashers model
       






        $all  = Todo::where('level',6)->get();
        $i = 0;

        $parent_id = $all[0]->collection_id;
        
        foreach($all as $item){
       
            if($item->done == 1){
                //dd($item);
                $item->done_percentage = 100;
                $item->save();
            }
        }
        
        //dd($parent_id);
        //dd($all);
        
        $this->tothetop(5);
        
        
        $this->tothetop(4);
        
        //get unique moasher_kafaa_id from moashers model

       $this->calculate_moasher_percentage();

        
        $this->tothetop(3);
        $this->tothetop(2);
        $this->tothetop(1);
        
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        //
    }





    public function add_todo(Request $request, Todo $todo)
    {
      
        
        $todo = new Todo();
        $todo->task = $request->task;
        $todo->collection_id = $request->taskid;
        $todo->level = 6;
        $todo->user_id = Auth::user()->id;

        $todo->done = 0;
        $todo->done_percentage = 0;
        $todo->save();

        //calculate percentage
        $this->calculate_percentage();
        //return back
        return back();

        
    }


    public function update_todo(Request $request, Todo $todo)
    {
      
        $ddone_percetage = 0;
        if($request->task_status == 0){
            $ddone_percetage = 0;
        }elseif($request->task_status == 1){
            $ddone_percetage = 100;
        }elseif($request->task_status == 2){
            $ddone_percetage = 50;
        }

        $todo = Todo::find($request->taskid);
        $todo->done = $request->task_status;
        $todo->done_percentage = $ddone_percetage;
        $todo->save();

        //calculate percentage
        $this->calculate_percentage();
        //return back
        return back();

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
