<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


    /*
    Proyectos (/api/projects)
        ● GET /projects → listado con filtros (status, name, date range)
        ● POST /projects → crear proyecto
        ● GET /projects/{id} → detalle
        ● PUT /projects/{id} → actualizar
        ● DELETE /projects/{id} → eliminar (soft delete opcional)
    */

    

Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'getWithFilters']);
    Route::post('/', [ProjectController::class, 'create']);
    Route::get('/{id}', [ProjectController::class, 'getById']);
    Route::put('{id}', [ProjectController::class, 'update']);
    Route::delete('{id}', [ProjectController::class, 'delete']);
});


   /*
    Tareas (/api/tasks)
        ● GET /tasks → listado con filtros (status, priority, due_date,
        project_id)
        ● POST /tasks → crear tarea
        ● GET /tasks/{id} → detalle
        ● PUT /tasks/{id} → actualizar
        ● DELETE /tasks/{id} → eliminar 
     */

Route::prefix('tasks')->group(function () {
    Route::get('/', [ProjectController::class, 'getWithFilters']);
    Route::post('/', [ProjectController::class, 'create']);
    Route::get('/{id}', [ProjectController::class, 'getById']);
    Route::put('{id}', [ProjectController::class, 'update']);
    Route::delete('{id}', [ProjectController::class, 'delete']);
});
