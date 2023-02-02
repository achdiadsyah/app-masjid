<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Models\AppSetting;
use App\Models\RunningText;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function showAppSettingPage(Request $request)
    {
        $data = [
            'result'    => AppSetting::where('id', '1')->first()
        ];
        return view('setting.app', $data);
    }

    public function updateAppSetting(Request $request)
    {
        AppSetting::find($request->id)->update($request->all());
        AppSetting::where('id', '1')->update(['revision_id' => uniqid()]);
        return redirect()->back()->with([
            'msg'   => 'Success Update Data',
        ]);
    }

    public function getRevision(Request $request)
    {
        if($request->ajax()){
            $data = [
                'date_active'   => date('Y-m-d'),
                'revision_id'   => AppSetting::where('id', '1')->first()->revision_id,
            ];
            return response()->json($data, 200);
        }
        abort(403, 'Unauthorized action.');
    }

    public function showUserSettingPage(Request $request)
    {
        if($request->ajax()){
            $query = User::orderBy('id', 'desc')->get();
            return Datatables::of($query)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);   
        }
        return view('setting.user');
    }

    public function addUserSettingPage(Request $request)
    {
        if($request->ajax()){
            $query = User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'user_level'    => $request->user_level,
            ]);
            return response()->json([
                'success' => 'Record added successfully!'
            ]);
        }
    }

    public function deleteUserSettingPage(Request $request)
    {
        if($request->ajax()){
            User::find($request->id)->delete($request->id);
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
    }
    
    public function showRunningTextPage(Request $request)
    {
        if($request->ajax()){
            $query = RunningText::orderBy('id', 'desc')->get();
            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('created_by', function($query) {
                    return $query->user ? $query->user->name : 'NULL';
                })
                ->rawColumns(['action'])
                ->make(true);   
        }
        return view('setting.ticker');
    }

    public function addRunningText(Request $request)
    {
        if($request->ajax()){
            $query = RunningText::create([
                'text'                  => $request->text,
                'created_by'            => auth()->user()->id,
            ]);
            AppSetting::where('id', '1')->update(['revision_id' => uniqid()]);
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
    }

    public function deleteRunningText(Request $request)
    {
        if($request->ajax()){
            RunningText::find($request->id)->delete($request->id);
            AppSetting::where('id', '1')->update(['revision_id' => uniqid()]);
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
    }

    public function showWallpaperGalleryPage(Request $request)
    {
        
    }

    public function addWallpaperGalleryPage(Request $request)
    {
        
    }

    public function deleteWallpaperGalleryPage(Request $request)
    {
        
    }
}
