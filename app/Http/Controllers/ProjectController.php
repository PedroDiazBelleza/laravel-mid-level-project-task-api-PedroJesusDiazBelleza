<?php

namespace App\Http\Controllers;

use App\Models\ProjectModel;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Todo APi", version="1.0.0")
 * @OA\PathItem(path="/projects")  
 */

class ProjectController extends Controller
{


    /**
     * @OA\Get(
     *  path="api/projects/",
     *  tags = {"Projects"},
     *  summary="Obtener todo los projectos",
     *  @OA\Response(
     *      response=200,
     *      description="Proyectos:",
     *      @OA\JsonContent(ref="#/components/schemas/Projects")
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="No hay proyectos."
     *  )
     * )
     */
    public function getAll()
    {
        $project = ProjectModel::all();
        if ($project) {
            return $project;
        } else {
            return response()->json(['message' => 'No hay proyectos.']);
        }
    }


    public function getWithFilters(Request $request){
        $query = ProjectModel::query();

        if($request->has('status'))  $query->where('status', $request->input('status'));
        if($request->has('name'))  $query->where('name', $request->input('name'));

        $project = $query->get();

        if ($project->isEmpty()){
            return response()->json(['message' => 'No se encontraron proyectos con dichos filtros.']);
        } else {
            return $project;
        }

    }


    /**
     * @OA\Get(
     *  path="api/projects/{id}",
     *  tags = {"Projects"},
     *  summary="Obtener un proyecto por medio de un id",
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del proyecto",
     *      required=true,
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Proyecto eliminado correctamente.",
     *      @OA\JsonContent(ref="#/components/schemas/Projects")
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="Proyecto no encontrado."
     *  )
     * )
     */

    public function getById($id)
    {
        $project = ProjectModel::find($id);
        if ($project) {
            return $project;
        } else {
            return response()->json(['message' => 'Proyectos no encontrado']);
        }
    }


    /**
     * @OA\Post(
     *  path="api/projects/",
     *  tags = {"Projects"},
     *  summary="Agregra un nuevo proyecto",
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del nuevo proyecto",
     *      @OA\JsonContent(ref="#/components/schemas/Projects")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Proyecto creado correctamente.",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="Proyecto no creado.",
     *  )
     * )
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'description' => 'sometimes|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        if ($validated) {
            return ProjectModel::create($validated);
        } else {
            return response()->json(['message' => 'Proyecto no creado.']);
        }
    }

    /**
     * @OA\Put(
     *  path="api/projects/{id}",
     *  tags = {"Projects"},
     *  summary="Actualizar un proyecto",
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del proyecto",
     *      required=true,
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Proyecto actualizado correctamente.",
     *      @OA\JsonContent(ref="#/components/schemas/Projects")
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="Proyecto no actualizado.",
     *  )
     * )
     */
    public function update(Request $request, $id){
        $item = ProjectModel::find($id);

        if (!$item) return response()->json(['message' => 'Proyecto no existe.']);

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'description' => 'sometimes|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        if ($validated) {
            return $item->update($validated);
        } else {
            return response()->json(['message' => 'Proyecto no actualizado.']);
        }
    }

    /**
     * @OA\Delete(
     *  path="api/projects/{id}",
     *  tags = {"Projects"},
     *  summary="Eliminar un proyecto",
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Id del proyecto",
     *      required=true,
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Proyecto eliminado correctamente."
     *  )
     * )
     */
    public function delete($id){

        $item = ProjectModel::find($id);

        if (!$item) return response()->json(['message' => 'Proyecto no existe.']);

        if ($item->delete()) {
            return response()->json(['message' => 'Proyecto eliminado correctamente.']);
        } else {
            return response()->json(['message' => 'Proyecto no eliminado.']);
        }
    }
}
