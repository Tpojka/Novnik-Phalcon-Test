Email = {
  LoadMessageContainer:function(eid){

    var params = { eid:eid };
    var url = base_url + "api/email/get_email_content";

    this.AjaxRequest(url,params,"GET");

  },
  AjaxRequest:function (url,params,method) {

    $.ajax({
      type: method,
      data: params,
      url: url,
      async:false,
      success: function (response) {
        return response;
      }
    });

  }
};
