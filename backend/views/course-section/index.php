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
  var sections = new Array();
  <?php foreach ($courseSections as $key => $value) { ?>
    sections.push(<?= json_encode($value) ?>);
  <?php } ?>
function parseSections(sections) {
  var sectionArr = new Array();
  for(var c=0;c<sections.length;c++) {
      var section = sections[c];
      var sectionEle = {'text':section['name'], 'type':section['section_type'], 'state':{'cid': section['id'], 'opened': true}};
      sectionArr.push(sectionEle);
  }
  return sectionArr;
}

var sectionArr = parseSections(sections);

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
          if (type == "#") {
              cxtmenus['add_file'] = {
                  "label" : "新建节",
                  "icon" : "fa fa-file-o",
                  "action": function (data) {
                      addFile();
                  }
              };
           } else if (type == "file") {
             cxtmenus['view'] = {
                  "label" : "查看",
                  "icon" : "fa fa-eye",
                  "action": function (data) {
                    viewSection();
                  }
              };

              cxtmenus['edit'] = {
                  "label" : "编辑",
                  "icon" : "fa fa-edit",
                  "action": function (data) {
                    editSection();
                  }
              };

              cxtmenus['delete'] = {
                  "label" : "删除",
                  "icon" : "fa fa-trash-o",
                  "action": function (data) {
                    deleteSection();
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

function addFile() {
    var cns = $('#section_tree').jstree('get_selected', true);
    console.log(cns);
    if (cns != null && cns.length > 0) {
        layer.open({
            type: 2,
            title: '新建节',
            shadeClose: false,
            shade: [0.5, '#000'],
            maxmin: false,
            area: ['600px', '450px'],
            content: '/course-section/create'+'?course_id='+<?= $course->id; ?>,
            end: function() {
                location.reload();
            }
        });
    }
}

function editSection() {
    var cns = $('#section_tree').jstree('get_selected', true);
    if (cns != null && cns.length > 0) {
        var cn = cns[0];
        var content = '';
        content = '/course-section/update?id='+cn.state.cid;
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

function deleteSection() {
  var cns = $('#section_tree').jstree('get_selected', true);
  if (cns != null && cns.length > 0) {
      var cn = cns[0];
      content = '/course-section/delete?id='+cn.state.cid;
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

function viewSection() {
  var cns = $('#section_tree').jstree('get_selected', true);
  if (cns != null && cns.length > 0) {
      var cn = cns[0];
      content = '/course-section/view?id='+cn.state.cid;
      layer.open({
        type: 2,
        title: '查看',
        shadeClose: false,
        shade: [0.5, '#000'],
        maxmin: false,
        area: ['600px', '450px'],
        content: content,
    });
  }
}
</script>
