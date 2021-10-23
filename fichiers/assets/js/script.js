$(document).ready(function(){

    Dropzone.options.dropzoneFrom = {
        autoProcessQueue: false,
        acceptedFiles : "",
        init: function(){
            var submitButton = document.querySelector('#submit-all');
            myDropzone = this;
            submitButton.addEventListener("click", function(){
                myDropzone.processQueue();
            });
            this.on("complete", function(){
                if ( this.getQueueFiles().length == 0 && this.getUploadingFiles().length == 0 ) {
                    var _this = this;
                    _this.removeAllFiles();
                }
            });
        }
    }
});