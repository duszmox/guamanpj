<?php
?>

<style>
    div.article {
        margin-left: 190px;
        margin-right: 190px;
        margin-top: 20px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        padding: 50px;
        border-radius: 10px;
        border: 1px #D3D3D3 solid;

    }

    h1.title {
        font-family: 'Roboto', sans-serif;
        font-weight: bolder;
        margin-bottom: 50px;
        color: gray;

    }

    p.content, p.create-date {
        word-break: break-all;
        white-space: -moz-pre-wrap;
        white-space: pre-wrap;
        font-family: 'Roboto', sans-serif;
        color: gray;

    }

    a.creator-profile {
        word-break: break-all;
        white-space: -moz-pre-wrap;
        white-space: pre-wrap;
        font-family: 'Roboto', sans-serif;
        color: gray;
        text-decoration: none;
        display: inline;
        float: right;

    }

    .create-date {
        display: inline;
    }

    .effect-15 {
        border: 0;
        padding: 7px 15px;
        border: 1px solid #ccc;
        position: relative;
        background: transparent;
        margin-left: 190px;
    }

    .effect-15 ~ .focus-bg:before,
    .effect-15 ~ .focus-bg:after {
        content: "";
        position: absolute;
        left: 50%;
        top: 50%;
        width: 0;
        height: 0;
        background-color: #ededed;
        transition: 0.3s;
        z-index: -1;
    }

    .effect-15:focus ~ .focus-bg:before {
        transition: 0.3s;
        width: 50%;
        left: 0;
        top: 0;
        height: 100%;
    }

    .effect-15 ~ .focus-bg:after {
        left: auto;
        right: 50%;
        top: auto;
        bottom: 50%;
    }

    .effect-15:focus ~ .focus-bg:after {
        transition: 0.3s;
        width: 50%;
        height: 100%;
        bottom: 0;
        right: 0;
    }

    .invisible {
        display: none;
    }

    .uploader-div {

        float: right;
        margin-right: 190px;
        margin-bottom: 40px;
    }


</style>


<!-- Simple form
<div class="article">
    <h1 class="title">Patch Notes v.0.2.4</h1>
    <p>Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg</p>
    <hr>
    <p class="create-date">Posted at: 2000:01:01</p>
    <a style="float:right;" href="#" class="create-profile">Admin</a>


</div>

-->
<div class="search-div">
    <input class="effect-15" id="searchInput" type="text" placeholder="Keresés..."><!--todo lang-->
    <span class="focus-bg"></span>
    <div class="uploader-div">
        <button class="btn btn-black btn-info" id="add-post">
            Add
        </button>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('input#searchInput').on('input', function (e) {
            if ($("input#searchInput").val().length > 3) {
                $("div.article").each(function (i, element) {
                    if (element.textContent.indexOf(e.target.value) === -1) {
                        $("div.article").eq(i).addClass("invisible");
                    } else {
                        $("div.article").eq(i).removeClass("invisible");
                    }
                });
            }
        });
        var fuggveny = (async function getTitle() {
            const {value: title} = await Swal.fire({
                title: 'Enter title',
                input: 'text',
                inputPlaceholder: 'Enter Title',
                inputAttributes: {
                    maxlength: 10,
                    autocapitalize: 'off',
                    autocorrect: 'off'
                }
            });
        );
    });
        var content_function = (async function () {
            const {value: content} = Swal.fire({
                title: 'Enter Content',
                input: 'textarea',

                inputPlaceholder: 'Enter Content',
                inputAttributes: {

                    autocapitalize: 'off',
                    autocorrect: 'off'
                }
            })
        });


        if (title && content) {
            Swal.fire('Entered title: ' + title).then(function () {
                Swal.fire('Entered Content : ' + content);
            });

        }




    $("#add-post").click(function () {
        fuggveny();
        content_function();
    });

    })
</script>
<?php
foreach ($data as $key => $value) {
    echo "<div class=\"article\" id='article-" . $value['id'] . "'>
    <h1 class=\"title\">" . $value['title'] . "</h1>
    <p class='content'>
    " . $value['content'] . "
    </p>
    <hr>
    <p class=\"create-date\">Posted at: " . $value['date'] . "</p>
    <a  href=\"#\" class=\"creator-profile\">" . $value['author'] . "</a>


</div>";
}
?>

