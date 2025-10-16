<?php

namespace App\Http\Controllers;

use App\Models\User;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use App\Models\Hadafstrategy;
use App\Models\EmployeePosition;
use App\Models\EmployeePositionRelation;
use Illuminate\Support\Facades\DB;

class HadafstrategyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if (in_array(current_user_position()->id, explode(',', env('STRATEGY_CONTROL_ID'))) || in_array(current_user_position()->id, explode(',', env('ADMIN_ID')))){
            $allhadafstrategy = Hadafstrategy::all();
        }elseif(current_user_position()->id==14 || current_user_position()->id==15){
            $employee_position_relations = EmployeePositionRelation::where('child_id', current_user_position()->id)->first()->parent_id;
            $allhadafstrategy = Hadafstrategy::where('user_id',$employee_position_relations)->get();
        }else{
            $allhadafstrategy = Hadafstrategy::where('user_id',current_user_position()->id)->get();
        }
       return View('/hadafstrategy/index', [
            'hadafstrategies' => $allhadafstrategy
        ]);
    }
    
    public function removeTaskMoasher(Request $request){
        
        // dd( $request->moashermkmf_id . ' - afa-'.$request->task_id);
        DB::table('moashermkmf_task')
    ->where('moashermkmf_id', $request->moashermkmf_id)
    ->where('task_id',$request->task_id)
    ->delete();
    return true;
    }
    public function todesign()
    {
        //
       return View('/hadafstrategy/todesign', [
            'hadafstrategies' => Hadafstrategy::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $users = User::all();
        $employee_positions  = EmployeePosition::with('user')->get();
        
        return View('/hadafstrategy/create', [
            'hadafstrategy' => Hadafstrategy::all(),
            'employee_positions' => $employee_positions,
            // 'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input('user_id'));
        $name= $request->input('name');
        $hadafstrategy = new Hadafstrategy();
        $hadafstrategy->name = $name;
        $hadafstrategy->percentage = 0;
        $hadafstrategy->user_id = $request->input('user_id');
        $hadafstrategy->save();
        calculatePercentages();

        return redirect('/newstrategy?id='.$hadafstrategy->id)->with('success', 'تم إضافة الهدف بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hadafstrategy  $hadafstrategy
     * @return \Illuminate\Http\Response
     */
    public function show(Hadafstrategy $hadafstrategy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hadafstrategy  $hadafstrategy
     * @return \Illuminate\Http\Response
     */
    public function edit(Hadafstrategy $hadafstrategy)
    {
        // dd($hadafstrategy);
        $hadafstrategy = HadafStrategy::findOrFail($hadafstrategy->id); // Assuming you have a model named HadafStrategy
    $employee_positions = EmployeePosition::all(); // Or however you fetch these

    return view('hadafstrategy.edit', compact('hadafstrategy', 'employee_positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hadafstrategy  $hadafstrategy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hadafstrategy $hadafstrategy)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Example validation rules
            'user_id' => 'required  ', // Ensure the user_id exists in the users table
        ]);
    
        // Find the model instance
        $hadafstrategy = HadafStrategy::findOrFail($hadafstrategy->id);
    
        // Update the model with the validated data
        $hadafstrategy->update($validatedData);
    
        // Redirect back or to another page with a success message
        return redirect()->route('hadafstrategies.index')->with('success', 'هدف استراتيجي تم تحديثه بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hadafstrategy  $hadafstrategy
     * @return \Illuminate\Http\Response
     */
   public function destroy(Hadafstrategy $hadafstrategy)
{
    // Delete the Hadafstrategy model instance
    $hadafstrategy->delete();

    // Redirect the user back to a previous page or to a specific route,
    // often with a success message.
    return redirect()->back()->with('success', 'Hadafstrategy deleted successfully.');
}

}
