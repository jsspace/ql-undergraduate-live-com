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
  chapters.push({'chapter_id':'9','parent_id':'0','name':'电视新闻节目创优','chapter_type':'folder'});
  chapters.push({'chapter_id':'339','parent_id':'0','name':'1','chapter_type':'file'});
  chapters.push({'chapter_id':'184','parent_id':'9','name':'第1讲','chapter_type':'file'});
  chapters.push({'chapter_id':'340','parent_id':'0','name':'2','chapter_type':'folder'});
  chapters.push({'chapter_id':'185','parent_id':'9','name':'第2讲','chapter_type':'file'});
  chapters.push({'chapter_id':'186','parent_id':'9','name':'第3讲','chapter_type':'file'});
  chapters.push({'chapter_id':'187','parent_id':'9','name':'第4讲','chapter_type':'file'});
  chapters.push({'chapter_id':'188','parent_id':'9','name':'第5讲','chapter_type':'file'});
  chapters.push({'chapter_id':'189','parent_id':'9','name':'第6讲','chapter_type':'file'});
  chapters.push({'chapter_id':'190','parent_id':'9','name':'第7讲','chapter_type':'file'});
  chapters.push({'chapter_id':'191','parent_id':'9','name':'第8讲','chapter_type':'file'});


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

              cxtmenus['add_file'] = {
                  "label" : "新建节",
                  "icon" : "fa fa-file-o",
                  "action": function (data) {
                      addFile();
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
          "text": "电视新闻节目创优",
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
          content: 'http://admin.ql.com/course-chapter/create'
      });
  }
}

function addFile() {
    var cns = $('#chapter_tree').jstree('get_selected', true);
    console.log(cns);
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
            content: 'http://www.mediatalk.cn/admin/coursechapters/edit'+'?chapter_type=1&parent_id='+pid+'&course_id=17'
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
            content: 'http://www.mediatalk.cn/admin/coursechapters/edit?modify='+cn.state.cid+'&chapter_type='+(cn.type=='folder'?'0':'1')
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
          content: 'http://www.mediatalk.cn/admin/coursechapters/edit'+'?delete='+cn.state.cid,
          end: function() {
            location.reload();
          }
      });
  }
}
</script>
