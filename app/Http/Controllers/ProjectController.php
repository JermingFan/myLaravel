<?php namespace App\Http\Controllers;

use App\Project;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller {

    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function index()
    {
        $date = $this->project->projects();
//        $nav = 'project';
//        dd($date);
        return view('projects.list')->withProjects($date);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $date = Project::find($id);
        return view('projects.info')->withProject($date);
    }
}