function getCitys(provinceid) {
    var csrfToken = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: "/user/citys",
        method: "get",
        data: {_csrf:csrfToken, provinceid:provinceid},
        success: function (data) {
            $("#user-cityid").html("<option value=>--请选择地级市--</option>");
            $("#user-cityid").append(data);
        }
    });
}