
var CreateXMLHttpRequest = function(){

    //创建ajax引擎:不同浏览器创建XMLHttpRequest对象实例不同
    var xml_http_request = null;
    if(window.ActiveXObject||"ActiveXObject" in window){

        xml_http_request = new ActiveXObject("Microsoft.XMLHTTP");
        //window.alert("IE");


    }else{


       //window.alert("Other browser");
        xml_http_request = new XMLHttpRequest();


    }

    //window.alert("Successful!");
    return xml_http_request;



}