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

<script src="<?php echo Url::to('@web/js/lib/jquery.min.js');?>"></script>
<script src="<?php echo Url::to('@web/js/lib/jstree.min.js');?>"></script>
<script src="<?php echo Url::to('@web/skin/layer.js');?>"></script>

<script type="text/javascript">
  var chapters = new Array();
  <?php foreach ($chapters as $key => $value) { ?>
    chapters.push(<?= $value; ?>);
  <?php } ?>
function parseChapters(chapters, parent) {
  var chapterArr = new Array();
  for(var c=0;c<chapters.length;c++) {
      var chapter = chapters[c];
      if (chapter['parent_id'] == parent) {
          var chapterEle = {'text':chapter['name'], 'type':chapter['chapter_type'], 'state':{'cid': chapter['chapter_id'],'opened': true}};
          if (chapter['chapter_type'] == 'folder') {
            chapterEle['children'] = parseChapters(chapters, chapter['chapter_id']);
          }
          chapterArr.push(chapterEle);
      }
  }
  return chapterArr;
}

var chapterArr = parseChapters(chapters, '0');

$('#chapter_tree').jstree({
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
              cxtmenus['add_folder'] = {
                  "label" : "新建章",
                  "icon" : "fa fa-folder-o",
                  "action": function (data) {
                    addFolder();
                  }
              };
          } else if (type == "folder") {
              cxtmenus['add_file'] = {
                  "label" : "新建节",
                  "icon" : "fa fa-file-o",
                  "action": function (data) {
                      addFile();
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
          "children": chapterArr
      }],
      'themes': {
          'name': 'proton',
          'responsive': true
      }
  }
});

$.vakata.context.settings.hide_onmouseleave = 100;

function addFolder() {
  var cns = $('#chapter_tree').jstree('get_selected', true);
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
          content: '/course-chapter/create?course_id='+<?= $course->id; ?>
      });
  }
}

function addFile() {
    var cns = $('#chapter_tree').jstree('get_selected', true);
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
            content: '/course-section/create'+'?chapter_type=1&parent_id='+pid+'&course_id=17',
        });
    }
}

function editChapter() {
    var cns = $('#chapter_tree').jstree('get_selected', true);
    if (cns != null && cns.length > 0) {
        var cn = cns[0];
        
        layer.open({
            type: 2,
            title: '编辑',
            shadeClose: false,
            shade: [0.5, '#000'],
            maxmin: false,
            area: ['600px', '450px'],
            content: '/course-chapter/update?chapter_id='+cn.state.cid+'&chapter_type='+(cn.type=='folder'?'0':'1')
        });
    }
}

function deleteChapter() {
  var cns = $('#chapter_tree').jstree('get_selected', true);
  if (cns != null && cns.length > 0) {
      var cn = cns[0];
      layer.open({
          type: 2,
          title: '删除',
          shadeClose: false,
          shade: [0.5, '#000'],
          maxmin: false,
          area: ['400px', '200px'],
          content: '/course-chapter/delete'+'?delete='+cn.state.cid,
          end: function() {
            location.reload();
          }
      });
  }
}
</script>
