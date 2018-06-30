<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use frontend\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseSectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '课程章节');
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="/css/lib/jstree.min.css" rel="stylesheet">
<link rel="stylesheet" href="/skin/layer.css" id="layui_layer_skinlayercss">
<div class="course-section-index">
    <div id="section_tree">
    </div>
</div>

<script src="<?= Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?= Url::to('@web/js/lib/jstree.min.js');?>"></script>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>

<script type="text/javascript">
    <?php 
        
    ?>
  var sections = new Array();
  <?php foreach ($courseSections as $key => $value) {
    $value->section_type = 'file';
    print_r($value);die();
    ?>
    sections.push(<?= json_encode($value); ?>);
  <?php } ?>
/*function parseSections(sections) {
  var sectionArr = new Array();
  for(var c=0;c<sections.length;c++) {
      var section = sections[c];
      //if (section['parent_id'] == parent) {
          var sectionEle = {'text':section['name'], 'type':section['section_type'], 'state':{'cid': section['section_id']}};
          /*if (section['section_type'] == 'folder') {
            sectionEle['children'] = parseSections(sections, section['section_id']);
          }*/
          sectionArr.push(sectionEle);
      //}
  }
  return sectionArr;
}

var sectionArr = parseSections(sections);*/

$('#section_tree').jstree({
  'plugins': ['types', 'contextmenu', 'state', 'wholerow'], //, 'wholerow'
  'types': {
      "folder" : {
          "icon" : "fa fa-folder-o"
      },
      "file" : {
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
          /*if (type == "#") {
              cxtmenus['add_folder'] = {
                  "label" : "新建章",
                  "icon" : "fa fa-folder-o",
                  "action": function (data) {
                    addFolder();
                  }
              };
          } else*/
          if (type == "#") {
              cxtmenus['add_file'] = {
                  "label" : "新建节",
                  "icon" : "fa fa-file-o",
                  "action": function (data) {
                      addFile();
                  }
              };

              /*cxtmenus['edit'] = {
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
              };*/
          }
          else if (type == "file") {
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
          "children": sectionArr
      }],
      'themes': {
          'name': 'proton',
          'responsive': true
      }
  }
});

$.vakata.context.settings.hide_onmouseleave = 100;

function addFolder() {
  var cns = $('#section_tree').jstree('get_selected', true);
  if (cns != null && cns.length > 0) {
      var cn = cns[0];
      var pid = '0';
      layer.open({
          type: 2,
          title: '新建章',
          shadeClose: false,
          shade: [0.5, '#000'],
          maxmin: false,
          area: ['600px', '420px'],
          content: '/course-chapter/create?course_id='+<?= $course->id; ?>,
          end: function() {
            location.reload();
          }
      });
  }
}

function addFile() {
    var cns = $('#section_tree').jstree('get_selected', true);
    if (cns != null && cns.length > 0) {
        var cn = cns[0];
        var pid = '0';
        if (cn.type == 'folder') {
            pid = cn.state.cid;
        }
        layer.open({
            type: 2,
            title: '新建节',
            shadeClose: false,
            shade: [0.5, '#000'],
            maxmin: false,
            area: ['600px', '450px'],
            content: '/course-section/create'+'?course_id='+pid,
            end: function() {
                location.reload();
            }
            /*content: '/course-section/create'+'?chapter_type=1&chapter_id='+pid+'&course_id=17',*/
        });
    }
}

function editChapter() {
    var cns = $('#chapter_tree').jstree('get_selected', true);
    if (cns != null && cns.length > 0) {
        var cn = cns[0];
        var content = '';
        if (cn.type == 'folder') {
            content = '/course-chapter/update?id='+cn.state.cid;
        } else {
            content = '/course-section/update?id='+cn.state.cid;
        }
        layer.open({
            type: 2,
            title: '编辑',
            shadeClose: false,
            shade: [0.5, '#000'],
            maxmin: false,
            area: ['600px', '450px'],
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
      if (cn.type == 'folder') {
          content = '/course-chapter/delete';
      } else {
          content = '/course-section/delete';
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
