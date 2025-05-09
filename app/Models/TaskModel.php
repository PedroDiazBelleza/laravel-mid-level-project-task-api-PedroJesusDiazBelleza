<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *      schema="Tasks",
 *      type="object",
 *      title="Tasks",
 *      required={"id", "project_id", "title", "description", "status", "priority", "due_date"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="project_id",
 *          example=1
 *      ),
 *       @OA\Property(
 *          property="title",
 *          type="string",
 *          example="Nombre de la tarea"
 *      ),
 *       @OA\Property(
 *          property="description",
 *          type="string",
 *          example="Descripcion de la tarea"
 *      ),
 *        @OA\Property(
 *          property="status",
 *          type="string",
 *          example="active"
 *      ),
 *        @OA\Property(
 *          property="priority",
 *          type="string",
 *          example="high"
 *      ),
 *        @OA\Property(
 *          property="due_date",
 *          type="string",
 *          format="date",
 *          example="09/05/20205"
 *      ),
 * )
 */


class TaskModel extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date'
    ];

    public function task(): BelongsTo{
        return $this->belongsTo(TaskModel::class);
    }
}
