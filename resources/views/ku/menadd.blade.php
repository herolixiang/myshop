
<html>
<body>
    <center>
        <h3>车库管理系统</h3>
        <span >小区车位：400</span>
        @if($data)
        @foreach($data as $v)
        <span>剩余车位:{{$v->ku2_liang}}</span>
        @endforeach
        @endif
        <h3><a href="{{url('ku/menlist1')}}">车辆入库</a></h3>
        <h3><a href="{{url('ku/menlist2')}}">车辆出库</a></h3>
    </center>
</body>
</html>