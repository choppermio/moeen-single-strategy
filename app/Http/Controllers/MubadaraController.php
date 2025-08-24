<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mubadara;
use Illuminate\Http\Request;

use App\Models\Hadafstrategy;
use App\Models\EmployeePosition;
use App\Models\Moasheradastrategy;
use Illuminate\Support\Facades\Log;

class MubadaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('/mubadara/index', [
            'mubadaras' => Mubadara::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee_positions  = EmployeePosition::with('user')->get();
        
        return View('/mubadara/create',[
            'moasheradastrategies' => Moasheradastrategy::where('parent_id', (int)$_GET['hadafstrategy'])->get(),
            // 'users' => User::all(),
            'employee_positions' => $employee_positions,
            


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
        //dd($request->input('hadafstrategy')[0]);
        $hadafstrategy = Moasheradastrategy::where('id', $request->input('hadafstrategy')[0])->first()->parent_id;
        // dd($hadafstrategy);
       // dd($hadafstrategy);
    //    dd($request->input('hadafstrategy'));

// dd($request->all());
    $validatedData = $request->validate([
        'general_desc' => 'required|string',
        'date_from' => 'required',
        'date_to' => 'required',
        'estimate_cost' => 'required|numeric|min:0',
        'dangers' => 'required|string',
    ]);

  if ($errors = $request->session()->get('errors')) {
        dd($errors); // This will dump the error object (or any error messages) to the screen
    }
    
        try {
    $mubadara = new Mubadara();
    $mubadara->name = $request->input('name');
    $mubadara->percentage = 0;
    $mubadara->user_id = $request->input('user_id');
    $mubadara->parent_id = 0;
    $mubadara->hadafstrategy_id = $hadafstrategy;
    $mubadara->general_desc = $validatedData['general_desc'];
    $mubadara->date_from = $validatedData['date_from'];
    $mubadara->date_to = $validatedData['date_to'];
    $mubadara->estimate_cost = $validatedData['estimate_cost'];
    $mubadara->dangers = $validatedData['dangers'];
    
    if ($mubadara->save()) {
        // return response()->json(['message' => 'Record successfully inserted']);
    } else {
        dd('Failed to insert record');
    }
} catch (\Exception $e) {
    // Catch the exception and display the exact error message
    dd('Error: ' . $e->getMessage());
}
        //get last inserted id
        $mubadara_id = $mubadara->id;
        //insert into pivot table
        foreach($request->input('hadafstrategy') as $moasherstrategy)
        {
            $mubadara->moasheradastrategies()->attach($moasherstrategy);
        }

        calculatePercentages();

        return redirect('/mubadara');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mubadara  $mubadara
     * @return \Illuminate\Http\Response
     */
    public function show(Mubadara $mubadara)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mubadara  $mubadara
     * @return \Illuminate\Http\Response
     */
    public function edit(Mubadara $mubadara)
    {
       
    //    dd('a');
        $mubadara = Mubadara::where('id', $mubadara->id)->first();
        return View('/mubadara/edit',[
            'mubadara' => $mubadara,
            // 'moasheradastrategies' => Moasheradastrategy::where('parent_id', (int)$_GET['hadafstrategy'])->get(),
            'users' => EmployeePosition::all(),
            


        ]);
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mubadara  $mubadara
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mubadara $mubadara)
    {
        
        $validatedData = $request->validate([
            'general_desc' => 'required|string|max:255',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'estimate_cost' => 'required|numeric|min:0',
            'dangers' => 'required|string',
        ]);
    
// Assuming $id contains the ID of the Mubadara you want to update
$mubadara = Mubadara::find($mubadara->id);

// Check if the model was found
if ($mubadara) {
    $mubadara->name = $request->input('name');
    // Assuming the percentage should not be updated or should retain its current value
    // $mubadara->percentage = 0; // Uncomment if you need to reset the percentage
    $mubadara->user_id = $request->input('user_id');
    // Assuming parent_id should not be updated or should retain its current value
    // $mubadara->parent_id = 0; // Uncomment if you need to reset the parent_id
    // $mubadara->hadafstrategy_id = $hadafstrategy;
    $mubadara->general_desc = $validatedData['general_desc'];
    $mubadara->date_from = $validatedData['date_from'];
    $mubadara->date_to = $validatedData['date_to'];
    $mubadara->estimate_cost = $validatedData['estimate_cost'];
    $mubadara->dangers = $validatedData['dangers'];

    $mubadara->save();
} else {
    // Handle the case where Mubadara is not found
    // e.g., return an error response or throw an exception
}

return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mubadara  $mubadara
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mubadara $mubadara)
{
    // Attempt to delete the Mubadara instance
    try {
        $mubadara->delete();

        // Redirect with success message
        return redirect()->route('mubadaras.index')->with('success', 'Mubadara deleted successfully.');
    } catch (\Exception $e) {
        // Handle the error, for example, log it and redirect back with an error message
        Log::error('Error deleting Mubadara: ' . $e->getMessage());
        
        // Redirect back or to a specific route with an error message
        return back()->with('error', 'Error deleting Mubadara.');
    }
}

}
