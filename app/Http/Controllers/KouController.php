<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\Mater;
use App\Model\Labels;
use App\Model\wechatuser;
use App\Model\News;
use App\Http\Tools\Wechat;

class KouController extends Controller
{
	// public function indexs(Request $request)
	// {
	// 	$res = $request->all();
	// 	dd($res);
	// }

	public $request;
    public $wechat;
    public function __construct(Request $request,Wechat $wechat)
    {
        $this->request = $request;
        $this->wechat = $wechat;
    }

    //上传素材
    public function upload_source()
    {
    	return view('kou.uploadSource');
    }

    //上传素材处理页面
    public function do_upload(Request $request)
    {
        //接受值
        $name =$request->input('name');
        // dd($name);
        $format =$request->input('format');
        // dd($format);
        $img =$request ->file('img');
        // dd($img);
        $genre =$request ->input('genre');
        // dd($genre);
        $add_time =time();
        if (!$request->hasFile('img') || !$img->isValid()) {
            echo "报错";die;
        }
        // 文件上传 给文件起名字
        $filename =md5(time().rand(1000,9999)).".".$img->getClientOriginalExtension();
        // dd($filename);
        //文件存储位置
        $path =$img -> storeAs('uploads',$filename);
        // dd($path);
        //调用素材接口
        $mediaPash = public_path().'/'.$path;
        // dd($mediaPash);
        // 接口地址 调用token
        $access_token =$this->wechat->get_access_token();
        // dd($res);
        //地址
        if ($genre=='1') {
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$format}";
        }else{
        $url ="https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$format}";
        }
        $imgPath = new \CURLFile($mediaPash);
        // dd($imgPath);
        $data['media'] = $imgPath;
        // dd($data);
        $res =$this->wechat->post($url,$data);
        // dd($res);
        if (!$res) {
        echo "路径错误";die;
        }
        //转换格式
        $res = \json_decode($res,true);
        // dd($res);
        // if (!isset($res['media_id'])) {
        // echo "请填写图片"; die;
        // }
        //微信素材id
        $media_id = $res['media_id'];
        // dd($media_id);
        $model = new Mater;
        // dd($model);
        $model->name =$name;
        $model->genre =$genre;
        $model->format =$format;
        $model->img =$path;
        $model->add_time=$add_time;
        $model->media_id =$media_id;
        $model->save();
        if($model){
            echo("<script>alert('添加成功');history.go();location.href='/kou/matterList';</script>");
        }else{
            echo "文件类型错误";die;
        }
 
    }

    //素材列表展示
    public function matterList()
    {
        $data=DB::table('mater')->get();
        //dd($data);
        return view('kou/matterList',['data'=>$data]);
    }


    //创建标签
    public function labeladd()
    {
        return view('kou/labeladd');
    }
    //标签执行页面
    public function labeladd_do(Request $request)
    {
        $data=$request->input();
        // dd($data);
        $url='https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->wechat->get_access_token().'';
        // dd($data);
        $postdata=[
            'tag'=>[
                'name'=>$data['label_name']
            ]
        ];
        //dd($pastdata);
        $postdata=json_encode($postdata,JSON_UNESCAPED_UNICODE);
        $re=$this->wechat->post($url,$postdata);
        // dd($re);
        $label=json_decode($re,JSON_UNESCAPED_UNICODE);
        // dd($label);
        $label_name=$label['tag']['name'];
        // dd($label_name);
        $label_id=$label['tag']['id'];
        $re=DB::table('label')->insert([
            'label_name'=>$label_name,
            'label_id'=>$label_id
        ]);
        if($re){
            echo "<script>alert('入库成功');location.href='/kou/labellist';</script>";
        }else{
            echo "<script>alert('入库失败');location.href='/kou/labeladd';</script>";
        }

    }

    //标签展示页面
    public function labellist()
    {
        $data=DB::table('label')->get();
        return view('/kou/labellist',['data'=>$data]);
    }

    //标签粉丝展示页面
    public function labelfans($id)
    {
        $res=DB::table('label')->where(['b_id'=>$id])->first();
        // dd($res);
        $data=DB::table('status')->get();
        return view('/kou/labelfans',['data'=>$data,'res'=>$res]);
    }

    //粉丝列表添加
    public function labelfansadd(Request $request)
    {
        // echo "asdad";die;
        $date=$request->input();
        // dd($date);
        // dd($date);
        $url='https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$this->wechat->get_access_token().'';
        // dd($url);
        $b_id =$date['b_id'];
        // dd($b_id);
        $openid =$date['arr'];
        $arr =[];
        foreach($openid as $value){
            $arr[]=['b_id'=>$b_id,'openid'=>$value];
        };
        $model =new Labels;
        $re =$model->insert($arr);
        // dd($re);
        if($re){
           echo json_encode(['code'=>1,'font'=>'添加成功']);
        }else{
           echo json_encode(['code'=>1,'font'=>'添加失败']);
        }
        
    }

    //删除标签
    public function labeldel(Request $request)
    {
        //删除微信标签
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/delete?access_token='.$this->wechat->get_access_token();
        $data = [
            'tag' => ['id' => $request->all()['id']]
        ];
        $data =json_encode($data);
        $re = $this->wechat->post($url,$data);
        // dd($re);
        $result = json_decode($re,1);
        // dd($result);
        //删除数据库标签
        $res =json_decode($data,1);
        // dd($res);
        $id =$res['tag'];
        // dd($id);
        $res =DB::table('label')->where(['b_id'=>$id])->delete();
        if($res){
            echo("<script>alert('删除成功');history.go();location.href='/kou/labellist';</script>");
        }else{
            echo("<script>alert('删除失败');history.go();location.href='/kou/labellist';</script>");
        }
    }

    public function newsadd()
    {
    // echo "2345";
    $data = Labels::get();
    // dd($data);
    $userData = wechatuser::orderBy('subscribe_time','desc')->get();
    // dd($userData);
    return view('kou/newsadd',['data'=>$data,'userData'=>$userData]);
    }

    
    public function newsdoadd(Request $request)
    {
        // echo "123";
        $data = $request->input();
        // dd($data);
     
        // dd($access_token);
        if ($data['news_type'] == 'labels') {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$this->wechat->get_access_token().'';
        // var_dump($url);die;
        $tag_id=$data['b_id'];
        $content=$data['news_content'];
        // dd($content);
        $postdata = [
        "filter"=>[
        "is_to_all"=>false,
        "tag_id"=>$tag_id
        ],
        "text"=>[
        "content"=>$content
        ],
        "msgtype"=>"text"
        ];
        // dd($postdata);
        // $postData = json_decode($postData,true);
        $postdata = json_encode($postdata,JSON_UNESCAPED_UNICODE);
      
        $res = $this->wechat->post($url,$postdata);
        // dd($res);
        $res = json_decode($res,true);
        }else if($data['news_type'] == 'all'){
        $urls = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$this->wechat->get_access_token().'';
        // var_dump($urls);die;
        
        $postdatas = [
        "filter"=>[
        "is_to_all"=>true,
        ],
        "text"=>[
        "content"=>$data['news_content'],
        ],
        "msgtype"=>"text"
        ];
        // dd($postdatas);
        // $postData = json_decode($postData,true);
        $postdatas = json_encode($postdatas,JSON_UNESCAPED_UNICODE);
        
        $res = $this->wechat->post($urls,$postdatas);
        // dd($res);
        $res = json_decode($res,true);
        }else if($data['news_type'] == 'portion'){
        $openid = $data['arr'];
        // dd($openid);
        $newArr = '';
        foreach ($openid as $key => $value) {
        $newArr.= ',"'.$value.'"';
        }
        $openid=trim($newArr,',');
        // dd($openid);
        $contetn=$data["news_content"];
        $urla = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$this->wechat->get_access_token().'';
        // dd($url);
        $postDataa='{
        "touser":[
        '.$openid.'
        ],
        "msgtype": "text",
        "text": { "content": "'.$contetn.'"}
        }';
        
        // dump($postDataa);
        $res=Usrl::post($urla,$postdataa);
        $res = json_decode($res,true);
        // dd($res['msg_id']);
        // dd($res);
        
        }
        // dd($res);
        $model = new News;
        
        $news_content=$data['news_content'];
        $news_type=$data['news_type']; 
        $msg_id=$res['msg_id']; 
        $msg = $model->save();
        if ($msg) {
        echo json_encode(['code'=>1,'font'=>"发送成功"]);
        }else{
        echo json_encode(['code'=>0,'font'=>"发送失败"]);
        } 
    }

    //上传资源
    //  public function do_upload(Request $request)
    // {
    //     $upload_type = $request['up_type'];
    //     // dd($upload_type);
    //     $re = '';
    //     if($request->hasFile('image')){
    //         //图片类型
    //         $re = $this->wechat->upload_source($upload_type,'image');
    //         // dd($re);
    //     }elseif($request->hasFile('voice')){
    //         //音频类型
    //         //保存文件
    //         $re = $this->wechat->upload_source($upload_type,'voice');
    //     }elseif($request->hasFile('video')){
    //         //视频
    //         //保存文件
    //         $re = $this->wechat->upload_source($upload_type,'video','视频标题','视频描述');
    //     }elseif($request->hasFile('thumb')){
    //         //缩略图
    //         $path = $request->file('thumb')->store('wechat/thumb');
    //     }
    //     // echo $re;
    //     // dd($re);
    // }

    // public function get_voice_source()
    // {
    //     $media_id = 'UKml31rzRRlr8lYfWgAno9mGe-meph0BKmVtZugAHQTqZIxOhUoBvCnqfJMRMKTG';
    //     $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->wechat->get_access_token().'&media_id='.$media_id;
    //     //echo $url;echo '</br>';
    //     //保存图片
    //     $client = new Client();
    //     $response = $client->get($url);
    //     //$h = $response->getHeaders();
    //     //echo '<pre>';print_r($h);echo '</pre>';die;
    //     //获取文件名
    //     $file_info = $response->getHeader('Content-disposition');
    //     $file_name = substr(rtrim($file_info[0],'"'),-20);
    //     //$wx_image_path = 'wx/images/'.$file_name;
    //     //保存图片
    //     $path = 'wechat/voice/'.$file_name;
    //     $re = Storage::put($path, $response->getBody());
    //     echo env('APP_URL').'/storage/'.$path;
    //     dd($re);
    // }
    // public function get_video_source(){
    //     $media_id = 'f9-GxYnNAinpu3qY4oFadJaodRVvB6JybJOhdjdbh7Z0CR0bm8nO4uh8bqSaiS_d'; //视频
    //     $url = 'http://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->wechat->get_access_token().'&media_id='.$media_id;
    //     $client = new Client();
    //     $response = $client->get($url);
    //     $video_url = json_decode($response->getBody(),1)['video_url'];
    //     $file_name = explode('/',parse_url($video_url)['path'])[2];
    //     //设置超时参数
    //     $opts=array(
    //         "http"=>array(
    //             "method"=>"GET",
    //             "timeout"=>3  //单位秒
    //         ),
    //     );
    //     //创建数据流上下文
    //     $context = stream_context_create($opts);
    //     //$url请求的地址，例如：
    //     $read = file_get_contents($video_url,false, $context);
    //     $re = file_put_contents('./storage/wechat/video/'.$file_name,$read);
    //     var_dump($re);
    //     die();
    // }
    // public function get_source()
    // {
    //     $media_id = 'pREe_hxV86zjyFsmSlMNnewpYTFf5x6NuckIDkOTLgcF58FhejU-DNDucyme6x_n'; //图片
    //     $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->wechat->get_access_token().'&media_id='.$media_id;
    //     //echo $url;echo '</br>';
    //     //保存图片
    //     $client = new Client();
    //     $response = $client->get($url);
    //     //$h = $response->getHeaders();
    //     //echo '<pre>';print_r($h);echo '</pre>';die;
    //     //获取文件名
    //     $file_info = $response->getHeader('Content-disposition');
    //     $file_name = substr(rtrim($file_info[0],'"'),-20);
    //     //$wx_image_path = 'wx/images/'.$file_name;
    //     //保存图片
    //     $path = 'wechat/image/'.$file_name;
    //     $re = Storage::disk('local')->put($path, $response->getBody());
    //     echo env('APP_URL').'/storage/'.$path;
    //     dd($re);
    //     //return $file_name;
    // }


	//模板列表
	public function template_list()
	{
		$url='https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token='.$this->wechat->get_access_token().'';
		$re=file_get_contents($url);
		dd(json_decode($re,1));
	}

	//模板删除
	public function del_template()
	{
		$url='https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token='.$this->wechat->get_access_token().'';
		$data =[
			'template_id'=>'o1jBVnH2sOAuIyDjMh60qWTkH--lU3Ngw6n7c1ejm6o'
		];
		$this->wechat->post($url,json_encode($data));
	}

	//推送模板消息
	public function push_template()
	{
		$openid = 'on2efw6EPqBtK512Vg77-ekTc1Wo';
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->wechat->get_access_token();
        $data = [
            'touser'=>$openid,
            'template_id'=>'OEw_I4aAsJ1EwfurAnywLUxF3Q9OPJ5E00nu384c3DU',
            'url'=>'http://www.baidu.com',
            'data' => [
                'first' => [
                    'value' => 'Hero李翔',
                    'color' => ''
                ],
                'keyword1' => [
                    'value' => '对',
                    'color' => ''
                ],
                'keyword2' => [
                    'value' => '没毛病',
                    'color' => ''
                ],
                'remark' => [
                    'value' => '哈哈哈',
                    'color' => ''
                ]
            ]
        ];
        // dd($data);
        $re = $this->wechat->post($url,json_encode($data));
        dd($re);
     
	}


	public function login()
	{
		$redirect_uri='http://www.myshop.com/kou/code';
		$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env("WECHAT_APPID").'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
		header("Location:".$url);
	}

	public function code(Request $request)
	{
		$data=$request->all();
		// dd($data);
		$code=$data['code'];
		//获取access_token
		$url=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code=".$code."&grant_type=authorization_code");
		$data=json_decode($url,1);
		$access_token=$data['access_token'];
		$openid=$data['openid'];
		// dd($openid);
		//获取用户基本信息
		$wechat_user_info=$this->wechat->wechat_user_info($openid);

		//去user_openid 表查 是否有数据 openid = $openid
		$user_openid = DB::table("1812_wechat")->where(['openid'=>$openid])->first();

	}





	public function info()
	{
		$access_token=$this->index();
		$openid='on2efw7hrLdftR0OMAcgwS_CxBW8';
		$wechat_user=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
		// dd($wechat_user);die;
		$user_info=json_decode($wechat_user,1);
		// dd($user_info);die;
		//用户添加入库
		$data=[
			'openid'=>$user_info['openid'],
			'nickname'=>$user_info['nickname'],
			'sex'=>$user_info['sex'],
			'country'=>$user_info['country'],
			'province'=>$user_info['province'],
			'city'=>$user_info['city'],
			'headimgurl'=>$user_info['headimgurl'],
			'time'=>time()
		];
		// dd($data);

		$res=DB::table('status')->insert($data);
		if ($res) {
			echo "<script>alert('入库成功');location.href='/kou/list';</script>";
		}else{
			echo "<script>alert('入库失败');location.href='';</script>";
		}
	}

	//用户展示
	public function list()
	{
		$pagesize=config('app.pageSize');
		$data=DB::table('status')->paginate($pagesize);
		// dd($data);
		return view('/kou/list',['data'=>$data]);
	}

	//用户删除
	public function del($id)
	{
		$res=DB::table('status')->where('id','=',$id)->delete();
        //dd($res);
        if ($res) {
            echo "<script>alert('删除成功');location.href='/kou/list';</script>";
        }
	}

	//用户修改
	 public function edit($id)
    {
         // echo "edit 修改";
         // dd($id);
        $data=DB::table('status')->where(['id'=>$id])->first();
        // dd($data);
        return view('kou.edit',compact('data'));
    }
    //用户修改执行
    public function update(Request $request)
    {
        $data=$request->except(['_token']);
        $id=$request->id;
        // echo $li_id;exit;
        $res=DB::table('status')->where(['id'=>$id])->update($data);
        if ($res) {
            echo "<script>alert('进入成功');location.href='/kou/list';</script>";
        }
    }

	//调用接口查询关注的人数和最后一人openid
	public function add()
	{
		$access_token=$this->index();
		//拉取关注用户列表
		$wechat_user=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}&next_openid=");
		$user_info=json_decode($wechat_user,1);
		dd($user_info);
	}

	public function index()
	{
		//获取access_token
		// $access_token='';

		$redis=new\Redis();
		$redis->connect('127.0.0.1','6379');
		$access_token_key='wechat_access_token';
		if ($redis->exists($access_token_key)) {
			//去拿缓存
			$access_token=$redis->get($access_token_key);
		}else{
			$access_re=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."");
			$access_result=json_decode($access_re,1);
			$access_token=$access_result['access_token'];
			$expire_time=$access_result['expires_in'];
			//加入缓存
			$redis->set($access_token_key,$access_token,$expire_time);
		}
		return $access_token;
	}
}
