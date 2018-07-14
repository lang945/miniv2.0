$(document).ready(function(){

    //点击菜单各个选项触发相关事件
    $('.tab tr td').click(function(){
        //重置菜单选项的背景样式
        $(".tab tr td").css("background","");


        //显示搜索框和文本显示区域
        $('.search,.MainText').css('display','block');



    });


    $('.tab tr td[Index="permissions"]').click(function(){

        //设置搜索框的占位符(placeholder)内容
        $('.find').attr("placeholder","输入用户类型,如:管理员");

        //设置菜单选项背景样式
        $(this).css({background:"RGBA(0,0,0,0.2)"});


    });
    $('.tab tr td[Index="articles"]').click(function(){

        //设置搜索框的占位符(placeholder)内容
        $('.find').attr("placeholder","输入文章标题,如:管理员");
        //重置菜单选项的背景样式
        //$(".tab tr td").css("background","");

        //设置菜单选项背景样式
        $(this).css({background:"RGBA(0,0,0,0.2)"});


    });
    $('.tab tr td[Index="message"]').click(function(){

        //设置搜索框的占位符(placeholder)内容
        $('.find').attr("placeholder","输入留言内容,如:管理员");
        //重置菜单选项的背景样式
        //$(".tab tr td").css("background","");

        //设置菜单选项背景样式
        $(this).css({background:"RGBA(0,0,0,0.2)"});


    });
    $('.tab tr td[Index="comments"]').click(function(){

        //设置搜索框的占位符(placeholder)内容
        $('.find').attr("placeholder","输入评论标题,如:管理员");
        //重置菜单选项的背景样式
        //$(".tab tr td").css("background","");

        //设置菜单选项背景样式
        $(this).css({background:"RGBA(0,0,0,0.2)"});


    });


    //点击"菜单选项"时触发事件
    $(".tab tr th").click(function(){


        //设置鼠标样式
        $(this).css("cursor","pointer");
        //重置菜单选项的背景样式
        $(".tab tr td").css("background","");
        //隐藏搜索框和文本显示区域
        $('.search,.MainText').css('display','none');




    });
    //点击"查询"按钮时就查询内容
    $(".button").click(function(){

        $.ajax({

            async: true,
            type: "POST",
            dataType: "xml",
            url: "/model/admin.php",

            data:{

                words: $('.find').val()

            },

            success:function(data){


                if($(data)){


                    /*
                    var rows = $(data).find('info').text().split(";");
                    var html = function(){

                        document.write("<table border='1px' cellpadding='0' cellspacing='0'><tr><th>用户名</th><th>类型</th><th>密码</th></tr>");


                        for(var i=0;i<rows.length-1;i++) {

                            document.write("<tr>");

                            for(var j=0;j<rows[0].split(',').length;j++){

                                //document.write("Hello\n");
                                document.write("<td>"+rows[i].split(',')[j]+"</td>");

                            }

                            document.write("</tr>");

                        }

                        document.write("</table>");

                    };

                    html();


                  */

                    $(".MainText").html($(data).find('info').text());






                }

            },

            failure:function(result){

                window.alert("数据获取失败!");


            }



        });



    });




});