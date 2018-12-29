/**
 * Handle the click on a like button.
 */
$(document).ready( function() {
    $(".js-like").click(function(event) {
        
        const likeElt = this;
        event.preventDefault();
        
        $.get(this.href, function () {

            let iconElt = likeElt.querySelector('.js-icon-like');
            let textElt = likeElt.querySelector('.js-like-text');
            
            if(iconElt.classList.contains('icon-heart')){
                iconElt.classList.replace('icon-heart', 'icon-heart2');
                textElt.innerHTML = "J'aime";
            }
            
            else{
                iconElt.classList.replace('icon-heart2', 'icon-heart');
                textElt.innerHTML = "Je n'aime plus";
            }
        
        }).fail(function () {
            alert("Une erreur s'est produite");
        })
    })

});
