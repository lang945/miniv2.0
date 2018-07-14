//获取DOM对象
var Input = document.getElementById('title');
var Text = document.getElementById('content');
//定义事件处理函数
var Focus = function(str) {

    if(str.value == "请输入标题") {
        str.value = "";

    }
    if(str.value == "请输入内容"){

        str.value = "";


    }
};
var Blur = function(str){

    if(str.value==""&&str.id=="title"){

        str.value = "请输入标题";

    }
    if(str.value == ""&&str.id=="content"){

        str.value = "请输入内容";


    }

};
//绑定事件
Input.onfocus = function(){

    Focus(Input);
}
Input.onblur = function(){

    Blur(Input);

}

Text.onfocus = function(){

    Focus(Text);


}
Text.onblur = function(){

    Blur(Text);


}




