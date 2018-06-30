/**
 * Created by minyi on 2018/6/30.
 */
//图片欣赏
function C_slider(frame,list,Lframe,Llist,forwardEle,backEle,scrollType,LscrollType,acitonType,autoInterval){
    this.frame = frame;
    this.list = list;
    this.Lframe = Lframe;
    this.Llist = Llist;
    this.forwardEle = forwardEle;
    this.backEle = backEle;
    this.scrollType = scrollType;
    this.LscrollType = LscrollType;
    this.acitonType = acitonType;
    this.autoInterval = autoInterval;
    this.slideLength = $("#"+this.Llist+" > li").length;//总的slider数量
    this.currentSlide = 0;
    this.FrameHeight = $("#"+this.frame).height();
    this.FrameWidth = $("#"+this.frame).width();
    this.lFrameHeight = $("#"+this.Lframe).height();
    this.lFrameWidth = $("#"+this.Lframe).width();
    this.lListHeight = $("#"+this.Llist+" >li").eq(0).outerHeight(true);
    this.lListWidth = $("#"+this.Llist+" >li").eq(0).outerWidth(true);
    var self = this;
    for(var i = 0; i<this.slideLength; i++) {
        $("#"+this.Llist+" > li").eq(i).data("index",i);
        $("#"+this.Llist+" > li").eq(i).bind(this.acitonType,function(){
            self.go($(this).data("index"));
        });
    };
    //给"上一个"、"下一个"按钮添加动作
    $("#"+this.forwardEle).bind('click',function(){
        self.forward();
        return false;
    });
    $("#"+this.backEle).bind('click',function(){
        self.back();
        return false;
    });
    //定论鼠标划过时，自动轮换的处理
    $("#"+this.frame+",#"+this.Lframe+",#"+this.forwardEle+",#"+this.backEle).bind('mouseover',function(){
        clearTimeout(self.autoExt);
    });
    $("#"+this.frame+",#"+this.Lframe+",#"+this.forwardEle+",#"+this.backEle).bind('mouseout',function(){
        clearTimeout(self.autoExt);
        self.autoExt = setTimeout(function(){
            self.extInterval();
        },self.autoInterval);
    });
    //开始自动轮换
    this.autoExt = setTimeout(function(){
        self.extInterval();
    },this.autoInterval);
}
//执行运动
C_slider.prototype.go = function(index){
    this.FrameWidth = $("#"+this.frame).width();
    this.currentSlide = index;
    if (this.scrollType == "left"){
        $("#"+this.list).animate({
            marginLeft: (-index*this.FrameWidth)+"px"
        }, {duration:600,queue:false});
    } else if (this.scrollType == "top"){
        $("#"+this.list).animate({
            marginTop: (-index*this.FrameHeight)+"px"
        }, {duration:600,queue:false});
    }
    $("#"+this.Llist+" > li").removeClass("current");
    $("#"+this.Llist+" > li").eq(index).addClass("current");
    //对于缩略图的滚动处理
    if(this.LscrollType == "left"){
        this.slideLength = $("#"+this.Llist+" > li").length;
        this.lListWidth = $("#"+this.Llist+" >li").eq(0).outerWidth(true);
        this.lFrameWidth = $("#"+this.Lframe).width();

        if(this.slideLength*this.lListWidth > this.lFrameWidth){
            var spaceWidth = (this.lFrameWidth - this.lListWidth)/2;
            var hiddenSpace = this.lListWidth*this.currentSlide - spaceWidth;
            //alert(hiddenSpace);
            if (hiddenSpace > 0){
                if(hiddenSpace+this.lFrameWidth <= this.slideLength*this.lListWidth){
                    $("#"+this.Llist).animate({
                        marginLeft: -hiddenSpace+"px"
                    }, {duration:600,queue:false});
                } else {
                    var endHidden = this.slideLength*this.lListWidth - this.lFrameWidth;
                    $("#"+this.Llist).animate({
                        marginLeft: -endHidden+"px"
                    }, {duration:600,queue:false});
                }
            } else {
                $("#"+this.Llist).animate({
                    marginLeft: "0px"
                }, {duration:600,queue:false});
            }
        }
    } else if (this.LscrollType == "top"){
        if(this.slideLength*this.lListHeight > this.lFrameHeight){
            var spaceHeight = (this.lFrameHeight - this.lListHeight)/2;
            var hiddenSpace = this.lListHeight*this.currentSlide - spaceHeight;
            if (hiddenSpace > 0){
                if(hiddenSpace+this.lFrameHeight <= this.slideLength*this.lListHeight){
                    $("#"+this.Llist).animate({
                        marginTop: -hiddenSpace+"px"
                    }, {duration:600,queue:false});
                } else {
                    var endHidden = this.slideLength*this.lListHeight - this.lFrameHeight;
                    $("#"+this.Llist).animate({
                        marginTop: -endHidden+"px"
                    }, {duration:600,queue:false});
                }
            } else {
                $("#"+this.Llist).animate({
                    marginTop: "0px"
                }, {duration:600,queue:false});
            }
        }
    }
}
//前进
C_slider.prototype.forward = function(){
    if(this.currentSlide<this.slideLength-1){
        this.currentSlide += 1;
        this.go(this.currentSlide);
    }else {
        this.currentSlide = 0;
        this.go(0);
    }
}
//后退
C_slider.prototype.back = function(){
    if(this.currentSlide>0){
        this.currentSlide -= 1;
        this.go(this.currentSlide);
    }else {
        this.currentSlide = this.slideLength-1;
        this.go(this.slideLength-1);
    }
}
//自动执行
C_slider.prototype.extInterval = function(){
    if(this.currentSlide<this.slideLength-1){
        this.currentSlide += 1;
        this.go(this.currentSlide);
    }else {
        this.currentSlide = 0;
        this.go(0);
    }
    var self = this;
    this.autoExt = setTimeout(function(){
        self.extInterval();
    },this.autoInterval);
}
//实例化对象
var goSlide1 = new C_slider("bigpic","big_list","smallpic","small_list","small_left","small_right","left","left","click",3000);


