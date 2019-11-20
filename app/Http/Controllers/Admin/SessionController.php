<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Session;

class SessionController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sessions = Session::where('user_id', '<>', null)->orderBy('last_activity', 'desc')->paginate();

        return view('admin.session.index', ['sessions' => $sessions]);
    }

    /**
     * @param Session $session
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Session $session)
    {
        $session->delete();

        return redirect()->route('admin.session.index');
    }
}
