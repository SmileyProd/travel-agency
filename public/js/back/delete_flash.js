$(document).ready( function() {
    $('.flash-notice').each(function () {
        flashElt = this;
        setTimeout(function() {
            flashElt.remove();
        }, 3000)
    })
})