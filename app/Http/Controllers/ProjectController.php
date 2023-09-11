<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\HistoryProjectReport;
use App\Models\Project;
use App\Models\ProjectActivityDetail;
use App\Models\ProjectAssign;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use function Ramsey\Uuid\v1;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Project::join('customers', 'Projects.customers_id', '=', 'customers.id')
            ->get([
                'Projects.*', 'customers.id as cid', 'customers.nama as cnama', 'customers.alamat as calamat', 'customers.instansi as cinstansi', 'customers.notelp as cnotelp', 'customers.email as cemail'
            ]);
        return view('project.index', compact('data'));
    }
    public function trashIndex()
    {

        $data = Project::withTrashed()
            ->leftjoin('customers', 'Projects.customers_id', '=', 'customers.id')
            ->get([
                'Projects.*', 'customers.id as cid', 'customers.nama as cnama', 'customers.alamat as calamat', 'customers.instansi as cinstansi', 'customers.notelp as cnotelp', 'customers.email as cemail'
            ]);
        return response()->json(["data" => $data]);
    }
    public function backToIndex()
    {
        $data = Project::join('customers', 'Projects.customers_id', '=', 'customers.id')
            ->get([
                'Projects.*', 'customers.id as cid', 'customers.nama as cnama', 'customers.alamat as calamat', 'customers.instansi as cinstansi', 'customers.notelp as cnotelp', 'customers.email as cemail'
            ]);
        return response()->json(["data" => $data]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datac = Customer::all();
        return view('project.formcreate', compact('datac'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namaoptipro' => ['required', "regex:/^(?!.*\s{2})^(?=.*\S)[\S]*$/"],
            'customerid' => 'required',
            'lokasipro' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+]*$/"],
            'tglmulaipro' => 'required',
            'deadlinePro' => 'required',
            'statuspro' => 'required',
        ], [
            'namaoptipro.required' => 'Nama Opti belum terisi.',
            'namaoptipro.regex' => "Pastikan format pengisian nama opti benar.",
            'customerid.required' => 'Pelanggan belum terisi.',
            'lokasipro.required' => 'Lokasi Project belum terisi.',
            'lokasipro.regex' => "Pastikan format pengisian lokasi project benar.",
            'tglmulaipro.required' => 'Tanggal mulai belum terisi.',
            'deadlinePro.required' => 'Tenggat waktu belum terisi.',
            'statuspro.required' => 'Status belum terisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $username = Auth::user()->username;
        $tahunSaatIni = Carbon::now()->format('Y');
        $latestRecord = Project::latest()->first();
        $latestId = $latestRecord->id;
        $data = new Project();
        $data->idOpti = "OPT" . $username . $tahunSaatIni . (intval($latestId) + 1);
        $data->namaOpti = $request->get('namaoptipro');
        $data->customers_id = $request->get('customerid');
        $data->posisi = $request->get('lokasipro');
        $data->tglRealisasi = $this->convertDTPtoDatabaseDT($request->get('tglmulaipro'));
        $data->deadline = $this->convertDTPtoDatabaseDT($request->get('deadlinePro'));
        $data->status = $request->get('statuspro');
        $data->save();

        $tglReal = Carbon::createFromFormat('Y-m-d', $data->tglRealisasi);
        $tglDead = Carbon::createFromFormat('Y-m-d', $data->deadline);
        $diffday = $tglDead->diffInDays($tglReal);

        $startDate = $tglReal;
        for ($i = 0; $i <= $diffday; $i++) {
            if ($startDate->isWeekday()) {
                $actDet = new ProjectActivityDetail();
                $actDet->projects_id = $data->id;
                $actDet->tglAktifitas = $startDate;
                $actDet->save();
                $startDate->addDay();
            } else {
                $startDate->addDay();
            }
        }
        return redirect()->route('project.index')->with('status', 'Project berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Project::find($id);
        return view("project.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $history = new HistoryProjectReport();
        $data1 = Project::find($id);
        $perubahan = "";
        $deadline =  $this->convertDTPtoDatabaseDT($request->get('deadline'));

        $validator = Validator::make($request->all(), [
            'namaoptipro' => ['required', "regex:/^(?!.*\s{2})^(?=.*\S)[\S]*$/"],
            'customerid' => 'required',
            'lokasipro' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+]*$/"],
            'tglmulaipro' => 'required',
            'deadlinePro' => 'required',
            'statuspro' => 'required',
        ], [
            'namaoptipro.required' => 'Nama Opti belum terisi.',
            'namaoptipro.regex' => "Pastikan format pengisian nama opti benar.",
            'customerid.required' => 'Pelanggan belum terisi.',
            'lokasipro.required' => 'Lokasi Project belum terisi.',
            'lokasipro.regex' => "Pastikan format pengisian lokasi project benar.",
            'tglmulaipro.required' => 'Tanggal mulai belum terisi.',
            'deadlinePro.required' => 'Tenggat waktu belum terisi.',
            'statuspro.required' => 'Status belum terisi.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($data1->namaOpti != $request->get('namaOpti')) {
            $dataold = $data1->namaOpti;
            $data1->namaOpti = $request->get('namaOpti');
            $perubahan .= ("t-Project; " . $dataold . "=>" . $request->get('namaOpti') . ", ");
        }

        if ($data1->posisi != $request->get('posisi')) {
            $dataold = $data1->posisi;
            $data1->posisi = $request->get('posisi');
            $perubahan .= ("t-Project; " . $dataold . "=>" . $request->get('posisi') . ", ");
        }

        if ($data1->status != $request->get('status')) {
            $dataold = $data1->status;
            $data1->status = $request->get('status');
            $perubahan .= ("t-Project; " . $dataold . "=>" . $request->get('status') . ", ");
        }

        if ($data1->deadline != $deadline) {
            $dataold = $data1->deadline;
            $data1->deadline = $deadline;
            $perubahan .= ("t-Project; " . $dataold . "=>" . $deadline . ", ");
        }

        $data1->save();

        $history->projects_id = $id;
        $history->users_id = $user_id;
        $history->keteranganPerubahan = $perubahan;
        $history->save();

        return redirect()->route("project.index")->with("status", "Pengubahan Berhasil");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $objProject = Project::find($id);
            $objProject->delete();

            return redirect()->route('project.index')->with('status', 'Project has been deleted');
        } catch (\PDOException $ex) {
            $msg = "Data Gagal dihapus. Pastikan kembali tidak ada data yang berelasi sebelum dihapus";
            return redirect()->route('project.index')->with('status', $msg);
        }
    }
    public function getDetail(Request $request)
    {
        $id = $request->get('id');
        $data = Project::leftjoin('projectactivitydetail', 'Projects.id', '=', 'projectactivitydetail.projects_id')
            ->join('customers', 'Projects.customers_id', '=', 'customers.id')
            ->where('Projects.id', '=', $id)
            ->get([
                'Projects.*', 'customers.nama as cnama',
                'customers.instansi as cinstansi', 'customers.notelp as cnotelp',
                'customers.email as cemail', 'customers.alamat as calamat'
            ])
            ->groupBy('Projects.id')[""][0];
        $anggota = DB::table('projectactivitydetail')
            ->join('projectassign', 'projectassign.projectactivitydetail_id', '=', 'projectactivitydetail.id')
            ->join('users', 'projectassign.users_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'projectassign.roles_id')
            ->where('projectactivitydetail.projects_id', '=', $id)
            ->orderBy('users.name')
            ->get(['projectassign.*', 'projectactivitydetail.tglAktifitas as tglAktifitas', 'projectactivitydetail.namaAktifitas as namaAktifitas', 'users.name as uname', 'roles.name as rname']);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('project.detail', compact('data', 'anggota'))->render()
        ));
    }

    public function getCust(Request $request)
    {
        $id = $request->get('id');
        $data = Customer::find($id);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('project.cust', compact('data'))->render()
        ));
    }
    public function hapusKaryawan(Request $request, $idProject, $idUser)
    {
        if ($request->get("idUser") != null && $request->get("idProject") != null) {
            $result = DB::table('projectassign')->where("users_id", $request->get("idUser"))->where("projects_id", $request->get("idProject"))->delete();
            $anggota = DB::table('projectassign')
                ->join('users', 'projectassign.users_id', '=', 'users.id')
                ->where('projectassign.projects_id', '=', $request->get("idProject"))
                ->where('projectassign.users_id', "=", $request->get("idUser"))
                ->orderBy('users.name')
                ->get(['projectassign.users_id', 'users.name as uname', 'projectassign.statusKaryawan', 'projectassign.projects_id']);
            return redirect()->route('project.edit', $request->get("idProject"))->with("status", "Delete Success");
        }
        $result = DB::table('projectassign')->where("users_id", $idUser)->where("projects_id", $idProject)->delete();
        $anggota = DB::table('projectassign')
            ->join('users', 'projectassign.users_id', '=', 'users.id')
            ->where('projectassign.projects_id', '=', $idProject)
            ->where('projectassign.users_id', "=", $idUser)
            ->orderBy('users.name')
            ->get(['projectassign.users_id', 'users.name as uname', 'projectassign.statusKaryawan', 'projectassign.projects_id']);
        return redirect()->route('project.edit', $idProject)->with("status", "Delete Success");
    }
    public function selectSearch(Request $request)
    {
        $karyawan = [];
        $search = $request->q;
        $idProj = $request->idProject;
        $karyawan = DB::table("users")
            ->where("users.name", "LIKE", "%$search%")
            ->whereNotIn("id", function (Builder $query) use ($idProj) {
                $query->select("users_id")->from("projectassign")->where("projectassign.projects_id", "=", $idProj);
            })->get(["id", "name"]);
        return response()->json(["data" => $karyawan, "request" => $request]);
    }
    public function selectSearchCustomer(Request $request)
    {
        $search = $request->q;
        $customers = Customer::where("nama", "LIKE", "%$search%")->get();
        return response()->json($customers);
    }

    public function tambahKaryawan(Request $request)
    {
        $query = DB::table('projectassign')->insert(
            ['users_id' => $request->input('users_id'), 'projects_id' => $request->input('projects_id'), 'statusKaryawan' => 'Member']
        );
        $anggota = DB::table('projectassign')
            ->join('users', 'projectassign.users_id', '=', 'users.id')
            ->where('projectassign.projects_id', '=', $request->input('projects_id'))
            ->where('projectassign.users_id', "=", $request->input('users_id'))
            ->orderBy('users.name')
            ->get(['projectassign.users_id', 'users.name as uname', 'projectassign.statusKaryawan', 'projectassign.projects_id']);
        return response()->json(["data" => $anggota]);
    }
    public function restoreProject(Request $request)
    {
        $id = $request->get('id');
        $project = Project::where("id", $id)->withTrashed();
        $project->restore();
        return response()->json(["status" => "success", "data" => $project->get()]);
    }
    private function convertDTPtoDatabaseDT($date)
    {
        return date("Y-m-d", strtotime(str_replace(" ", "", explode(",", $date)[1])));
    }

    public function assignPage()
    {
        return view('project.assign');
    }
    public function loadProjectAssign(Request $request)
    {
        $karyawan = User::where("jabatan_id", 1)->get();
        $data = Project::join("projectactivitydetail AS pad", "pad.projects_id", "projects.id")
            ->where("projects.status", "Menunggu")
            ->orWhere("projects.status", "Proses")
            ->orderBy("pad.tglAktifitas", "ASC")
            ->get(["tglAktifitas", "namaOpti", "posisi", "projects.status", "pad.id AS padId"]);
        $roles = DB::table("projects")->join("projectactivitydetail AS pad", "pad.projects_id", "=", "projects.id")
            ->leftJoin("projectassign AS pa", "pad.id", "=", "pa.projectactivitydetail_id")
            ->leftJoin("users AS u", "pa.users_id", "u.id")
            ->where("u.jabatan_id", 1)
            ->whereNull("pa.deleted_at")
            ->orderBy("pad.tglAktifitas")
            ->get(["projects.namaOpti", "pad.tglAktifitas", "pa.users_id", "pa.roles_id", "pad.id AS padId"])
            ->groupBy(["namaOpti", "tglAktifitas"]);
        return response()->json(["karyawan" => $karyawan, "data" => $data, "roles" => $roles]);
    }
    public function changeRole(Request $request)
    {
        $roleId = $request->get("roleId");
        $padId = $request->get("padId");
        $userId = $request->get("userId");
        if ($roleId > 0) {
            $response = ProjectAssign::upsert(["users_id" => $userId, "projectactivitydetail_id" => $padId, "roles_id" => $roleId], ["users_id", "projectactivitydetail_id"]);
            $pad = ProjectAssign::where("users_id", $userId)->where("projectactivitydetail_id", $padId)->withTrashed()->get()[0];
            if ($pad["deleted_at"] != null) {
                ProjectAssign::where("users_id", $userId)->where("projectactivitydetail_id", $padId)->withTrashed()->update(["deleted_at" => null]);
            }
        } else {
            $response = ProjectAssign::where("projectactivitydetail_id", $padId)
                ->where("users_id", $userId)
                ->delete();
        }
        return response()->json(["status" => "OK", "result" => $response, "test" => $roleId]);
    }
    public function showWaktuHover(Request $request)
    {
        $ids = $request->all();
        $data = ProjectAssign::where("users_id", $ids["userId"])
            ->where("projectactivitydetail_id", $ids["padId"])
            ->where("roles_id", $ids["roleId"])
            ->get();
        if (count($data) == 1) {
            return response()->json(["status" => "OK", "data" => $data[0], "ids" => $ids]);
        }
        return response()->json(["status" => "HM", "data" => $data, "ids" => $ids]);
    }
    public function showPhoto(Request $request)
    {
        $padId = $request->get("padId");
        $data = ProjectAssign::join("users AS u", "u.id", "projectassign.users_id")
            ->where("projectassign.projectactivitydetail_id", $padId)
            ->orderBy("projectassign.projectactivitydetail_id")
            ->get(["projectassign.users_id", "u.name", "projectassign.image", "projectassign.latitude", "projectassign.longitude"]);
        return response()->json(["status" => "OK", "content" => view('project.formShowPhoto', compact("data"))->render(), "data" => $data]);
    }
    public function test()
    {
        return view('test');
    }
}
