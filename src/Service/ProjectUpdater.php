<?php 

namespace App\Service; 

use App\Entity\Project; 

class ProjectUpdater
{
    public function addAmount(Project $project, float $amount): void
    {
        $project->setCurrentAmount($project->getCurrentAmount() + $amount); 
    }
}