//form validity check
function validate_required(field)
{
with (field)
  {
  	if (value==null||value=="")
	{
		alert("This field must be filled!");
		return false;
		
	}
	else
	{
		return true;
	}
  }
}

//Codes from internet(http://www.cnblogs.com/bluedream2009/archive/2010/07/03/1770578.html)
//for pic scroller in homepage

var QQ = function() {
    function T$(id) { return document.getElementById(id); }
    function T$$(root, tag) { return (root || document).getElementsByTagName(tag); }
    function $extend(des, src) { for(var p in src) { des[p] = src[p]; } return des; }
    function $each(arr, callback, thisp) {
        if (arr.forEach) {arr.forEach(callback, thisp);} 
        else { for (var i = 0, len = arr.length; i < len; i++) callback.call(thisp, arr[i], i, arr);}
    }
    function currentStyle(elem, style) {
        return elem.currentStyle || document.defaultView.getComputedStyle(elem, null);
    }
    
    var Tween = {
        Quart: {
            easeOut: function(t,b,c,d){
                return -c * ((t=t/d-1)*t*t*t - 1) + b;
            }
        },
        Back: {
            easeOut: function(t,b,c,d,s){
                if (s == undefined) s = 1.70158;
                return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
            }
        },
        Bounce: {
            easeOut: function(t,b,c,d){
                if ((t/=d) < (1/2.75)) {
                    return c*(7.5625*t*t) + b;
                } else if (t < (2/2.75)) {
                    return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
                } else if (t < (2.5/2.75)) {
                    return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
                } else {
                    return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
                }
            }
        }
    }

    var scrollTrans = function(cid, sid, count, config) {
        var self = this;
        if (!(self instanceof scrollTrans)) {
            return new scrollTrans(cid, sid, count, config);
        } 
        self.container = T$(cid);
        self.scroller = T$(sid);
        if (!(self.container || self.scroller)) { 
            return;
        } 
        self.config = $extend(defaultConfig, config || {});
        self.index = 0;
        self.timer = null;
        self.count = count;
        self.step = self.scroller.offsetWidth / count;
    };
    
    var defaultConfig = {
        trigger: 1, // click other: mouseover
        auto: true, // whether auto change
        tween: Tween.Quart.easeOut, // default move
        Time: 10, // delay time
        duration: 60,   // change time
        pause: 5000, // pause time
        start: function() {},
        end: function() {} 
    };

    scrollTrans.prototype = {
        constructor: scrollTrans,
        transform: function(index) {
            var self = this;
            index == undefined && (index = self.index);
            index < 0 && (index = self.count - 1) || index >= self.count && (index = 0);            
            self.time = 0;
            self.target = -Math.abs(self.step) * (self.index = index);
            self.begin = parseInt(currentStyle(self.scroller)['left']);
            self.change = self.target - self.begin;
            self.duration = self.config.duration;
            self.start();
            self.run();
        },

        run: function() {
            var self = this;
            clearTimeout(self.timer);
            if (self.change && self.time < self.duration) {
                self.moveTo(Math.round(self.config.tween(self.time++, self.begin, self.change, self.duration)));
                self.timer = setTimeout(function() {self.run()}, self.config.Time);
            } else {
                self.moveTo(self.target);
                self.config.auto && (self.timer = setTimeout(function() {self.next()}, self.config.pause));
            }
        },

        moveTo: function(i) {
            this.scroller.style.left = i + 'px';
        },

        next: function() {
            this.transform(++this.index);
        }
    };

    return {
        scroll: function(cid, sid, count, config) {
                window.onload = function() {
                    var frag = document.createDocumentFragment(),
                        nums = [];
                    for (var i = 0; i < count; i++) {
                        var li = document.createElement('li');
                        (nums[i] = frag.appendChild(document.createElement('li'))).innerHTML = i + 1;
                    }
                    T$('page').appendChild(frag);

                    var st = scrollTrans(cid, sid, count, config);
                    $each(nums, function(o, i) {
                        o[st.config.trigger == 1 ? 'onclick' : 'onmouseover'] = function() { o.className = 'on'; st.transform(i); }
                        o.onmouseout = function() { o.className = ''; st.transform();}
                    });
                    st.start = function() {
                        $each(nums, function(o, i) {
                            o.className = st.index == i ? 'on' : '';
                        }); 
                    };
                    st.transform();
                }
        }
    }
}();