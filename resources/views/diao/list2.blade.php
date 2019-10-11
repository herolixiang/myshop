<form action="list2_do" method="post">
        <center>
       @csrf
        <div class="checkbox">
            <td><input type="text" name="name" style="width:250px;height:30px;" value="你认为现在需要学习的技术是什么？"></td><br>
            <input type="checkbox"  name="aa" value="直播技术">A<input type="text" style="width:250px;height:30px;" value="直播技术"><br>
            <input type="checkbox"  name="bb" value="框架">B<input type="text" style="width:250px;height:30px;" value="框架"><br>
            <input type="checkbox" checked="" name="cc" value="APl">C<input type="text" style="width:250px;height:30px;" value="APl"><br>
            <input type="checkbox" name="dd" value="架构">D<input type="text" style="width:250px;height:30px;" value="架构"><br>
        </div>
        <div>
            &nbsp;
        </div>
        <div colspan='2' align='center'>
                    <button type="">提交·</button>
        </div>
        </center>
</form>