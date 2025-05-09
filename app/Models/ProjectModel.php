<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *      schema="Projects",
 *      type="object",
 *      title="Projects",
 *      required={"name", "status"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1
 *      ),
 *       @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Nombre del proyecto"
 *      ),
 *       @OA\Property(
 *          property="description",
 *          type="string",
 *          example="Descripcion del proyecto"
 *      ),
 * )
 */


class ProjectModel extends Model
{

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function task(): HasMany
    {
        return $this->hasMany(TaskModel::class);
    }
}
