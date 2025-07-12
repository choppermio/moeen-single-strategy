<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeePositionRelation;

class EmployeePositionRelationController extends Controller
{
    //

    public function destroy($id)
{
    // Let's pretend you're actually passing the correct ID
    $item = EmployeePositionRelation::find($id);

    // Checking if the item even exists, or are we chasing ghosts?
    if (!$item) {
        return response()->json(['message' => 'Item not found'], 404);
    }

    // Poof! It's gone. Hopefully it was the right one
    $item->delete();

    // Letting you know it's done, because feedback is important
    return response()->json(['message' => 'Item deleted successfully']);
}

}
