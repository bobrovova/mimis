(function(){
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        removeImage = function (idImage) {
            $.ajax({
                method: "POST",
                url: "index.php?r=images/delete",
                data: {
                    id: idImage,
                    _csrf: csrfToken
                }
            }).done(function( msg ) {
                return true;
            });
        }

        $('.glyphicon-remove').click(function () {
            that = $(this);
            imageId = that.data().imageId;
            removeImage(imageId)
            that.parent().remove();
            $(".mainSlider [data-image-id='"+imageId+"']").remove();
        });
    });
})();
