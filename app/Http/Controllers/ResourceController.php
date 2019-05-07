<?php
<<<<<<< HEAD

namespace App\Http\Controllers;

use Illuminate\Http\Request;

=======
namespace App\Http\Controllers;
use Illuminate\Http\Request;
>>>>>>> resource
class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo "Index";
    }
<<<<<<< HEAD

=======
>>>>>>> resource
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo "CREATE";
    }
<<<<<<< HEAD

=======
>>>>>>> resource
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        echo "STORE";
    }
<<<<<<< HEAD

=======
>>>>>>> resource
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        echo "id:".$id;
    }
<<<<<<< HEAD

=======
>>>>>>> resource
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo "user_id:".$id;
    }
<<<<<<< HEAD

=======
>>>>>>> resource
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo "u_id:".$id;
        echo "<br/>";
        echo "Update";
    }
<<<<<<< HEAD

=======
>>>>>>> resource
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo "goods_id:".$id;
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> resource
