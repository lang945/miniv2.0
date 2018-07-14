<?php

function pagination($row)
{
    if($row > 1){
        $page = 1;
        isset($_GET['page']) ? $page = $_GET['page'] : $_GET['page'] = $page;
        echo "<div style='position:absolute;top:1%;left:35%;'>";
        if($_GET['page'] == 1){
            echo "<a href='?page=1' style='margin-left:10px;'><button style='display:none;'>首页</button></a>";
        }else{
            echo "<a href='?page=1' style='margin-left:10px;'><button style='color:white;background:deepskyblue;border-radius:3px;border:0;width:60px;height:30px;'>首页</button></a>";
        }
        if($_GET['page'] > 1){
            $page = $_GET['page'] -1;
            echo "<a href='?page=$page' style='margin-left:10px;'><button style='color:white;background:deepskyblue;border-radius:2px;border:0;width:60px;height:30px;'>上一页</button></a>";
        }

        for($i=1;$i<=$row;$i++){
            if($_GET['page'] == $i){
                echo "<a href='?page=$i'style='margin-left:10px;'><button style='color:deepskyblue;font-weight:bolder;border-radius:3px;border:0;width:40px;height:30px;'>$i</button></a>";
            }else{
                echo "<a href='?page=$i'style='margin-left:10px;'><button style='color:white;background:deepskyblue;border-radius:3px;border:0;width:40px;height:30px;'>$i</button></a>";
            }
        }
        if($_GET['page'] < $row ){

            $page = $_GET['page'] + 1;
            echo "<a href='?page=$page' style='margin-left:10px;'><button style='color:white;background:deepskyblue;border-radius:3px;border:0;width:60px;height:30px;'>下一页</button></a>";
        }
        if($_GET['page'] == $row){
            echo "<a href='?page=$row' style='margin-left:10px;'><button style='display:none'>尾页</button></a>";
        }else{
            echo "<a href='?page=$row' style='margin-left:10px;'><button style='color:white;background:deepskyblue;border-radius:3px;border:0;width:60px;height:30px;'>尾页</button></a>";
        }
        echo "</div>";
    }
}


