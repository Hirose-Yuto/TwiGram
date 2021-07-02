function jump(twig_url) {
    location.href = twig_url;
}

function replyBox(twig_id) {

}

function retwigBox(twig_id) {

}

function like(twig_id, user_id, token) {
    $.post("/twig/like/",
        {
            twig_id : twig_id,
            user_id : user_id,
            _token : token,
        },
        function (data, textStatus, jqXHR) {
            let like_element = document.getElementById("twig_like_text_" + twig_id);
            if(like_element.style.color === "black") {
                like_element.style.color = "#DB4437"
            } else {
                like_element.style.color = "black"
            }
            // 見た目上1増やす or 減らす
        })
}
