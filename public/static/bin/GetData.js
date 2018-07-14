

$(function(){


    //取得url中page的值
    var urlStr = window.location.search.substr(6,1);

    $.get_info = function(){


        $.ajax({

            async:true,
            type:"POST",
            url:"/model/update_data.php",
            dataType:"json",
            data:{

                record:parseInt(urlStr)-1,
                a:'1',
                b:'2',
                c:'3',
                d:'4',
                e:'5'


            },


            success:function(data){

                if($(data)){

                    //取的返回的数据

                            $(".list1 p").eq(0).html($(data)[0]);
                            //$(".list1 p").eq(0).addClass("pageFocus");

                            $(".list2 p").eq(0).html($(data)[1]);
                            //$(".list2 p").eq(0).addClass("pageFocus");

                            $(".list3 p").eq(0).html($(data)[2]);
                            //$(".list3 p").eq(0).addClass("pageFocus");


                            $(".list4 p").eq(0).html($(data)[3]);
                            //$(".list4 p").eq(0).addClass("pageFocus");


                            $(".list5 p").eq(0).html($(data)[4]);
                            //$(".list5 p").eq(0).addClass("pageFocus");


                }



            },

            error:function(){

                window.alert("数据加载失败!");





            }


        });



    }


    //当页面加载后并且url中page等于特定值的时候取出服务器返回的数据
    switch(urlStr){

        case '2':

            $.get_info();
            break;
        case '3':
            $.get_info();
            break;
        case '4':
            $.get_info();
            break;
        case '5':
            $.get_info();
            break;
        case '6':
            $.get_info();
            break;
        default:
            break;


    }







});