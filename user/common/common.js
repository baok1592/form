function dianji(fn) {
    let that = this;
    if (that.onoff) {
        that.onoff = false;
        fn();
        setTimeout(function () {
            that.onoff = true;
        })
    } else {
        //如果一直走else分支可能是你没有在页面的data下面挂载onoff:true,不然一直都会走else
        console.log("请稍后点击")
    }
}
export {
    dianji
}