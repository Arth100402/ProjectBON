<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TimelineController extends Controller
{
    public function index()
    {
        return view('timeline.index');
    }
    public function loadTimeline()
    {
        $user = Auth::user();
        return response()->json(["timeline" => ($user->departement_id == 1 || $user->departement_id == 2) ? Project::all() : DB::table('projects')
            ->join("projectactivitydetail AS pad", "pad.projects_id", "projects.id")
            ->join('projectassign', 'projectassign.projectactivitydetail_id', '=', 'pad.id')
            ->where('projectassign.users_id', '=', $user->id)
            ->whereNull("projects.deleted_at")
            ->get(['projects.id', 'projects.namaOpti', 'projects.tglRealisasi', 'projects.deadline', 'projects.status'])]);
    }
}
