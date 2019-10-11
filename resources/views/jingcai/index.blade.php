<form action="addqiudui" method="post">
    @csrf
    <div>
           <h2>添加竞猜球队</h2>
        <input type="text" name="qiudui1"><h3>VS</h3><input type="text" name="qiudui2">
        <h3>结束竞猜时间</h3><input type="text" name="outtime"><br>
        <input type="submit" value="添加">
    </div>
</form>