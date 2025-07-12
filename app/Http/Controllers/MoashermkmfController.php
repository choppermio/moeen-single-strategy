<?php

namespace App\Http\Controllers;

use App\Models\Moashermkmf;
use App\Models\Mubadara;
use Illuminate\Http\Request;

class MoashermkmfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('/moashermkmf/index', [
            'moashermkmfs' => Moashermkmf::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
        return View('/moashermkmf/create',[
            'mubadaras' => Mubadara::all(),
            

            


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
        $moashermkmf = Moashermkmf::create([
            'name' => $request->input('name'),
            'percentage' => 0,
            'parent_id' => $request->input('mubadara'),
            'type' => $request->input('type'),
        ]);
        return redirect()->back()->with('success', 'تم إضافة الهدف بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Moashermkmf  $moashermkmf
     * @return \Illuminate\Http\Response
     */
    public function show(Moashermkmf $moashermkmf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Moashermkmf  $moashermkmf
     * @return \Illuminate\Http\Response
     */
   // Edit method
public function edit($id)
{
    $moashermkmf = MoasherMkmf::findOrFail($id);
    $mubadaras = Mubadara::all(); // Assuming you have a Mubadara model for the initiatives
    return view('moashermkmf.edit', compact('moashermkmf', 'mubadaras'));
}

// Update method
public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        // 'mubadara' => 'required|exists:mubadaras,id',
        'type' => 'required|in:mk,mf',
    ]);

    $moashermkmf = MoasherMkmf::findOrFail($id);
    $moashermkmf->update([
        'name' => $validatedData['name'],
        // 'parent_id' => $validatedData['mubadara'], // Assuming 'mubadara_id' is the foreign key column
        'type' => $validatedData['type'],
    ]);

    return redirect()->route('moashermkmf.index')->with('success', 'Updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Moashermkmf  $moashermkmf
     * @return \Illuminate\Http\Response
     */
    public function destroy(Moashermkmf $moashermkmf)
    {
        //
    }
}
