<?php

namespace Database\Seeders;

use App\Models\PermissionsHasRole;
use Database\Factories\UsersFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Advertisement ::factory(10)->create();
        \App\Models\Candidate ::factory(10)->create();
       // \App\Models\CandidatesHasCompetence ::factory(10)->create();
        \App\Models\Competence ::factory(10)->create();
        \App\Models\Condition ::factory(10)->create();
        \App\Models\Document ::factory(10)->create();
        \App\Models\DomainActivity ::factory(10)->create();
        \App\Models\Education ::factory(10)->create();
        \App\Models\Favorite ::factory(10)->create();
        \App\Models\Formation ::factory(10)->create();
        \App\Models\Groupe ::factory(10)->create();
        \App\Models\Invoice ::factory(10)->create();
        \App\Models\Log ::factory(10)->create();
        \App\Models\Message ::factory(10)->create();
        \App\Models\Newsletter ::factory(10)->create();
        \App\Models\OauthProvider ::factory(10)->create();
        \App\Models\Package ::factory(10)->create();
        \App\Models\Payment ::factory(10)->create();
        \App\Models\Permission ::factory(10)->create();
       // \App\Models\PermissionsHasRole ::factory(10)->create();
        \App\Models\Profession ::factory(10)->create();
        \App\Models\Project ::factory(10)->create();
        \App\Models\Question ::factory(10)->create();
        \App\Models\Review ::factory(10)->create();
        \App\Models\Role ::factory(10)->create();
        \App\Models\Specialism ::factory(10)->create();
        \App\Models\Status ::factory(10)->create();
        \App\Models\Subscription ::factory(10)->create();
        \App\Models\Task ::factory(10)->create();
        \App\Models\Testimonial ::factory(10)->create();
        \App\Models\TypeDocument ::factory(10)->create();
    }
}
