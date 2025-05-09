<?php

namespace App\Http\Controllers;

use App\Models\TaskModel;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function getAll()
    {
        $task = TaskModel::all();
        if ($task) {
            return $task;
        } else {
            return response()->json(['message' => 'No hay tareas.']);
        }
    }

    public function getWithFilters(Request $request){
        $query = TaskModel::query();

        if($request->has('status'))  $query->where('status', $request->input('status'));
        if($request->has('priority'))  $query->where('priority', $request->input('priority'));
        if($request->has('due_date'))  $query->where('due_date', $request->input('due_date'));
        if($request->has('project_id'))  $query->where('project_id', $request->input('project_id'));

        $task = $query->get();

        if ($task->isEmpty()){
            return response()->json(['message' => 'No se encontraron tareas con dichos filtros.']);
        } else {
            return $task;
        }

    }

    public function getById($id)
    {
        $task = TaskModel::find($id);
        if ($task) {
            return $task;
        } else {
            return response()->json(['message' => 'Tarea no encontrada']);
        }
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'project_id'=> 'required|exists:project,id',
            'title'  => 'required|string|min:3|max:100',
            'description'  => 'sometimes|string|',
            'status' => 'required|string|in:pending,in_progress,done',
            'priority' => 'required|string|in:low,medium,high', 
            'due_date' => 'required|date'
        ]);

        if ($validated) {
            return TaskModel::create($validated);
        } else {
            return response()->json(['message' => 'Tarea no creada.']);
        }
    }

    public function update(Request $request, $id){
        $item = TaskModel::find($id);

        if (!$item) return response()->json(['message' => 'Tarea no existe.']);

        $validated = $request->validate([
            'project_id'=> 'required|exists:project,id',
            'title'  => 'required|string|min:3|max:100',
            'description'  => 'sometimes|string|',
            'status' => 'required|string|in:pending,in_progress,done',
            'priority' => 'required|string|in:low,medium,high', 
            'due_date' => 'required|date'
        ]);

        if ($validated) {
            return $item->update($validated);
        } else {
            return response()->json(['message' => 'Tarea no actualizadA.']);
        }
    }

    public function delete($id){

        $item = TaskModel::find($id);

        if (!$item) return response()->json(['message' => 'Tarea no existe.']);

        if ($item->delete()) {
            return response()->json(['message' => 'Tarea eliminada correctamente.']);
        } else {
            return response()->json(['message' => 'Tara no eliminada.']);
        }
    }
}
