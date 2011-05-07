function smoothstep(min, max, v) {
    if (v < min) return 0;
    if (v >=max) return 1;
    v = (v-min) / (max-min); 
    return v*v * (3-2*v);
}

var STEP = 10; // milliseconds

function resize(id, width, height, seconds) {
    // Resizes the element with the given id to the given width and height.
    if ($(id)._busy1) return;
    f1 = function(id, w1, w2, h1, h2, dt, t) {
        e = $(id);
        e.style.width = w1 + (w2-w1) * smoothstep(0, 1, dt/t) + "px";
        e.style.height = h1 + (h2-h1) * smoothstep(0, 1, dt/t) + "px";
        e._busy1 = dt < t;
        if (e._busy1) setTimeout(
            "f1('"+id+"',"+w1+","+w2+","+h1+","+h2+","+(dt+STEP)+","+t+");", STEP);
    }
    f1(id, parseFloat($(id).style.width), width, 
           parseFloat($(id).style.height), height, 0, 1000 * (seconds||0.25));
}

function fade(id, opacity, seconds) {
    // Fades the element with given id to the given opacity.
    if ($(id)._busy2) return;
    f2 = function(id, o1, o2, dt, t) {
        e = $(id);
        e.style.opacity = o1 + (o2-o1) * smoothstep(0, 1, dt/t);
        e.style.filter = "alpha(opacity=" + parseInt(10 * e.style["opacity"]) + ")";
        e._busy2 = dt < t;
        if (e._busy2) setTimeout(
            "f2('"+id+"',"+o1+","+o2+","+(dt+STEP)+","+t+");", STEP);
    }
    f2(id, parseFloat($(id).style.opacity), opacity||0, 0, 1000 * (seconds||0.25));
}