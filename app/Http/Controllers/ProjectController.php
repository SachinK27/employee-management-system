<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Throwable;

class ProjectController extends Controller
{
    public function index(){
        return view('admin.project');
    }

    public function getData(Request $request) {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Project::select('count(*) as allcount')->count();
        $whrArrAjax = [
            ['name', 'like', '%' .$searchValue . '%'],
        ];
        $totalRecordswithFilter = Project::select('count(*) as allcount')->where($whrArrAjax)->count();

        $records = Project::orderBy($columnName,$columnSortOrder)
                    ->where($whrArrAjax)
                    ->select('id', 'name', 'status')
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();

        $data_arr = array();
        foreach($records as $record){
            if($record->status == 'active') {
                $status = "Active";
                $status1 = "Inactive";
                $class = 'success';
                $class2 = 'danger';
                $value = 0;
            } else {
                $status = "Inactive";
                $status1 = "Active";
                $class = 'danger';
                $class2 = 'success';
                $value = 1;
            }
            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "status" => '<div class="dropdown action-label project-status">
                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-dot-circle-o text-'.$class.'"></i>'.$status
                                .'</a>
                                <div class="dropdown-menu dropdown-menu-right">'
                                    .'<button class="dropdown-item" data-url="'.route('project.update.status', ['id' => Crypt::encryptString($record->id)]).'" data-value="'.$value.'">
                                        <i class="fa fa-dot-circle-o text-'.$class2.'"></i> '.$status1
                                    .'</button>
                                </div>
                            </div>',
                "action" => '<a class="btn btn-outline-info btn-sm" href="'.route('project.view.edit', ['id' => Crypt::encryptString($record->id)]).'" title="View & Edit">
                                <i class="fa fa-eye"></i> & <i class="fa fa-pencil"></i>
                            </a>',
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return json_encode($response);
    }

    public function viewEdit($id){
        try {
            $p_id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return redirect()->route('project.list')->with('error', 'Invalid Project ID!');
        }

        $data['p_id'] = $id;
        $data['project'] = Project::select('name', 'status')->where('id', $p_id)->first();
        
        return view('admin.viewEditProject', $data);
    }

    public function changeStatus(Request $request, $id) {
        try {
            $p_id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return redirect()->route('project.list')->with('error', 'Invalid Project ID!');
        }

        $validator = $request->validate([
            'status' => 'required|digits_between:0,1',
        ]);

        
        if($validator) {
            try {
                if($request->input('status')) {
                    $status = 'active';
                } else {
                    $status = 'deactive';
                }
                Project::where('id', $p_id)->update(['status' => $status]);
                
                return [
                    'success' => true,
                    'message' => 'Project status updated Successfully!',
                    'status' => 200
                ];
            } catch (Throwable $th) {
                return [
                    'errors' => true,
                    'message' => 'Failed to update the project status, please try again.',
                    'status' => 400
                ];
            }
        } else {
            return [
                'errors' => true,
                'message' => 'Invalid request!',
                'status' => 400
            ];
        }
    }
    
    public function update(Request $request, $id) {
        try {
            $p_id = Crypt::decryptString($id);
            $projData = Project::select('name')->where('id', $p_id)->first();
        } catch (DecryptException $e) {
            return redirect()->route('project.list')->with('error', 'Invalid Project ID!');
        }

        $validator = $request->validate([
            'name' => $request->input('name') == $projData->name ? 'required|string|min:3|max:255' : 'required|string|unique:company|min:3|max:255',
        ]);

        
        if($validator) {
            try {
                Project::where('id', $p_id)->update(['name' => $request->input('name')]);
                return back()->withoutCookie('pro_edit_'.$id)->with('success', 'Project details has been updated Successfully.');
            } catch (Throwable $th) {
                return back()->with('error', 'Failed to update the project details, please try again.');
            }
        }
    }
    
    public function add(Request $request) {
        $validator = $request->validate([
            'name' => 'required|string|unique:company|min:3|max:255',
        ]);

        if($validator) {
            $crtPro = Project::create([
                'name' => $request->input('name'),
                'status' => ($request->input('status') == 'on' ? 'active' : 'deactive'),
            ]);

            if($crtPro) {
                return back()->withoutCookie('add_pro')->with('success', 'New Project has been created Successfully.');
            } else {
                return back()->withInput($request->all())->with('error', 'Failed to create the project, please try again!');
            }
        }
    }
}
