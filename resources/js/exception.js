document.addEventListener('DOMContentLoaded', function() {
    let exception = document.getElementById("exception");
    let exceptionHeight = exception.getBoundingClientRect().bottom - exception.getBoundingClientRect().top;
    let exceptionWidth = exception.getBoundingClientRect().right - exception.getBoundingClientRect().left;

    exception.style.top = window.innerHeight - exceptionHeight - 10 + "px";
    exception.style.left = window.innerWidth/2 - exceptionWidth/2 + "px";
});
