<!doctype html>

<title>Site On Maintenance</title>

<style>
    body {

        font: 20px Helvetica, sans-serif;

        background-color: rgba(26, 32, 44, 1);

        text-align: center;

        padding: 0px 150px;

        margin: 0px ;
    }

    article {

        display: flex;

        align-items: center;

        justify-content: center;

        text-align: left;

        width: 650px;

        margin: 0 auto;

        height: 100vh;

    }

    article h1 {

        font-size: 50px;

        margin-bottom: 15px ; 
    }

    article h1,

    article p {

        color: #a0aec0;

        margin-top:0px; 
    }

    .text-center {
        text-align: center;
    }

    .w-100{
        width: 100%;
    }
</style>

<article>

    <div class="text-center">
        <img src="{{ url(env('ASSETPATHURL') . 'front/images/store_maintenance.png') }}" alt="store maintenance" class="w-100">
        <h1>We'll be back soon!</h1>
        <p>Sorry for the inconvenience but we are performing some maintenance at the moment. we will be back online
            shortly!</p>

    </div>


</article>
