$(document).ready(function(){


//设置移除css样式的函数

var isClear = false;

var remove_style = function(){

        $("td").removeClass("mouse_hover");
        $(".td_symbol").css("color","grey");
        $(".sec_three_menu table").css("display","none");
        $(".sec_three_menu").css("display","none");

}

//设置鼠标点击在某处时修改背景颜色
    $(".first a").click(function(){
        $(this).addClass("current").siblings().removeClass("current");

    });



//设置鼠标悬停在某处时触发的事件

$(".prompt").hover(function(){

    $(".triangle").css("display","block");
    $(".rectangle").css("display","block");
    $(".show").css({"color":"orangered","font-weight":"bolder","cursor":"pointer"});




});

$(".sec_three_child3").hover(function(){

    $(".button").css("display","block");



},function(){

    $(".button").css("display","none");



});

$(".sec_three_child1 table tr").hover(function(){


    //获取DOM元素id的值
    var ID = $(this).attr("id");
    //重置CSS样式
    remove_style();
    //显示菜单
    $(".sec_three_menu").css("display","block");

    //根据ID的值设置css样式
    switch(ID){

        case '1':

            $("td[Index='1']").addClass("mouse_hover");
            $(".td_symbol[Index='1']").css("color","white");
            $("#one").css("display","inline-table");

            break;

        case '2':

            $("td[Index='2']").addClass("mouse_hover");
            $(".td_symbol[Index='2']").css("color","white");
            $("#two").css("display","inline-table");

            break;
        case '3':

            $("td[Index='3']").addClass("mouse_hover");
            $(".td_symbol[Index='3']").css("color","white");
            $("#three").css("display","inline-table");

            break;
        case '4':

            $("td[Index='4']").addClass("mouse_hover");
            $(".td_symbol[Index='4']").css("color","white");
            $("#four").css("display","inline-table");

            break;
        case '5':

            $("td[Index='5']").addClass("mouse_hover");
            $(".td_symbol[Index='5']").css("color","white");
            $("#five").css("display","inline-table");

            break;
        case '6':

            $("td[Index='6']").addClass("mouse_hover");
            $(".td_symbol[Index='6']").css("color","white");
            $("#six").css("display","inline-table");

            break;
        default:

            break;




    }



});








/*
    $(".sec_three_child1 tr[id='1']").hover(function(){

        remove_style();
       $(".td_title[Index='1']").addClass("mouse_hover");
       $(".td_symbol[Index='1']").addClass("mouse_hover");
        $(".td_symbol[Index='1']").css("color","white");
        $(".sec_three_menu").css("display","block");
        $("#one").css("display","inline-table");


    });
    $(".sec_three_child1 tr[id='2']").hover(function(){

        remove_style();
        $(".td_title[Index='2']").addClass("mouse_hover");
        $(".td_symbol[Index='2']").addClass("mouse_hover");
        $(".td_symbol[Index='2']").css("color","white");
        $(".sec_three_menu").css("display","block");
        $("#two").css("display","inline-table");
    });
    $(".sec_three_child1 tr[id='3']").hover(function(){

        remove_style();
        $(".td_title[Index='3']").addClass("mouse_hover");
        $(".td_symbol[Index='3']").addClass("mouse_hover");
        $(".td_symbol[Index='3']").css("color","white");
        $(".sec_three_menu").css("display","block");
        $("#three").css("display","inline-table");

    });

    $(".sec_three_child1 tr[id='4']").hover(function(){

        remove_style();
        $(".td_title[Index='4']").addClass("mouse_hover");
        $(".td_symbol[Index='4']").addClass("mouse_hover");
        $(".td_symbol[Index='4']").css("color","white");
        $(".sec_three_menu").css("display","block");
        $("#four").css("display","inline-table");

    });
    $(".sec_three_child1 tr[id='5']").hover(function(){

        remove_style();
        $(".td_title[Index='5']").addClass("mouse_hover");
        $(".td_symbol[Index='5']").addClass("mouse_hover");
        $(".td_symbol[Index='5']").css("color","white");
        $(".sec_three_menu").css("display","block");
        $("#five").css("display","inline-table");

    });

    $(".sec_three_child1 tr[id='6']").hover(function(){

        remove_style();
        $(".td_title[Index='6']").addClass("mouse_hover");
        $(".td_symbol[Index='6']").addClass("mouse_hover");
        $(".td_symbol[Index='6']").css("color","white");
        $(".sec_three_menu").css("display","block");
        $("#six").css("display","inline-table");

    });




*/

//设置鼠标离开某处触发的事件
    $(".title").mouseleave(function(){

        remove_style();



    });


    $(".association").mouseleave(function(){

            remove_style();


        });
    $(".prompt").mouseleave(function(){


        $(".triangle").css("display","none");
        $(".rectangle").css("display","none");
        $(".show").css({"color":"black","font-weight":"normal","cursor":"default"});


    });









});