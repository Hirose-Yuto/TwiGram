function jump(twig_url) {
    location.href = twig_url;
}

function replyBox(twig_id) {
    let replyBoxElement = document.getElementById("reply_input_"+twig_id);
    let retwigBoxElement = document.getElementById("retwig_input_" + twig_id);
    if(replyBoxElement.style.display === "none") {
        replyBoxElement.style.display = "";
        if(retwigBoxElement.style.display !== "none") {
            retwigBoxElement.style.display = "none";
        }
    } else {
        replyBoxElement.style.display = "none";
    }
}

function retwigBox(twig_id) {
    let retwigBoxElement = document.getElementById("retwig_input_" + twig_id);
    let replyBoxElement = document.getElementById("reply_input_"+twig_id);
    if(retwigBoxElement.style.display === "none") {
        retwigBoxElement.style.display = "";
        if(replyBoxElement.style.display !== "none") {
            replyBoxElement.style.display = "none";
        }
    } else {
        retwigBoxElement.style.display = "none";
    }
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
            let like_num = document.getElementById("twig_like_num_" + twig_id);
            if(like_element.style.color === "black") {
                like_element.style.color = "#DB4437"
                like_num.style.color = "#DB4437"
                like_num.innerText = String(parseInt(like_num.innerText, 10) + 1);
            } else {
                like_element.style.color = "black"
                like_num.style.color = "black"
                like_num.innerText = String(parseInt(like_num.innerText, 10) - 1);
            }
            // 見た目上1増やす or 減らす

        })
}
