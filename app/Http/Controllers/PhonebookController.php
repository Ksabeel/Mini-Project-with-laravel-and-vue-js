<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Phonebook;

class PhonebookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($term = null)
    {
        if ($term != null) {
            $phonebook = Phonebook::where('name', 'like', '%'.$term.'%')->get();
            return request()->json(200, $phonebook);
        }
        return $this->_allRecord();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:6',
            'email' => 'required|email|unique:phonebooks',
            'phone' => 'required|min:7'
        ]);

        $phonebook = new Phonebook;
        $phonebook->name = $request->name;
        $phonebook->email = $request->email;
        $phonebook->phone = $request->phone;

        if ($phonebook->save()) {
            return $this->_allRecord();
        }
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
    public function edit(Phonebook $record)
    {
        return request()->json(200, $record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phonebook $record)
    {
        $request->validate([
            'name' => 'required|min:6',
            'phone' => 'required|min:7'
        ]);

        $record->name = $request->name;
        $record->phone = $request->phone;

        if ($record->save()) {
            return $this->_allRecord();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phonebook $record)
    {
        if ($record->delete()) {
            return $this->_allRecord();
        } else {
            return response()->json(425, ['delete' => 'Error deleting record']);
        }
    }

    private function _allRecord()
    {
        $phonebook = Phonebook::orderBy('created_at', 'desc')->paginate(5);
        return request()->json(200, $phonebook);
    }
}
