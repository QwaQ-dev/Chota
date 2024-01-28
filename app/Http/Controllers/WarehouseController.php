<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->user()->isWorker() || request()->user()->isAdmin()) {
            $warehouses = Warehouse::all();
            return view('warehouse.index', compact('warehouses'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Method to display the form for creating a new warehouse, if necessary.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation of data
        $data = $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|numeric',
            'delivery' => 'required|date',
        ]);

        // Create a new record in the database
        Warehouse::create($data);

        // Redirect the user after successful saving
        return redirect()->route('warehouse')->with('status', 'Record added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        // Method to display a specific record if necessary.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return view('warehouse.updatex', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation of data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'delivery' => 'required|date',
            // Add other validation rules as needed
        ]);

        // Update data
        Warehouse::findOrFail($id)->update($data);

        // Redirect the user after successful update
        return redirect()->route('warehouse')->with('status', 'Data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        // Method to delete a record if necessary.
    }
}
