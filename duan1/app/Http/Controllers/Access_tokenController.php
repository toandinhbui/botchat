<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Title;
use App\Access_token;
use App\Funtap;

class Access_tokenController extends Controller
{
    public function index()
    {
        $list = Access_token::where('deleted_at', null)->get();
        return view('backend.Access_token.access_token', ['list' => $list]);
    }
    public function postAccess_token(Request $request)
    {
        $output = '';
        if ($request->ajax()) {
            $access_token = new Access_token();
            $access_token->name = $request->name;
            $access_token->id_page = $request->id_page;
            $access_token->token = $request->token;
            $access_token->save();
            $list = Access_token::where('deleted_at', null)->get();
            if ($list) {
                foreach ($list as $value) {
                    $output = '
                <tr>
                <td class="text-center">' . $value->id . '</td>
                <td class="text-center">' . $value->name . '</td>
                <td class="text-center">' . $value->id_page . '</td>
                <td class="text-center">' . Str::limit($value->token, 30) . '</td>
                <td class="text-center">
                    <a onclick="event.preventDefault();editAccess_token(' . $value->id . ')" class="btn btn-primary btn-sm m-r-xs"><i class="fa fa-pencil"></i> Sửa</a>
                    <a onclick="event.preventDefault();deleteAccess_token(' . $value->id . ')" class="btn btn-danger btn-sm"><i class="fa fa-times "></i> Xóa</a>
                </td>
            </tr>
              ';
                }
            }
            return Response($output);
        }
    }
    public function geteditAccess_token($id)
    {
        $list_access_token = Access_token::find($id);
        return response()->json([
            'list_access_token'  => $list_access_token,
        ], 200);
    }
    public function posteditAccess_token(Request $request, $id)
    {

        if ($request->ajax()) {
            $access_token = Access_token::find($id);
            $access_token->id_page = $request->id_page;
            $access_token->token = $request->token;
            $access_token->save();
            $list = Access_token::where('deleted_at', null)->where('id', $id)->get();
            if ($list) {
                foreach ($list as $value) {
                    $output = '
                <tr>
                <td class="text-center">' . $value->id . '</td>
                <td class="text-center">' . $value->name . '</td>
                <td class="text-center">' . $value->id_page . '</td>
                <td class="text-center">' . Str::limit($value->token, 30) . '</td>
                <td class="text-center">
                    <a onclick="event.preventDefault();editFuntap(' . $value->id . ')"class="btn btn-primary btn-sm m-r-xs"><i class="fa fa-pencil"></i> Sửa</a>
                    <a onclick="event.preventDefault();deleteFuntap(' . $value->id . ')" class="btn btn-danger btn-sm"><i class="fa fa-times "></i> Xóa</a>
                </td>
            </tr>
              ';
                }
            }
            return Response($output);
        }
    }
    public function deleteAccess_token(Request $request, $id)
    {

        if ($request->ajax()) {
            $delete = Access_token::find($id);
            if ($delete) {
                $delete->delete();
            }
            return response(['code' => 200]);
        }
    }
}
