<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'q' => 'min:2',
        ]);

        $members = User::where('lastname', 'LIKE', '%'.$request->q.'%')
            ->orwhere('firstname', 'LIKE', '%'.$request->q.'%')
            ->paginate();
        // dd($members);
        if ($validator->fails()) {
            return view('search')
                ->withErrors($validator);
        }

        return view('admin.user.index', ['users' => $members]);
    }
}
