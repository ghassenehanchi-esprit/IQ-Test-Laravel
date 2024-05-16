<div class="preloader" id="preloader">
    <div class="loader-frame">
        <span class="loader"></span>    </div>
</div>
<a href="#0" class="scrollToTop"><i class="la la-angle-up"></i></a>
<div class="overlay" id="content" style="display:none;">
    <!-- Your content goes here -->
</div>

<script>
    var loader;

    function hidePreloader() {
        loader.style.display = 'none';
        document.getElementById('content').style.display = 'block';
    }

    document.addEventListener("DOMContentLoaded", function() {
        loader = document.getElementById('preloader');
        document.getElementById('loaderGif').addEventListener('load', hidePreloader);
    });
</script>
<style>

.loader {
width: 48px;
height: 48px;
border-radius: 50%;
display: inline-block;
border-top: 4px solid #FFF;
border-right: 4px solid transparent;
box-sizing: border-box;
animation: rotation 1s linear infinite;
}
.loader::after {
content: '';
box-sizing: border-box;
position: absolute;
left: 0;
top: 0;
width: 48px;
height: 48px;
border-radius: 50%;
border-left: 4px solid #28df99;
border-bottom: 4px solid transparent;
animation: rotation 0.5s linear infinite reverse;
}
@keyframes rotation {
0% {
transform: rotate(0deg);
}
100% {
transform: rotate(360deg);
}
}
</style>
