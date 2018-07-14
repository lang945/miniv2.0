
$(document).ready(function(){


   //点击登录时弹出登录框
    var str = new RegExp("登录");
    var info = $(".login").text();
    if(str.test(info)){
        $(".login").click(function () {


            $(".PopUp").fadeIn(100);
            $(".shadow").slideDown(150);
        });
        //在未登录情况下点击留言版时弹出登录框
        $(".message").click(function(){

            $(".PopUp").fadeIn(100);
            $(".shadow").slideDown(150);


        });



    }







    //点击"x"按钮关闭弹窗
    $(".close").click(function(){


        $(".PopUp").fadeOut(100);
        $(".shadow").slideUp(150);
        //重置"登录"按钮的背景
        $(".login").removeClass("current");



    });
    //在输入框,键盘按下时确认登录时验证用户名和密码是否正确

    $(".confirm").click(function(){
        //window.alert('hello');
        $.ajax({

            async:true,//启用异步机制
            type:"POST",//请求的提交方式
            url:"/controller/controller.php",//发送给服务器某个页面的文件路径
            dataType:"xml",//服务器返回的数据格式
            data: $('#submit').serialize(),//向服务器发送数据
            //回调函数:success
            success:function(data){

                if($(data)){//$(data)是将data参数转为jquery对象以便使用

                    //获取返回的数据
                    var user_info = $(data).find("user").text();
                    var password_info = $(data).find("password").text();
                    var name=$(data).find("user_name").text();
                    //重置表单

                    //判断是否跳转
                    if(user_info=="ok"&&password_info=="ok"){


                        //提交表单到index.php页面
                        //$("#isSubmit").submit();

                        //window.alert(name);
                        //设置登录后用户信息显示
                        //$(".login").text(name);
                        document.cookie = "name=" + name;
                        //window.alert(document.cookie);
                        //重新加载页面
                        window.location.reload();

                        //禁用登录按钮
                        $(".login").attr("disabled","true");
                        //重置"登录"按钮的背景
                        $(".login").removeClass("current");


                    }else{

                        //显示错误提示信息
                        $(".PopUp span[Index='user']").show();
                        $(".PopUp span[Index='password']").show();

                        //将服务器返回的数据显示到客户端文件的指定位置
                        $(".PopUp span[Index='user']").html(user_info);
                        $(".PopUp span[Index='password']").html(password_info);
                        //2000毫秒后错误提示信息隐藏
                        setTimeout(function(){

                            $(".PopUp span[Index='user']").hide();
                            $(".PopUp span[Index='password']").hide();



                        },2000);

                    }

                }else{

                    window.alert("A fatal error has occurred!!!");

                }

            },
            error:function(jqXHR) {

                //提交失败返回状态码
                window.alert("error:" + jqXHR.status);

            }

        });


    });






});

