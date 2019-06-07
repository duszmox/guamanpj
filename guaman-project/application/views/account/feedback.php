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
    p {
    word-break: break-all;
        white-space: -moz-pre-wrap;
        white-space: pre-wrap;
        font-family: 'Roboto', sans-serif;
        color: gray;

    }
    a {
    word-break: break-all;
        white-space: -moz-pre-wrap;
        white-space: pre-wrap;
        font-family: 'Roboto', sans-serif;
        color: gray;
        text-decoration: none;

    }
    .create-date {
    display: inline;
}
    .create-profile {
    display: inline;
}
</style>



<div class="article">
    <h1 class="title">Patch Notes v.0.2.4</h1>
    <p>Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg Szöveg</p>
    <hr>
    <p class="create-date">Posted at: 2000:01:01</p>
    <a style="float:right;" href="#" class="create-profile">Admin</a>


</div>
<?php
foreach($data as $key => $value){
    echo "<div class=\"article\">
    <h1 class=\"title\">".$value['title']."</h1>
    <p>
    ".$value['content']."
    </p>
    <hr>
    <p class=\"create-date\">Posted at: ".$value['date']."</p>
    <a style=\"float:right;\" href=\"#\" class=\"create-profile\">".$value['author']."</a>


</div>";
}
?>

