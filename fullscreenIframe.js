document.addEventListener("DOMContentLoaded", function() {
// Set initial height
setIframeHeight();

// Update iframe height when the window is resized
window.addEventListener("resize", setIframeHeight);
});

function setIframeHeight() {
    var iframe = document.getElementById("fullscreenIframe");
    var reducedHeight = window.innerHeight * 0.85; // ลดลง 20%
    iframe.style.height = reducedHeight + "px";
    // iframe.style.height = window.innerHeight + "px";
}

function setIframeSource(src) {
var iframe = document.getElementById("fullscreenIframe");
iframe.src = src;
setIframeHeight();
}
