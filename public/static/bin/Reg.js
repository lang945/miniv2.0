$(document).ready(function(){


    //点击注册时弹出登录框
    $(".register").click(function(){


        $(".Reg").fadeIn(100);
        $(".background").slideDown(150);


    });

    //点击"x"按钮关闭弹窗
    $(".shutdown").click(function(){


        $(".Reg").fadeOut(100);
        $(".background").slideUp(150);
        //重置"注册"按钮的背景
        $(".register").removeClass("current");



    });

    //在输入框,键盘按下键后校验用户填写的信息

    $("#uName").keyup(function(){


            $.ajax({

                async:true,
                type:"POST",
                dataType:"xml",
                url:"../controller/controller.php",
                data:{

                    id:"r",
                    name:$("#uName").val()



                },

                success:function(ResponseXML){


                    if($(ResponseXML)){

                        //取出服务器返回的数据
                        var uName = $(ResponseXML).find("name").text();

                        if(uName!="ok"){

                            //设置显示取得的数据的位置
                            $(".Reg span[Index='u']").html(uName);
                            //错误提示信息5秒后消失
                            setTimeout(function(){

                                $(".Reg span[Index='u']").html('');


                            },5000);

                        }else{

                            $(".Reg span[Index='u']").html("");


                        }


                    }




                },

                error:function(jqXHR){


                    window.alert("error:"+jqXHR.status);

                }




            });




    });
    $("#mail").keyup(function(){

        $.ajax({

            async: true,
            type: "POST",
            dataType: "xml",
            url: "../controller/controller.php",
            data: {

                id: "r",
                email: $("#mail").val()

            },

            success: function (ResponseXML) {


                //取出服务器返回的数据
                var mail = $(ResponseXML).find("email").text();

                if(mail!="ok"){

                    //设置显示取得的数据的位置
                    $(".Reg span[Index='m']").html(mail);
                    //错误提示信息5秒后消失
                    setTimeout(function(){

                        $(".Reg span[Index='m']").html('');


                    },5000);


                }else{

                    $(".Reg span[Index='m']").html("");


                }

            },

            error: function (jqXHR) {


                window.alert("error:" + jqXHR.status);

            }

        });



    });

    $("#pass").keyup(function(){

        $.ajax({

            async: true,
            type: "POST",
            dataType: "xml",
            url: "../controller/controller.php",
            data: {

                id: "r",
                password: $("#pass").val()


            },

            success: function (ResponseXML) {


                //取出服务器返回的数据
                var password = $(ResponseXML).find("password").text();

                if(password!="ok"){

                    //设置显示取得的数据的位置
                    $(".Reg span[Index='p']").html(password);
                    //错误提示信息5秒后消失
                    setTimeout(function(){

                        $(".Reg span[Index='p']").html('');


                    },5000);



                }else{


                    $(".Reg span[Index='p']").html("");

                }

            },

            error: function (jqXHR) {


                window.alert("error:" + jqXHR.status);

            }


        });


    });

    $("#correct").keyup(function() {


        $.ajax({

            async: true,
            type: "POST",
            dataType: "xml",
            url: "../controller/controller.php",
            data: {

                id: "r",
                password:$("#pass").val(),
                confirm: $("#correct").val()


            },

            success: function (ResponseXML) {


                //取出服务器返回的数据
                var confirm = $(ResponseXML).find("confirm").text();

                if(confirm!="ok"){

                    //设置显示取得的数据的位置
                    $(".Reg span[Index='c']").html(confirm);



                }else{

                    $(".Reg span[Index='c']").html("");


                }


            },

            error: function (jqXHR) {


                window.alert("error:" + jqXHR.status);

            }


        });
    });

    //点击"注册"时进行信息提交

    $(".userReg").click(function(){



        $.ajax({

            async: true,
            type: "POST",
            dataType: "xml",
            url: "/controller/controller.php",
            data: {

                id: "r",
                name:$("#uName").val(),
                email: $("#mail").val(),
                password:$("#pass").val(),
                confirm: $("#correct").val()


            },

            success: function (ResponseXML) {


                //取出服务器返回的数据
                var name = $(ResponseXML).find("name").text();
                var mail = $(ResponseXML).find("email").text();
                var password = $(ResponseXML).find("password").text();
                var confirm = $(ResponseXML).find("confirm").text();

                if(confirm!="ok"||password!="ok"||mail!="ok"||name!="ok"){

                    //设置显示取得的数据的位置
                    $(".Reg span[Index='u']").html(name);
                    $(".Reg span[Index='m']").html(mail);
                    $(".Reg span[Index='p']").html(password);
                    $(".Reg span[Index='c']").html(confirm);
                    //设置错误信息显示时间为5秒
                    setTimeout(function(){

                        $(".Reg span[Index='u']").html('');
                        $(".Reg span[Index='m']").html('');
                        $(".Reg span[Index='p']").html('');
                        $(".Reg span[Index='c']").html('');



                    },5000);

                    var prompt = $(".Reg span[Index]").html();
                    if(prompt!=''){

                        window.alert("Please correct your information before your click the button!");

                    }





                }else{

                    /*$(".Reg span[Index='u']").html("");
                    $(".Reg span[Index='m']").html("");
                    $(".Reg span[Index='p']").html("");
                    $(".Reg span[Index='c']").html("");*/
                    //提交用户注册信息
                    $("#reg").submit();


                }


            },

            error: function (jqXHR) {


                window.alert("error:" + jqXHR.status);

            }


        });






    });













});

