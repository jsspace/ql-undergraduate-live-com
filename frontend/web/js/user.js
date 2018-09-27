function getCitys(provinceid) {
    var csrfToken = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: "/user/citys",
        method: "get",
        data: {_csrf:csrfToken, provinceid:provinceid},
        success: function (data) {
            $("#user-cityid").html("<option value=>--请选择地区--</option>");
            $("#user-cityid").append(data);
        }
    });
}
function getSchools(cityid) {
    var csrfToken = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: "/shandong-school/schools",
        method: "post",
        data: {_csrf:csrfToken, cityid:cityid},
        success: function (data) {
            $("#user-schoolid").html("<option value=>- 请选择学校 -</option>");
            $("#user-schoolid").append(data);
        }
    });
}
$(function() {
    $('#user-picture').on('change', function() {
        var url = window.URL.createObjectURL(this.files[0]);
        $('.avatar-img').attr('src', url);
    });
})