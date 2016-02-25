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
        $data = $this->project->projects();
        return view('projects.list')->withProjects($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $data = Project::find($id);
        return view('projects.info')->withProject($data);
    }
}