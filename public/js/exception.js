/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/exception.js ***!
  \***********************************/
document.addEventListener('DOMContentLoaded', function () {
  var exception = document.getElementById("exception");
  var exceptionHeight = exception.getBoundingClientRect().bottom - exception.getBoundingClientRect().top;
  var exceptionWidth = exception.getBoundingClientRect().right - exception.getBoundingClientRect().left;
  exception.style.top = window.innerHeight - exceptionHeight - 10 + "px";
  exception.style.left = window.innerWidth / 2 - exceptionWidth / 2 + "px";
});
/******/ })()
;