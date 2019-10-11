 <form action="list1_do" method="post">
        <center>
            <table>
            @csrf
                <tr>
                    <td>
                        <input type="text" style="width:300px;height:50px;" name="name" value="你在公司使用的php框架是什么？">
                    </td>
                </tr>
                <tr>
                    <td width="350" align="right">
                        <input type="radio"  name="aaa" value="laravel">A:&nbsp;&nbsp;&nbsp;<input type="text" style="width:250px;height:30px;" value="laravel"><br>
                        <input type="radio"  name="aaa" value="tp5">B:&nbsp;&nbsp;&nbsp;<input type="text" style="width:250px;height:30px;" value="tp5"><br>
                        <input type="radio"  name="aaa" value="ThinkPHP">C:&nbsp;&nbsp;&nbsp;<input type="text" style="width:250px;height:30px;" value="ThinkPHP"><br>
                        <input type="radio"  name="aaa" value="Cl">D:&nbsp;&nbsp;&nbsp;<input type="text" style="width:250px;height:30px;" value="Cl"><br>
                    </td>
                </tr>
                <tr>
                    <td colspan='2' align='center'>
                        <button type="">提交·</button>
                    </td>
                </tr>
            </table>
        </center>
</form>