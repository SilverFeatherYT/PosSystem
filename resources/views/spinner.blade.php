<html>

<body>
    <div class="loader-wrapper">
        <span class="loader"><span class="loader-inner"></span></span>
    </div>
</body>

<style>
    .loader-wrapper {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background-color: #cfe8ff;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader {
        display: inline-block;
        width: 30px;
        height: 30px;
        position: relative;

        border: 4px solid #Fff;
        animation: spin 2s infinite ease;
    }

    @keyframes spin {
        from {
            transform: rotate(0turn);
        }

        to {
            transform: rotate(1turn);
        }
    }

    .spinner {
        animation: spin 1000ms;
        animation-timing-function: linear;
        animation-iteration-count: infinite;

        display: block;
        width: 100px;
        height: 100px;

    }
</style>

<script>
    $(window).on("load", function() {
        $(".loader-wrapper").fadeOut("slow");
    });
</script>

</html>