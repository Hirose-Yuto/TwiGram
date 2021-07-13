$(function () {
    $('[data-toggle="popover"]').popover({
        content: function () {
            const contentDivId = '#' + $(this).data('content_div_id');
            const twig_id = new RegExp("\\d+").exec(contentDivId)[0];
            let content = `
            <div class="list-group">
                <div class="list-group-item list-group-item-action" id="twig_delete_${twig_id}">
                    delete
                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            `
            $(document).on('click', '#twig_delete_'+twig_id, function (){
                if(confirm("Are you sure to delete this twig?")) {
                    $.post("/twig/delete/", {
                        twig_id:twig_id,
                        _token : $('meta[name="csrf-token"]').attr('content')
                    }, function () {
                        location.reload()
                    })
                }
            })
            return content;
        }
    })
})
const popover = new bootstrap.Popover(document.querySelector('.popover-dismiss'), {
    trigger: 'focus'
});
const myModal = document.getElementById('myModal');
const myInput = document.getElementById('myInput');

myModal.addEventListener('shown.bs.modal', function () {
    myInput.focus()
})

function doNothing(e) {
    e.stopPropagation();
}

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

function like(twig_id, token) {
    $.post("/twig/like/",
        {
            twig_id : twig_id,
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
