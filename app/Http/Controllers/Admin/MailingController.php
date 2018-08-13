<?php

namespace App\Http\Controllers\Admin;

use App\Mailing;
use App\TemplateMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MailingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mailings = TemplateMail::latest()->paginate();

        return view('admin.mailing.index', ['mailings' => $mailings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mailing $mailing
     * @return void
     */
    public function show(Mailing $mailing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mailing = TemplateMail::findOrFail($id);

        return view('admin.mailing.edit', ['mailing' => $mailing]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mailing = TemplateMail::findOrFail($id);

        $validator = $request->validate([
            'title' => 'required',
            'text_content' => 'required',
        ]);

        $mailing->update($validator);

        return redirect()->route('admin.mailing.index')->with('message', 'Modification confirmée');
    }
}
