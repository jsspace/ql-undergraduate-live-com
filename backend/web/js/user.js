function getCitys(provinceid) {
    var csrfToken = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: "/user/citys",
        method: "post",
        data: {_csrf:csrfToken, provinceid:provinceid},
        success: function (data) {
            $("#user-cityid").html("<option value=>--请选择地级市--</option>");
            $("#user-cityid").append(data);
        }
    });
}
function getProvince(phone) {
    var csrfToken = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: "/user/province",
        method: "post",
        data: {_csrf:csrfToken, phone:phone},
        success: function (data) {
            
        }
    });
}