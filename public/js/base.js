var APP = {};
APP.GLOBAL = {};
APP.QUERYPHONE = {};
APP.QUERYPHONE.checkPhone = function(phone){
  var regexp = /^(\(86\))?[0]?((1[358][0-9]{9})|(147[0-9]{8})|(17[3678][\d]{8}))$/;
  if(false == regexp.test(phone)){
    APP.QUERYPHONE.disableSubmit();
  }else{
    APP.QUERYPHONE.enableSubmit();
  }
};
APP.QUERYPHONE.focusText = function(){
  $("#phoneText").attr("placeholder", "Please input your number").focus();
};
APP.QUERYPHONE.disableSubmit = function(){
  $("#subPhone").attr("disabled","disabled");
};
APP.QUERYPHONE.enableSubmit = function(){
  $("#subPhone").removeAttr("disabled");
};

APP.QUERYPHONE.hideInfomation = function(){
  $("#phoneInfo").hide();
};
APP.QUERYPHONE.showInfomation = function(info){
  $("#phoneNumber").text(info.telString);
  $("#phoneProvince").text(info.province);
  $("#phoneCatName").text(info.catName);
  $("#phoneMsg").text(info.message);
  $("#phoneInfo").show();
};
APP.QUERYPHONE.dataCallback = function(data){
  if (data.success == false) {
    APP.QUERYPHONE.hideInfomation();
  } else {
    APP.QUERYPHONE.showInfomation(data.result);
  }
};

APP.GLOBAL.ajax = function(url, params, callback){
  $.ajax({
    url: url,
    type: "POST",
    data: params,
    success: callback,
    error: function(){
      console.log("error");
    },
    dataType: "json"
  });
};