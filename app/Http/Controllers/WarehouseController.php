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
            return view("warehouse.index", compact('warehouses'));
        } else {
            return abort(404);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|numeric',
            'delivery' => 'required|date'
        ]);

        Warehouse::create($data);
        return redirect()->route('warehouse');

    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Валидация данных, если необходимо
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'delivery' => 'required|date',
            // Добавьте другие правила валидации по мере необходимости
        ]);

        // Найдем запись в базе данных
        $warehouse = Warehouse::findOrFail($id);

        // Обновим данные
        $warehouse->update([
            'name' => $request->input('name'),
            'quantity' => $request->input('quantity'),
            'delivery' => $request->input('delivery'),
            // Обновите с другими полями по мере необходимости
        ]);

        // Вернем пользователя назад или куда-то еще
        return redirect()->route('warehouse.update')->with('status', 'Данные обновлены успешно!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        //
    }


}