//首页幻灯片
var h = $(".nytxt4_pic li").length - 1;
var w = $(".nytxt4_pic li").outerWidth(true);
//点击显示对应区块
$(".nytxt4_an code").click(function(){
    $(".nytxt4_an code").removeClass("fdnow");
    $(this).addClass("fdnow");
    var i = $(this).index();
    $(".nytxt4_pic ul").animate({left:-i*w+"px"},300);
})

function checkout(i){  //根据传来的图片索引，调整上一张和下一张小图片
    var index_pre = i - 1;
    var index_next = i + 1;
    if(index_pre<0){index_pre = h;}
    if(index_next>h){index_next = 0;}
}

function ImgPlayer (){
    //内部方法，主要功能就是负责 左右切换,dir表示方向，l :左， r:右，不传默认为右
    var qh = function(dir){
        if(!dir){
            dir = "r";
        }
        var index = $(".nytxt4_an code[class='fdnow']").index();
        if(dir == 'r'){
            index ++;
            if(index>h){index = 0}
        }else{
            index --;
            if(index<0){index = h}
        }
        $(".nytxt4_an code").removeClass("fdnow").eq(index).addClass("fdnow");
        $(".nytxt4_pic ul").animate({left:-index*w+"px"},300);

        checkout(index);//调整上一个和下一个的图片
    }

    //一个标志变量，用于接受 setInterval 返回值，用来控制是否暂停循环
    this.timeout = null;
    //循环播放方法 每隔2500ms切换一次，可以修改间隔时间
    this.play = function(){
        this.timeout = setInterval(function(){qh()},3500);
    }

    //停掉循环
    this.stop = function(){
        window.clearTimeout(this.timeout);
    }
    //播放下一个，这个时候就是先停掉当前循环，立马切换到下一个。然后再重新开始循环
    this.next = function(){
        this.stop();
        qh();
        this.play();
    }
    //同上，只是回到上一个
    this.pre = function(){
        this.stop();
        qh('l');
        this.play();
    }
}
var imgPlayer = new ImgPlayer();
imgPlayer.play();
checkout(0); //初始化下一张和上一张小图片