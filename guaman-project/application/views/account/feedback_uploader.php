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
    .text-input{
        width:100%;
        border-radius: 10px;
    }
    .textarea-input{
        width:100%;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
    }

</style>





<div class="search-div">

    <div class="uploader-div">
        <button class="btn btn-black btn-info" id="add-post">
            Back
        </button>
    </div>
</div>
<div class="article">
    <form action="" method="post">
        <label for="textarea-input">Title:</label> <!-- todo lang-->
        <input type="text" name="title" class="text-input" id="text-input" placeholder="Title"><br>
        <textarea name="content" class="textarea-input" id="textarea-input" rows="15" placeholder="Content"></textarea>
        <input type="submit" class="btn btn-primary">

    </form>


</div>