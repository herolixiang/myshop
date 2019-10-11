<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tools\Tools;
use DB;

class CheController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools=$tools;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');


         //搜索
        $query=request()->all();
        if(!empty($query['che_di']) || !empty($query['che_dao'])){
            $redis->incr('num');
            $num=$redis->get('num');
            echo "你是第".$num."个搜索"."<br/>";
        }

        

        $query=request()->all();
        $where = [];
        if ($query['che_di']??'') {
            $where[]=['che_di','like',"%$query[che_di]%"];
        }
        if ($query['che_dao']??'') {
            $where['che_dao']= $query['che_dao'];
        }

        $pagesize=config('app.pageSize');
        $data=DB::table('che')->where($where)->paginate($pagesize);

        return view('/che/list',['data'=>$data,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('che.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except(['_token']);
        $res=DB::table('che')->insert($data);
        if ($res) {
            return redirect('/che/list');
        }else{
            return error('添加失败','che/add');
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
    public function edit($id)
    {
       $data = DB::table('che')->where(['che_id'=>$id])->decrement('che_zhang',1);
       if($data){
        return redirect('/che/list');
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
