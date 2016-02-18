<?php namespace App\Http\Controllers;

//use App\Partner;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller {

    protected $partner;

//    public function __construct(Partner $partner)
//    {
//        $this->partner = $partner;
//    }

    public function index()
    {
//        $date = $this->partner->partners();
//        dd($date);
        return view('partners.list');//->withPartners($date);
    }

    /**
     * @param $id
     * @return mixed
     */
//    public function show($id)
//    {
//        $date = Project::find($id);
//        return view('project.info')->withPartner($date);
//    }
}