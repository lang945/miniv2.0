


$(document).ready(function(){
    //定义索引变量
    var i = 0;
   //控制自动切换的变量
    var timer;
    //默认显示第一张图片
    //$(".images").eq(0).show().siblings().hide();
    //设置默认样式
    $(".images").eq(0).css({zIndex:1,left:"0%"});
    $(".images").eq(1).css({zIndex:0,left:"100%"});
    $(".images").eq(2).css({zIndex:-1,left:"200%"});
    $(".images").eq(3).css({zIndex:-2,left:"300%"});


    //设置实现核心功能的函数
    /*
    var Show = function(){

        //设置图片切换（淡入，淡出）
        $(".images").eq(i).fadeIn(300).siblings().fadeOut(300);
        //设置小下标颜色
        $(".point").eq(i).addClass("color").siblings().removeClass("color");



    }

*/
    var Show = function(){

        //设置图片切换
        switch (i){
            case 0:
                $('.images').eq(i).animate({left:"0%"},1200);
                $('.images').eq(i+1).animate({left:"100%"},1200);
                $('.images').eq(i+2).animate({left:"200%"},1200);
                $('.images').eq(i+3).animate({left:"300%"},1200);
                break;
            case 1:
                $('.images').eq(i-1).animate({left:"-100%"},1200);
                $('.images').eq(i).animate({left:"0%"},1200);
                $('.images').eq(i+1).animate({left:"100%"},1200);
                $('.images').eq(i+2).animate({left:"200%"},1200);
                break;
            case 2:
                $('.images').eq(i-2).animate({left:"-200%"},1200);
                $('.images').eq(i-1).animate({left:"-100%"},1200);
                $('.images').eq(i).animate({left:"0%"},1200);
                $('.images').eq(i+1).animate({left:"100%"},1200);
                break;
            case 3:
                $('.images').eq(i-3).animate({left:"-300%"},1200);
                $('.images').eq(i-2).animate({left:"-200%"},1200);
                $('.images').eq(i-1).animate({left:"-100%"},1200);
                $('.images').eq(i).animate({left:"0%"},1200);
                break;

            default:
                break;

        }


        //设置小下标颜色
        $(".point").eq(i).addClass("color").siblings().removeClass("color");


    };



    //每隔4秒切换一张图片

    var ShowTime = function(){

        timer = setInterval(function(){

            i += 1;
            if(i==4){

                i = 0;

            }

            Show();


        },4000);



    }
    ShowTime();

   //点击左箭头切换图片
    $(".left_button").click(function(){

        //先暂停自动切换
        clearInterval(timer);

        //判断下标是否为0
        if(i==0){

            i = 4;


        }

        i -= 1;
        //切换图片
        Show();
        ShowTime();//鼠标不点击时开启自动切换




    });






   //点击右箭头切换图片

    $(".right_button").click(function(){


        //先暂停自动切换
        clearInterval(timer);

        i += 1;
        //判断下标是否为4
        if(i==4){

            i = 0;


        }

        //切换图片
        Show();

        ShowTime();//鼠标不点击时开启自动切换





    });

    //鼠标点击下标时暂停切换图片并实现手动切换图片,鼠标离开时继续自动切换
    $(".point").click(function(){

        //鼠标悬停在下标时
        i = $(this).index();//获取下标索引值
        clearInterval(timer);//清除自动切换
        Show();//切换图片
        //鼠标离开下标后
        ShowTime();//自动切换

    });













});