<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Access_token;
use App\Funtap;

class FuntapController extends Controller
{
    public function index()
    {
        $list = Funtap::where('funtaps.deleted_at', null)->join('access_tokens', 'funtaps.id_token', '=', 'access_tokens.id')->select('funtaps.title_element', 'funtaps.image_url', 'funtaps.subtitle', 'funtaps.id', 'funtaps.content', 'access_tokens.name')->get();
        $access_token = Access_token::where('access_tokens.deleted_at', null)->get();
        return view('backend.Funtap.funtap', ['list' => $list, 'access_token' => $access_token]);
    }
    public function postFuntap(Request $request)
    {
        $output = '';
        if ($request->ajax()) {
            $funtap = new Funtap();
            $funtap->title_element = $request->title_element;
            $funtap->id_token = $request->id_token;
            $funtap->subtitle = $request->subtitle;
            $funtap->content = $request->content;
            $funtap->image_url = $request->image_url;
            $funtap->save();
            $list = Funtap::where('funtaps.deleted_at', null)->join('access_tokens', 'funtaps.id_token', '=', 'access_tokens.id')->select('funtaps.title_element', 'funtaps.image_url', 'funtaps.content', 'funtaps.subtitle', 'funtaps.id', 'access_tokens.name')->get();
            if ($list) {
                foreach ($list as $value) {
                    $output = '
                <tr>
                <td class="text-center">' . $value->id . '</td>
                <td class="text-center">' . $value->title_element . '</td>
                <td class="text-center">' . Str::limit($value->image_url, 30) . '</td>
                <td class="text-center">' . $value->name . '</td>
                <td class="text-center">' . Str::limit($value->content, 30) . '</td>
                <td class="text-center">' . $value->subtitle . '</td>
                <td class="text-center">
                    <a onclick="event.preventDefault();editFuntap(' . $value->id . ')" class="btn btn-primary btn-sm m-r-xs"><i class="fa fa-pencil"></i> Sửa</a>
                    <a onclick="event.preventDefault();deleteFuntap(' . $value->id . ')" class="btn btn-danger btn-sm"><i class="fa fa-times "></i> Xóa</a>
                </td>
            </tr>
              ';
                }
            }
            return Response($output);
        }
    }
    public function geteditFuntap($id)
    {
        $list_funtap = Funtap::find($id);
        return response()->json([
            'list_funtap'  => $list_funtap,
        ], 200);
    }
    public function posteditFuntap(Request $request, $id)
    {

        if ($request->ajax()) {
            $funtap = Funtap::find($id);
            $funtap->title_element = $request->title_element;
            $funtap->subtitle = $request->subtitle;
            $funtap->content = $request->content;
            $funtap->image_url = $request->image_url;
            $funtap->save();
            $list = Funtap::where('funtaps.deleted_at', null)->where('funtaps.id', $id)->join('access_tokens', 'funtaps.id_token', '=', 'access_tokens.id')->select('funtaps.title_element', 'funtaps.image_url', 'funtaps.content', 'funtaps.subtitle', 'funtaps.id', 'access_tokens.name')->get();
            if ($list) {
                foreach ($list as $value) {
                    $output = '
                <tr>
                <td class="text-center">' . $value->id . '</td>
                <td class="text-center">' . $value->title_element . '</td>
                <td class="text-center">' . Str::limit($value->image_url, 30) . '</td>
                <td class="text-center">' . $value->name . '</td>
                <td class="text-center">' . Str::limit($value->content, 30) . '</td>
                <td class="text-center">' . $value->subtitle . '</td>
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
    public function deleteFuntap(Request $request, $id)
    {
        if ($request->ajax()) {
            $delete = Funtap::find($id);
            if ($delete) {
                $delete->delete();
            }
            return response(['code' => 200]);
        }
    }
}
