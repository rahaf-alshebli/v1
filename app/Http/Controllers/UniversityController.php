<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;


class UniversityController extends Controller
{
    
    
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          // $categories = category::all();
        // $rooms = Room::all();
        
        $universities = DB::table('universities')
        ->join('rooms', 'universities.room_id', '=', 'rooms.id')
        ->select('universities.*', 'rooms.name_of_building')
        ->get();

        return view('university-Admin', ['universities' =>$universities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

        $rooms = room::all();
        
                return view('add_universities', [
            'rooms'=>$rooms,
            'auth_user'=>Auth::user(),

        ]);
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
            'name_university'          => 'required',
            'address'=> 'required',
            'room_id'=> 'required',
            'logo_image'        => 'required|image',

        ]);
        
        $file_name = time() . '.' . request()->logo_image->getClientOriginalExtension();

        request()->logo_image->move(public_path('images'), $file_name);
        
        
        $university = new University();
        $university->name_university = $request->name_university;
        $university->address = $request->address;
        $university->room_id = $request->room_id;
        $university->logo_image = $file_name;
        $university->save();
        
        
        
       // $data = array('name_university'=>$request->name_university,'address'=>$request->address,'room_id'=>$request->room_id,'logo_image'=>$file_name);
        //DB::table('University')->insert($data);
        return redirect('admin/university-Admin')->with('success', 'University Data Add successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function show(University $university)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rooms = room::all();
        $universities = university::find($id);
        return view('edit_universities', [
            'rooms'=>$rooms,
            'universities'=>$universities,
            'auth_user'=>Auth::user(),

        ]);

        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, University $university)
    {
        $request->validate([
            'name_university'          => 'required',
            'university_address'          => 'required',
            'room_id'=> 'required',
            'image'        => 'required|image',
        ]);


        if ($request->image != "") {
            $university_image = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $university_image);
        } else {
            $university_image = $request->hidden_img;
        }


        $universities = university::find($request->id_university);
        
        $universities->name_university = $request->name_university;
        $universities->room_id = $request->room_id;
        $universities->address = $request->university_address;
        $universities->logo_image = $university_image;

        $universities->save();

        return redirect('admin/university-Admin')->with('success', 'University Data update successfully');


    }

    /**
     * Remove the specified resource from storage.
         * @param  int  $id

     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        University::destroy($id);
        return redirect('admin/university-Admin')->with('success', ' University Data deleted successfully');
        
    }
}
