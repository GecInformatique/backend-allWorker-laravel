<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CandidatesHasCompetence
 * 
 * @property int $candidates_id
 * @property int $competences_id
 * 
 * @property Candidate $candidate
 * @property Competence $competence
 *
 * @package App\Models
 */
class CandidatesHasCompetence extends Model
{
	protected $table = 'candidates_has_competences';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'candidates_id' => 'int',
		'competences_id' => 'int'
	];

	  // Ajoutez cette ligne pour permettre l'assignation en masse
	  protected $fillable = [
        'candidates_id', 
        'competences_id'
    ];

	public function candidate()
	{
		return $this->belongsTo(Candidate::class, 'candidates_id');
	}

	public function competence()
	{
		return $this->belongsTo(Competence::class, 'competences_id');
	}
}
