var commonFunc = {
    init: function() {
        var self = this;
        self.menuAnimate();
        self.getMenuTree();
    },
    menuAnimate: function() {
        $(".wrap .account .user-info").on("click", function() {
            var $ele = $(this).parents(".account");
            if ($ele.hasClass("active")) {
                $ele.find(".account-dropdown").hide();
                $ele.removeClass("active");
            } else {
                $ele.find(".account-dropdown").show();
                $ele.addClass("active");
            }
        });
        $(".wrap .account .account-dropdown").on('click', function(e) {
            var target = $(e.target);
            if(target.closest('.btn-modify, .btn-logout').length === 0) {
                $(this).hide();
                $(this).parents(".account").removeClass("active");
            }
        });
    },
    getMenuTree: function() {
        var self = this;
        var tree = [
          {
              text: "控制台",
              icon: "icon ion-home"
          },
          {
              text: "系统设置",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "用户列表",
                      href: "http://admin.ql.com/admin/user"
                  },
                  {
                      text: "分配",
                      href: "http://admin.ql.com/admin/assignment"
                  },
                  {
                      text: "角色列表",
                      href: "http://admin.ql.com/admin/role"
                  },
                  {
                      text: "权限列表",
                      href: "http://admin.ql.com/admin/permission"
                  },
                  {
                      text: "路由列表",
                      href: "http://admin.ql.com/admin/route"
                  },
                  {
                      text: "规则列表",
                      href: "http://admin.ql.com/admin/rule"
                  },
                  {
                      text: "菜单",
                      href: "http://admin.ql.com/admin/menu"
                  },
                  {
                      text: "数据字典",
                      
                  },
                  {
                      text: "区域管理",
                      
                  },
                  {
                      text: "通知管理",
                      
                  }
                ]
          },
          {
              text: "学员管理",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "学员分类"
                  },
                  {
                      text: "配课管理"
                  }
              ]
          },
          {
              text: "课程管理",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "课程管理",
                      href: "http://admin.ql.com/course/index"
                  },
                  {
                      text: "课程分类管理",
                      href: "http://admin.ql.com/course-category/index"
                  },
                  {
                      text: "教师答疑"
                  },
                  {
                      text: "课程资料"
                  },
                  {
                      text: "课程评价"
                  },
                  {
                      text: "购买课程"
                  },
                  {
                      text: "网课需求"
                  },
                  {
                      text: "申请开课"
                  }
              ]
          },
          {
              text: "客户管理",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "网校信息管理"
                  },
                  {
                      text: "客户分类"
                  },
                  {
                      text: "客户管理员"
                  },
                  {
                      text: "企业申请"
                  },
                  {
                      text: "公告管理"
                  },
              ]
          },
          {
              text: "伙伴管理",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "网校信息管理"
                  },
                  {
                      text: "机构分类"
                  },
                  {
                      text: "机构管理员"
                  },
                  {
                      text: "公告管理"
                  },
              ]
          },
          {
              text: "讲师管理",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "讲师信息管理"
                  },
                  {
                      text: "讲师管理员"
                  },
                  {
                      text: "邀约直播"
                  },
                  {
                      text: "授课预约"
                  },
                  {
                      text: "教师登记"
                  },
                  {
                      text: "教师评价"
                  }
              ]
          },
          {
              text: "市场专员",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "市场专员"
                  }
              ]
          },
          {
              text: "订单管理",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "散户订单"
                  },
                  {
                      text: "企业订单"
                  }
              ]
          },
          {
              text: "共享资源",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "资源管理"
                  }
              ]
          },
          {
              text: "课程推荐",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "软文发布"
                  }
              ]
          },
          {
              text: "传媒必读",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "职场必读"
                  },
                  {
                      text: "分类管理"
                  }
              ]
          },
          {
              text: "管理规定",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "管理规定"
                  }
              ]
          },
          {
              text: "帮助管理",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "后台帮助"
                  },
                  {
                      text: "前台帮助"
                  }
              ]
          },
          {
              text: "管理协议",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "管理协议"
                  }
              ]
          },
          {
              text: "友情链接",
              state: {
                expanded: false
              },
              nodes: [
                  {
                      text: "友情链接",
                      href: "http://admin.ql.com/friendly-links/index"
                  }
              ]
          }
        ];
        $('#tree').treeview({
            enableLinks: true,
            data: tree
        });
    }
}
commonFunc.init();