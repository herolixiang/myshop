<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class jingcaicontroller extends Controller
{
    public function index()
    {
        // echo "111";
        return view('jingcai/index');
    }
    public function addqiudui()
    {
        $data = request()->all();

        unset($data['_token']);
//        dd($data);
        if($data['qiudui1'] == $data['qiudui2']){
            echo "<script>alert('球队不能相同');history.back(-1);</script>";
            die;
        }
        $res = DB::table('qiudui')->insert($data);
        if($res){
            echo "<script>alert('竞猜添加成功');location.href='jingcailist';</script>";
        }else{
            echo "<script>alert('添加失败');history.back(-1);</script>";
        }
    }
    public function jingcailist()
    {
        $data = DB::table('qiudui')->get();
        $tt = date('H:i',time());
        return view('jingcai/jingcailist',['data'=>$data,'tt'=>$tt]);
    }
    public function canyu(){
        $id = request()->get('id');
        $data = DB::table('qiudui')->where('id',$id)->first();
        return view('jingcai/canyulist',['data'=>$data]);
    }
    public function jingcaidd()
    {
        $id = request()->post('id');
        $qid = request()->post('qid');
        $data['q_id'] = $qid;
        $data['jieguo'] = $id;

        $res = DB::table('jingcai')->insert($data);
        if($res){
            echo json_encode(['fond'=>'竞猜成功','code'=>1]);
        }else{
            echo json_encode(['fond'=>'竞猜失败','code'=>2]);
        }
    }
    public function chengj()
    {
        $id = request()->get('id');
//        dd($id);
        $data = DB::table('jingcai')->join('qiudui','jingcai.q_id','=','qiudui.id')->where('jingcai.q_id',$id)->first();
//            dd($data);
        return view('jingcai/chengj',['dd'=>$data]);
    }
    public function kongzhi(){
        $id = request()->get('id');
        $data = DB::table('qiudui')->where('id',$id)->first();
        return view('jingcai/kongzhi',['data'=>$data]);

    }

    /**
     * 后台比赛控制
     */
    public function kongzhido()
    {
        $id = request()->post('id');
        $qid = request()->post('qid');
//        $data['q_id'] = $qid;
        $data['adjieguo'] = $id;

        $res = DB::table('jingcai')->where('q_id',$qid)->update($data);

        if($res){
            echo json_encode(['fond'=>'成功','code'=>1]);
        }else{
            echo json_encode(['fond'=>'失败','code'=>2]);
        }
    }

}
