import ClassicEditor from "../vendor/plugins/ckeditor.js";
var ready = (callback) => {
    if (document.readyState != "loading") callback();
    else document.addEventListener("DOMContentLoaded", callback);
};

ready(() => {
    ClassicEditor.create(document.querySelector(".wysiwyg")).catch((error) => {
        //console.log(`error`, error)
    });
});
