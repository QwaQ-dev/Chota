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
        // Метод для отображения формы создания нового склада, если это необходимо.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Валидация данных
        $data = $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|numeric',
            'delivery' => 'required|date',
        ]);

        // Создание новой записи в базе данных
        Warehouse::create($data);

        // Перенаправление пользователя после успешного сохранения
        return redirect()->route('warehouse.index')->with('status', 'Запись успешно добавлена!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        // Метод для отображения конкретной записи, если это необходимо.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        // Метод для отображения формы редактирования конкретной записи
        return view('warehouse.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        // Валидация данных
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'delivery' => 'required|date',
            // Добавьте другие правила валидации по мере необходимости
        ]);

        // Обновление данных
        $warehouse->update($data);

        // Перенаправление пользователя после успешного обновления
        return redirect()->route('warehouse')->with('status', 'Данные обновлены успешно!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        // Метод для удаления записи, если это необходимо.
    }
}
