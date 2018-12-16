<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseChapterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\helpers\Url;
use frontend\assets\AppAsset;

// AppAsset::addCss($this,'@web/css/lib/jstree.min.css');
// AppAsset::addCss($this,'@web/skin/layer.css');

$this->title = Yii::t('app', 'Course Chapters');
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="/css/lib/jstree.min.css" rel="stylesheet">
<link rel="stylesheet" href="/skin/layer.css" id="layui_layer_skinlayercss">
<div class="course-chapter-index">
    <div id="chapter_tree">
    </div>
</div>

<script src="<?= Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?= Url::to('@web/js/lib/jstree.min.js');?>"></script>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>

<script type="text/javascript">

var chapterArr = JSON.parse(<?= json_encode($chapters); ?>);

$('#chapter_tree').jstree({
  'plugins': ['types', 'contextmenu', 'state', 'wholerow'], //, 'wholerow'
  'types': {
      "chapter" : {
          "icon" : "fa fa-folder-o"
      },
      "section" : {
          "icon" : "fa fa-folder-o"
      },
      "point" : {
          "icon" : "fa fa-file"
      },
      "default" : {
          "icon" : "fa fa-folder-o"
      },
  },
  'contextmenu' : {
      'items' : function(node) {
          var cxtmenus = {};
          var type = this.get_type(node);
          if (type == "#") {
              cxtmenus['add_unit'] = {
                  "label" : "新建单元",
                  "icon" : "fa fa-folder-o",
                  "action": function (data) {
                    addUnit();
                  }
              };
          } else if (type == "chapter") {
              cxtmenus['add_section'] = {
                  "label" : "新建节",
                  "icon" : "fa fa-file-o",
                  "action": function (data) {
                      addSection();
                  }
              };

              cxtmenus['edit'] = {
                  "label" : "编辑",
                  "icon" : "fa fa-edit",
                  "action": function (data) {
                      editChapter();
                  }
              };

              cxtmenus['delete'] = {
                  "label" : "删除",
                  "icon" : "fa fa-trash-o",
                  "action": function (data) {
                      deleteChapter();
                  }
              };
          } else if (type == "section") {
              cxtmenus['add_point'] = {
                  "label" : "新建知识点",
                  "icon" : "fa fa-file-o",
                  "action": function (data) {
                      addPoint();
                  }
              };

              cxtmenus['edit'] = {
                  "label" : "编辑",
                  "icon" : "fa fa-edit",
                  "action": function (data) {
                      editChapter();
                  }
              };

              cxtmenus['delete'] = {
                  "label" : "删除",
                  "icon" : "fa fa-trash-o",
                  "action": function (data) {
                      deleteChapter();
                  }
              };
          } else if (type == "point") {
              cxtmenus['edit'] = {
                  "label" : "编辑",
                  "icon" : "fa fa-edit",
                  "action": function (data) {
                    editChapter();
                  }
              };

              cxtmenus['delete'] = {
                  "label" : "删除",
                  "icon" : "fa fa-trash-o",
                  "action": function (data) {
                    deleteChapter();
                  }
              };
          }

          return cxtmenus;
      }
  },
  'core': {
      'data': [{
          "text": "<?= $course->course_name; ?>",
          "type": "#",
          "state": {
            "opened": true,
            "cid": '0'
          },
          "children": chapterArr
      }],
      'themes': {
          'name': 'proton',
          'responsive': true
      }
  }
});

$.vakata.context.settings.hide_onmouseleave = 100;

function addUnit() {
  var cns = $('#chapter_tree').jstree('get_selected', true);
  if (cns != null && cns.length > 0) {
      layer.open({
          type: 2,
          title: '新建单元',
          shadeClose: false,
          shade: [0.5, '#000'],
          maxmin: false,
          area: ['600px', '320px'],
          content: '/course-chapter/create?course_id='+<?= $course->id; ?>,
          end: function() {
            location.reload();
          }
      });
  }
}

function addSection() {
    var cns = $('#chapter_tree').jstree('get_selected', true);
    if (cns != null && cns.length > 0) {
        var cn = cns[0],
            pid = cn.state.cid;
        layer.open({
            type: 2,
            title: '新建节',
            shadeClose: false,
            shade: [0.5, '#000'],
            maxmin: false,
            area: ['600px', '320px'],
            content: '/course-section/create'+'?chapter_id='+pid,
            end: function() {
                location.reload();
            }
        });
    }
}

function addPoint() {
    var cns = $('#chapter_tree').jstree('get_selected', true);
    if (cns != null && cns.length > 0) {
        var cn = cns[0],
            pid = cn.state.cid;
        layer.open({
            type: 2,
            title: '新建知识点',
            shadeClose: false,
            shade: [0.5, '#000'],
            maxmin: false,
            area: ['600px', '520px'],
            content: '/course-section-points/create'+'?section_id='+pid,
            end: function() {
                location.reload();
            }
        });
    }
}

function editChapter() {
    var cns = $('#chapter_tree').jstree('get_selected', true);
    if (cns != null && cns.length > 0) {
        console.log(cns)
        var cn = cns[0];
        var content = '',
            width = '320px';
        if (cn.type == 'chapter') {
            content = '/course-chapter/update?id='+cn.state.cid;
        } else if (cn.type == 'section') {
            content = '/course-section/update?id='+cn.state.cid;
        } else if (cn.type == 'point') {
            content = '/course-section-points/update?id='+cn.state.cid;
            width = '520px';
        }
        layer.open({
            type: 2,
            title: '编辑',
            shadeClose: false,
            shade: [0.5, '#000'],
            maxmin: false,
            area: ['600px', width],
            content: content,
            end: function() {
                location.reload();
            }
        });
    }
}

function deleteChapter() {
  var cns = $('#chapter_tree').jstree('get_selected', true);
  if (cns != null && cns.length > 0) {
      var cn = cns[0];
      if (cn.type == 'chapter') {
          content = '/course-chapter/delete';
      } else if (cn.type == 'section') {
          content = '/course-section/delete';
      } else if (cn.type == 'point') {
          content = '/course-section-points/delete';
      }
      //询问框
      layer.confirm('确定要删除吗？', {
          btn: ['确定','取消'] //按钮
      }, function(){
          $.ajax({
              url: content,
              type: 'get',
              data: {
                  id: cn.state.cid
              },
              success: function(data) {
                  layer.msg('删除成功', {icon: 1});
                  window.location.reload();
              }
          });
      }, function(){
          layer.close();
      });
  }
}
</script>