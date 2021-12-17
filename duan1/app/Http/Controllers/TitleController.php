<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Title;
use App\Funtap;

class TitleController extends Controller
{
    public function index()
    {
        $list_title = Title::where('titles.deleted_at', null)->join('funtaps', 'titles.id_funtap', '=', 'funtaps.id')->select('titles.title', 'titles.url', 'titles.id_dad', 'titles.id', 'funtaps.title_element')->get();
        $list_Funtap = Funtap::where('deleted_at', null)->get();
        return view('backend.Title.title', ['list_title' => $list_title, 'list_Funtap' => $list_Funtap]);
    }
    public function postTitle(Request $request)
    {
        $output = '';
        if ($request->ajax()) {
            $funtap = new Title();
            $funtap->title = $request->title;
            $funtap->url = $request->url;
            $funtap->id_funtap = $request->id_funtap;
            if ($request->id_dad == Null) {
                $funtap->id_dad = 0;
            } else {
                $funtap->id_dad = $request->id_dad;
            }
            $funtap->save();
            $list_title = Title::where('titles.deleted_at', null)->join('funtaps', 'titles.id_funtap', '=', 'funtaps.id')->select('titles.title', 'titles.url', 'titles.id_dad', 'titles.id', 'funtaps.title_element')->get();
            if ($list_title) {
                foreach ($list_title as $value) {
                    $output = '
                <tr>
                <td class="text-center">' . $value->id . '</td>
                <td class="text-center">' . $value->title . '</td>
                <td class="text-center">' . $value->title_element . '</td>
                <td class="text-center">' . $value->id_dad . '</td>
                <td class="text-center">' . Str::limit($value->token, 30) . '</td>
                <td class="text-center">
                    <a onclick="event.preventDefault();editTitle(' . $value->id . ')"class="btn btn-primary btn-sm m-r-xs"><i class="fa fa-pencil"></i> Sửa</a>
                    <a onclick="event.preventDefault();deleteTitle(' . $value->id . ')" class="btn btn-danger btn-sm"><i class="fa fa-times "></i> Xóa</a>
                </td>
            </tr>
              ';
                }
            }
            return Response($output);
        }
    }
    public function geteditTitle($id)
    {
        $list_title = Title::where('titles.deleted_at', null)->find($id);
        return response()->json([
            'list_title'  => $list_title,
        ], 200);
    }
    public function posteditTitle(Request $request, $id)
    {

        if ($request->ajax()) {
            $funtap = Title::find($id);
            $funtap->title = $request->title;
            $funtap->url = $request->url;
            $funtap->id_funtap = $request->id_funtap;
            if ($request->id_dad == Null) {
                $funtap->id_dad = 0;
            } else {
                $funtap->id_dad = $request->id_dad;
            }
            $funtap->save();
            $list_title = Title::where('titles.deleted_at', null)->where('titles.id', $id)->join('funtaps', 'titles.id_funtap', '=', 'funtaps.id')->select('titles.title', 'titles.url', 'titles.id_dad', 'titles.id', 'funtaps.title_element')->get();
            if ($list_title) {
                foreach ($list_title as $value) {
                    $output = '
                <tr>
                <td class="text-center">' . $value->id . '</td>
                <td class="text-center">' . $value->title . '</td>
                <td class="text-center">' . $value->title_element . '</td>
                <td class="text-center">' . $value->id_dad . '</td>
                <td class="text-center">' . Str::limit($value->token, 30) . '</td>
                <td class="text-center">
                    <a onclick="event.preventDefault();editTitle(' . $value->id . ')"class="btn btn-primary btn-sm m-r-xs"><i class="fa fa-pencil"></i> Sửa</a>
                    <a onclick="event.preventDefault();deleteTitle(' . $value->id . ')" class="btn btn-danger btn-sm"><i class="fa fa-times "></i> Xóa</a>
                </td>
            </tr>
              ';
                }
            }
            return Response($output);
        }
    }
    public function deleteTitle(Request $request, $id)
    {
        if ($request->ajax()) {
            $delete = Title::find($id);
            if ($delete) {
                $delete->delete();
            }
            return response(['code' => 200]);
        }
    }
}
