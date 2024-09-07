<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PermissionsHasRole
 * 
 * @property int $permissions_id
 * @property int $roles_id
 * 
 * @property Permission $permission
 * @property Role $role
 *
 * @package App\Models
 */
class PermissionsHasRole extends Model
{
	protected $table = 'permissions_has_roles';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'permissions_id' => 'int',
		'roles_id' => 'int'
	];

	public function permission()
	{
		return $this->belongsTo(Permission::class, 'permissions_id');
	}

	public function role()
	{
		return $this->belongsTo(Role::class, 'roles_id');
	}
}
