<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Throwable;

class UserController extends Controller
{
    public function index(){
        return view('admin.index');
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
        $totalRecords = User::select('count(*) as allcount')->count();
        $whrArrAjax = [
            ['email', 'like', '%' .$searchValue . '%'],
        ];
        $totalRecordswithFilter = User::select('count(*) as allcount')->where($whrArrAjax)->count();

        $records = User::orderBy($columnName,$columnSortOrder)
                    ->where($whrArrAjax)
                    ->select('id', 'name', 'email', 'phone', 'gender', 'dob', 'role', 'department', 'subordinate_to', 'hire_date', 'avatar', 'status')
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
                "email" => $record->email,
                "phone" => $record->phone,
                "gender" => Str::ucfirst($record->gender),
                "dob" => Carbon::createFromFormat('Y-m-d', $record->dob)->format('d-m-Y'),
                "role" => $record->role,
                "department" => $record->department,
                "subordinate_to" => $record->subordinate_to,
                "hire_date" => Carbon::createFromFormat('Y-m-d', $record->hire_date)->format('d-m-Y'),
                "avatar" => $record->avatar == '' ? asset('assets/img/user.jpg') : asset($record->avatar),
                "status" => '<div class="dropdown action-label user-status">
                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-dot-circle-o text-'.$class.'"></i>'.$status
                                .'</a>
                                <div class="dropdown-menu dropdown-menu-right">'
                                    .'<button class="dropdown-item" data-url="'.route('user.update.status', ['id' => Crypt::encryptString($record->id)]).'" data-value="'.$value.'">
                                        <i class="fa fa-dot-circle-o text-'.$class2.'"></i> '.$status1
                                    .'</button>
                                </div>
                            </div>',
                "action" => '<a class="btn btn-outline-info btn-sm" href="'.route('user.view.edit', ['id' => Crypt::encryptString($record->id)]).'" title="View & Edit">
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
            $user_id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return redirect()->route('user.list')->with('error', 'Invalid User ID!');
        }

        $data['user_id'] = $id;
        $data['user'] = User::select('name', 'email', 'phone', 'gender', 'dob', 'role', 'level', 'isAdmin', 'department', 'subordinate_to', 'hire_date', 'avatar', 'status')->where('id', $user_id)->first();
        $data['roles'] = User::select('role')->groupBy('role')->get();
        $data['departments'] = User::select('department')->groupBy('department')->get();
        $data['subordinates'] = User::select('subordinate_to')->groupBy('subordinate_to')->get();

        return view('admin.viewEditUser', $data);
    }

    public function changeStatus(Request $request, $id) {
        try {
            $user_id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return redirect()->route('user.list')->with('error', 'Invalid User ID!');
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
                User::where('id', $user_id)->update(['status' => $status]);
                
                return [
                    'success' => true,
                    'message' => 'User status updated Successfully!',
                    'status' => 200
                ];
            } catch (Throwable $th) {
                return [
                    'errors' => true,
                    'message' => 'Failed to update the user status, please try again.',
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
            $user_id = Crypt::decryptString($id);
            $userData = User::select('email', 'phone', 'avatar')->where('id', $user_id)->first();
        } catch (DecryptException $e) {
            return redirect()->route('user.list')->with('error', 'Invalid User ID!');
        }

        $message = [];
        $attribute = [
            'phone' => 'contact number',
            'dob' => 'date of birth',
        ];
        $validator = $request->validate([
            'image' => 'sometimes|required|mimes:webp,jpg,jpeg,bmp,png|max:2048',
            'name' => 'required|string|min:3|max:250',
            'phone' => $request->input('phone') == $userData->phone ? 'required|numeric|digits_between:1,10' : 'required|numeric|unique:users|digits_between:1,10',
            'email' => $request->input('email') == $userData->email ? 'required|email:rfc,dns' : 'required|email:rfc,dns|unique:users',
            'dob' => 'required',
            'gender' => 'required|string|min:4',
            'hire_date' => 'required',
            'role' => 'required|string|min:3',
            'department' => 'required|string',
            'subordinate' => 'required|string|min:3',
        ], $message, $attribute);

        
        if($validator) {

            if(!empty($request->file('image'))) {
                try {
                    /**
                     * Image upload
                     */
                    $image = $request->file('image');
                    $fileName = date("YmdHis").Str::random(20).'.'.$image->getClientOriginalExtension();
                    $relImgPath = 'assets/img/user/'.date('Y').'/'.date('m');
                
                    $imgExt = $image->getClientOriginalExtension();
                    $imgMime = $image->getClientMimeType();
                    
                    //move original file to folder
                    $image->move(public_path($relImgPath), $fileName);
                } catch (Throwable $th) {
                    return back()->withInput($request->all())->with('error', 'Failed to fetch the image you have provided, please try again!');
                }
            }

            try {
                User::where('id', $user_id)->update([
                    'avatar' => isset($fileName) ? $relImgPath.'/'.$fileName : $userData->avatar,
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'email' => $request->input('email'),
                    'dob' => Carbon::createFromFormat('d/m/Y', $request->input('dob'))->format('Y-m-d'),
                    'gender' => $request->input('gender'),
                    'hire_date' => Carbon::createFromFormat('d/m/Y', $request->input('hire_date'))->format('Y-m-d'),
                    'role' => $request->input('role'),
                    'department' => $request->input('department'),
                    'subordinate_to' => $request->input('subordinate'),
                ]);
                return back()->withoutCookie('pro_edit_'.$id)->with('success', 'User details has been updated Successfully.');
            } catch (Throwable $th) {
                return back()->with('error', 'Failed to update the user details, please try again.');
            }
        }
    }
}
